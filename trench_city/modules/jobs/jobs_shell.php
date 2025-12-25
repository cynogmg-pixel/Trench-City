<?php
/**
 * ===============================================================
 * TRENCH CITY - GYM TRAINING SYSTEM (Torn-exact: focus + gym EXP)
 * ===============================================================
 * Adds Torn-like behaviour:
 * - Global Gym EXP per user (user_gym_progress.gym_exp)
 * - Gyms unlock by gym_exp_required (plus optional cash/bank)
 * - Per-stat focus multipliers (strength_mult/defense_mult/speed_mult/dexterity_mult)
 * - Per-gym exercise labels (ex_strength/ex_defense/ex_speed/ex_dexterity)
 *
 * Tables used:
 * - gyms (extended)
 * - gym_unlocks (still used; auto-populated when exp reached)
 * - user_gym_progress (new)
 * - training_logs
 * - player_stats
 * - player_bars
 * - users
 * ===============================================================
 */

require_once __DIR__ . '/../../core/bootstrap.php';
requireLogin();

global $db;

$userId = currentUserId();
$user   = getUser($userId);
$stats  = getUserStats($userId);
$bars   = getUserBars($userId);

if (!$user || !$stats || !$bars) {
    header('Location: /dashboard.php');
    exit;
}

$successMessage = '';
$errorMessage   = '';
$trainingResult = null;

/**
 * Helpers
 */
function tcClampInt($v, int $min, int $max): int {
    $n = (int)$v;
    if ($n < $min) return $min;
    if ($n > $max) return $max;
    return $n;
}

function tcIsValidStatType(string $t): bool {
    return in_array($t, ['strength', 'speed', 'defense', 'dexterity'], true);
}

function tcStatLabel(string $t): string {
    return match ($t) {
        'strength'  => 'Strength',
        'defense'   => 'Defense',
        'speed'     => 'Speed',
        'dexterity' => 'Dexterity',
        default     => ucfirst($t),
    };
}

function tcStatDesc(string $t): string {
    return match ($t) {
        'strength'  => 'Damage you make on impact',
        'defense'   => 'Ability to withstand damage',
        'speed'     => 'Chance of hitting opponent',
        'dexterity' => 'Ability to evade an attack',
        default     => '',
    };
}

function tcGymMultKeyForStat(string $t): string {
    return match ($t) {
        'strength'  => 'strength_mult',
        'defense'   => 'defense_mult',
        'speed'     => 'speed_mult',
        'dexterity' => 'dexterity_mult',
        default     => 'strength_mult',
    };
}

function tcGymExerciseKeyForStat(string $t): string {
    return match ($t) {
        'strength'  => 'ex_strength',
        'defense'   => 'ex_defense',
        'speed'     => 'ex_speed',
        'dexterity' => 'ex_dexterity',
        default     => 'ex_strength',
    };
}

/**
 * Ensure user_gym_progress row exists
 */
$ugp = $db->fetchOne("SELECT user_id, gym_exp FROM user_gym_progress WHERE user_id = :uid LIMIT 1", ['uid' => $userId]);
if (!$ugp) {
    $db->execute("INSERT INTO user_gym_progress (user_id, gym_exp, updated_at) VALUES (:uid, 0, NOW())", ['uid' => $userId]);
    $ugp = ['user_id' => $userId, 'gym_exp' => 0];
}
$userGymExp = (int)($ugp['gym_exp'] ?? 0);

/**
 * Fetch gyms + unlocks
 */
$gyms = $db->fetchAll("SELECT * FROM gyms ORDER BY gym_exp_required ASC, tier ASC, id ASC");

$unlockedGymIds = [];
$unlockedGyms = $db->fetchAll(
    "SELECT gym_id FROM gym_unlocks WHERE user_id = :user_id",
    ['user_id' => $userId]
);
foreach ($unlockedGyms as $unlock) {
    $unlockedGymIds[] = (int)$unlock['gym_id'];
}

/**
 * Torn-like unlock rule:
 * - tier 1 always unlocked
 * - else unlocked if:
 *   - gym_exp_required <= userGymExp
 *   - AND (if unlock_cost_cash/bank > 0 then user must also have funds OR already unlocked)
 * - We still store unlocks in gym_unlocks for permanence.
 */
function tcGymUnlocked(array $gym, array $unlockedGymIds, int $userGymExp): bool {
    $tier = (int)($gym['tier'] ?? 1);
    if ($tier <= 1) return true;
    $gymId = (int)($gym['id'] ?? 0);
    if ($gymId > 0 && in_array($gymId, $unlockedGymIds, true)) return true;

    $req = (int)($gym['gym_exp_required'] ?? 0);
    return ($userGymExp >= $req);
}

/**
 * Auto-unlock gyms that are now eligible by gym exp (keeps gym_unlocks in sync)
 */
function tcSyncGymUnlocksByExp(array $gyms, array &$unlockedGymIds, int $userGymExp, int $userId, $db): void {
    foreach ($gyms as $g) {
        $tier = (int)($g['tier'] ?? 1);
        if ($tier <= 1) continue;
        $gid = (int)($g['id'] ?? 0);
        if ($gid <= 0) continue;

        $req = (int)($g['gym_exp_required'] ?? 0);
        if ($userGymExp < $req) continue;

        if (!in_array($gid, $unlockedGymIds, true)) {
            $db->execute(
                "INSERT INTO gym_unlocks (user_id, gym_id, unlocked_at) VALUES (:uid, :gid, NOW())",
                ['uid' => $userId, 'gid' => $gid]
            );
            $unlockedGymIds[] = $gid;
        }
    }
}
tcSyncGymUnlocksByExp($gyms, $unlockedGymIds, $userGymExp, $userId, $db);

/**
 * Choose active gym
 */
$activeGym = null;
$requestedGymId = isset($_GET['gym_id']) ? (int)$_GET['gym_id'] : 0;

if ($requestedGymId > 0) {
    foreach ($gyms as $g) {
        if ((int)$g['id'] === $requestedGymId) {
            if (tcGymUnlocked($g, $unlockedGymIds, $userGymExp)) {
                $activeGym = $g;
            }
            break;
        }
    }
}

if (!$activeGym) {
    foreach ($gyms as $g) {
        if (tcGymUnlocked($g, $unlockedGymIds, $userGymExp)) {
            $activeGym = $g;
            break;
        }
    }
}

if (!$activeGym && !empty($gyms)) {
    $activeGym = $gyms[0];
}

/**
 * ===============================================================
 * PROCESS TRAINING ACTION (multi-train + gym EXP)
 * ===============================================================
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'train') {

    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errorMessage = 'Invalid session. Please refresh the page and try again.';
    }

    $gymId      = isset($_POST['gym_id']) ? (int)$_POST['gym_id'] : 0;
    $statType   = isset($_POST['stat_type']) ? trim((string)$_POST['stat_type']) : '';
    $trainTimes = isset($_POST['train_times']) ? (int)$_POST['train_times'] : 1;

    if (empty($errorMessage) && !tcIsValidStatType($statType)) {
        $errorMessage = 'Invalid stat type selected.';
    }

    $gym = null;
    if (empty($errorMessage)) {
        $gym = $db->fetchOne("SELECT * FROM gyms WHERE id = :id LIMIT 1", ['id' => $gymId]);
        if (!$gym) {
            $errorMessage = 'Invalid gym selected.';
        }
    }

    if (empty($errorMessage) && $gym) {
        if (!tcGymUnlocked($gym, $unlockedGymIds, $userGymExp)) {
            $errorMessage = 'This gym is locked. Earn more Gym EXP to unlock it.';
        }
    }

    $energyCost = 0;
    $currentEnergy = (int)($bars['energy_current'] ?? 0);

    if (empty($errorMessage) && $gym) {
        $energyCost = (int)($gym['energy_cost_per_train'] ?? 0);
        if ($energyCost <= 0) {
            $errorMessage = 'Gym configuration error: invalid energy cost.';
        }
    }

    if (empty($errorMessage) && $gym) {
        $maxTrains = (int)floor($currentEnergy / $energyCost);
        if ($maxTrains < 1) {
            $errorMessage = "Not enough energy. You need {$energyCost} energy per train.";
        } else {
            $trainTimes = tcClampInt($trainTimes, 1, min($maxTrains, 100));
        }
    }

    if (empty($errorMessage) && $gym) {
        try {
            $db->beginTransaction();

            $baseGain = (int)($gym['base_stat_gain'] ?? 1);
            $tier     = (int)($gym['tier'] ?? 1);

            // XP per train (kept close to your existing logic)
            $xpPerTrain = 10 + ($tier * 2);

            // Gym EXP per train (Torn-like: 1 per train)
            $gymExpPerTrain = 1;

            $happyCur = (int)($bars['happy_current'] ?? 0);
            $happyMax = (int)($bars['happy_max'] ?? 1);
            $happyMax = max(1, $happyMax);
            $happyBonus = ($happyCur / $happyMax) * 0.20;

            $statBefore = (int)($stats[$statType] ?? 0);
            $statValue  = $statBefore;

            $multKey = tcGymMultKeyForStat($statType);
            $gymStatMult = (float)($gym[$multKey] ?? 1.0);
            if ($gymStatMult <= 0) $gymStatMult = 1.0;

            $totalStatGain = 0;

            // Run each train step so scaling feels real
            for ($i = 0; $i < $trainTimes; $i++) {
                $statGainMultiplier = 1.0;
                if ($statValue < 100) {
                    $statGainMultiplier = 1.5;
                } elseif ($statValue < 1000) {
                    $statGainMultiplier = 1.0;
                } else {
                    $statGainMultiplier = 0.5;
                }

                // Torn-like: gym focus multiplier applies per stat
                $finalMultiplier = $statGainMultiplier * (1 + $happyBonus) * $gymStatMult;

                $gain = max(1, (int)ceil($baseGain * $finalMultiplier));
                $statValue += $gain;
                $totalStatGain += $gain;
            }

            $newStatValue = $statValue;

            $totalEnergySpent = $energyCost * $trainTimes;
            $newEnergy = $currentEnergy - $totalEnergySpent;

            $totalXp = $xpPerTrain * $trainTimes;
            $totalGymExpGain = $gymExpPerTrain * $trainTimes;

            // Update player stats
            $db->execute(
                "UPDATE player_stats SET {$statType} = :new_value WHERE user_id = :user_id",
                ['new_value' => $newStatValue, 'user_id' => $userId]
            );

            // Update energy
            $db->execute(
                "UPDATE player_bars SET energy_current = :energy WHERE user_id = :user_id",
                ['energy' => $newEnergy, 'user_id' => $userId]
            );

            // Award XP
            awardXP($userId, $totalXp);

            // Update gym EXP
            $db->execute(
                "UPDATE user_gym_progress SET gym_exp = gym_exp + :add, updated_at = NOW() WHERE user_id = :uid",
                ['add' => $totalGymExpGain, 'uid' => $userId]
            );

            // Log training session (single row for the batch)
            $db->execute(
                "INSERT INTO training_logs (user_id, gym_id, stat_trained, energy_spent, stat_gain, xp_gained, created_at)
                 VALUES (:user_id, :gym_id, :stat_trained, :energy_spent, :stat_gain, :xp_gained, NOW())",
                [
                    'user_id'      => $userId,
                    'gym_id'       => (int)$gym['id'],
                    'stat_trained' => $statType,
                    'energy_spent' => $totalEnergySpent,
                    'stat_gain'    => $totalStatGain,
                    'xp_gained'    => $totalXp,
                ]
            );

            $db->commit();

            // Refresh values after commit
            $stats = getUserStats($userId);
            $bars  = getUserBars($userId);
            $user  = getUser($userId);

            $ugp = $db->fetchOne("SELECT gym_exp FROM user_gym_progress WHERE user_id = :uid LIMIT 1", ['uid' => $userId]);
            $userGymExp = (int)($ugp['gym_exp'] ?? 0);

            // Re-sync unlocks by exp
            $unlockedGymIds = [];
            $unlockedGyms = $db->fetchAll("SELECT gym_id FROM gym_unlocks WHERE user_id = :user_id", ['user_id' => $userId]);
            foreach ($unlockedGyms as $unlock) $unlockedGymIds[] = (int)$unlock['gym_id'];

            tcSyncGymUnlocksByExp($gyms, $unlockedGymIds, $userGymExp, $userId, $db);

            $trainingResult = [
                'stat'         => tcStatLabel($statType),
                'gain'         => $totalStatGain,
                'new_value'    => $newStatValue,
                'xp_gained'    => $totalXp,
                'energy_spent' => $totalEnergySpent,
                'gym_name'     => (string)($gym['name'] ?? 'Gym'),
                'trains'       => $trainTimes,
                'gym_exp_gain' => $totalGymExpGain,
                'gym_exp_now'  => $userGymExp,
            ];

            $successMessage = "Training complete! +{$totalStatGain} " . tcStatLabel($statType) . " | +{$totalXp} XP | +{$totalGymExpGain} Gym EXP";

            // Keep active gym synced
            $activeGym = $gym;

        } catch (Exception $e) {
            $db->rollBack();
            $errorMessage = 'Training failed. Please try again.';
            tc_log("[GYM] Training error for user {$userId}: {$e->getMessage()}", 'error');
        }
    }
}

/**
 * PROCESS MANUAL GYM UNLOCK (optional cash/bank gate)
 * - If gym exp requirement is met but cash/bank cost exists, this lets player pay to “activate” early if you want it.
 * - If you want pure Torn exp-only unlocks, set unlock_cost_cash/bank = 0 for all gyms.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'unlock') {

    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errorMessage = 'Invalid session. Please refresh the page and try again.';
    }

    $gymId = isset($_POST['gym_id']) ? (int)$_POST['gym_id'] : 0;

    $gym = null;
    if (empty($errorMessage)) {
        $gym = $db->fetchOne("SELECT * FROM gyms WHERE id = :id LIMIT 1", ['id' => $gymId]);
        if (!$gym) {
            $errorMessage = 'Invalid gym selected.';
        }
    }

    if (empty($errorMessage) && $gym) {
        if (tcGymUnlocked($gym, $unlockedGymIds, $userGymExp)) {
            // Already eligible; if not in unlocks yet, sync instead of charging
            if (!in_array((int)$gym['id'], $unlockedGymIds, true) && (int)($gym['tier'] ?? 1) > 1) {
                $db->execute(
                    "INSERT INTO gym_unlocks (user_id, gym_id, unlocked_at) VALUES (:uid, :gid, NOW())",
                    ['uid' => $userId, 'gid' => (int)$gym['id']]
                );
                $unlockedGymIds[] = (int)$gym['id'];
            }
            $successMessage = 'Gym unlocked.';
            $activeGym = $gym;
        } else {
            $errorMessage = 'You do not have enough Gym EXP to unlock this gym yet.';
        }
    }

    if (empty($errorMessage) && $gym) {
        $unlockCostCash = (float)($gym['unlock_cost_cash'] ?? 0);
        $unlockCostBank = (float)($gym['unlock_cost_bank'] ?? 0);
        if ($unlockCostCash <= 0 && $unlockCostBank <= 0) {
            // Exp-only gym; just sync unlocks
            if (!in_array((int)$gym['id'], $unlockedGymIds, true) && (int)($gym['tier'] ?? 1) > 1) {
                $db->execute(
                    "INSERT INTO gym_unlocks (user_id, gym_id, unlocked_at) VALUES (:uid, :gid, NOW())",
                    ['uid' => $userId, 'gid' => (int)$gym['id']]
                );
                $unlockedGymIds[] = (int)$gym['id'];
            }
            $successMessage = 'Gym unlocked.';
            $activeGym = $gym;
        } else {
            // Charge if costs exist
            $userCash = (float)($user['cash'] ?? 0);
            $userBank = (float)($user['bank_balance'] ?? 0);
            if ($userCash < $unlockCostCash || $userBank < $unlockCostBank) {
                $errorMessage = 'Insufficient funds to unlock this gym.';
            } else {
                try {
                    $db->beginTransaction();

                    $newCash = $userCash - $unlockCostCash;
                    $newBank = $userBank - $unlockCostBank;

                    $db->execute(
                        "UPDATE users SET cash = :cash, bank_balance = :bank WHERE id = :user_id",
                        ['cash' => $newCash, 'bank' => $newBank, 'user_id' => $userId]
                    );

                    $db->execute(
                        "INSERT INTO gym_unlocks (user_id, gym_id, unlocked_at) VALUES (:user_id, :gym_id, NOW())",
                        ['user_id' => $userId, 'gym_id' => (int)$gym['id']]
                    );

                    $db->commit();

                    $successMessage = "Gym unlocked successfully! You can now train at {$gym['name']}.";

                    $user = getUser($userId);

                    // refresh unlock list
                    $unlockedGymIds = [];
                    $unlockedGyms = $db->fetchAll("SELECT gym_id FROM gym_unlocks WHERE user_id = :user_id", ['user_id' => $userId]);
                    foreach ($unlockedGyms as $unlock) $unlockedGymIds[] = (int)$unlock['gym_id'];

                    $activeGym = $gym;

                } catch (Exception $e) {
                    $db->rollBack();
                    $errorMessage = 'Failed to unlock gym. Please try again.';
                    tc_log("[GYM] Unlock error for user {$userId}: {$e->getMessage()}", 'error');
                }
            }
        }
    }
}

/**
 * Recent training logs
 */
$recentTraining = $db->fetchAll(
    "SELECT tl.*, g.name as gym_name
     FROM training_logs tl
     INNER JOIN gyms g ON tl.gym_id = g.id
     WHERE tl.user_id = :user_id
     ORDER BY tl.created_at DESC
     LIMIT 10",
    ['user_id' => $userId]
);

$totalStats = (int)($stats['strength'] ?? 0) + (int)($stats['speed'] ?? 0) + (int)($stats['defense'] ?? 0) + (int)($stats['dexterity'] ?? 0);

/**
 * Render
 */
$tc_page_title = 'Gym - Trench City';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);

$activeGymId = (int)($activeGym['id'] ?? 0);
$activeGymName = (string)($activeGym['name'] ?? 'Gym');
$activeEnergyCost = (int)($activeGym['energy_cost_per_train'] ?? 0);
$activeGymClass = (string)($activeGym['gym_class'] ?? '');
$activeMembershipCost = (int)($activeGym['membership_cost_cash'] ?? 0);

$energyCur = (int)($bars['energy_current'] ?? 0);
$energyMax = (int)($bars['energy_max'] ?? 0);
$maxTrainsForActive = ($activeEnergyCost > 0) ? (int)floor($energyCur / $activeEnergyCost) : 0;
$maxTrainsForActive = max(0, min($maxTrainsForActive, 100));

$focusS = (float)($activeGym['strength_mult'] ?? 1.0);
$focusD = (float)($activeGym['defense_mult'] ?? 1.0);
$focusSp = (float)($activeGym['speed_mult'] ?? 1.0);
$focusDx = (float)($activeGym['dexterity_mult'] ?? 1.0);
$maxFocus = max($focusS, $focusD, $focusSp, $focusDx, 0.001);

function tcFocusPct($v, $max): int {
    $p = (int)round(($v / $max) * 100);
    if ($p < 5) $p = 5;
    if ($p > 100) $p = 100;
    return $p;
}

$exS  = (string)($activeGym['ex_strength'] ?? 'Strength');
$exD  = (string)($activeGym['ex_defense'] ?? 'Defense');
$exSp = (string)($activeGym['ex_speed'] ?? 'Speed');
$exDx = (string)($activeGym['ex_dexterity'] ?? 'Dexterity');
?>

<div class="main-content">
    <div class="content-wrapper">

        <div class="content-header">
            <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
                <div>
                    <h1 class="content-title" style="margin-bottom:0.25rem;">Gym</h1>
                    <p class="content-description" style="margin:0;">Train your combat stats. Energy in, power out.</p>
                </div>
                <div style="display:flex; gap:0.75rem; align-items:center; flex-wrap:wrap;">
                    <div style="padding:0.5rem 0.75rem; border:1px solid #374151; border-radius:10px; background:rgba(0,0,0,0.55);">
                        <div style="font-size:0.75rem; color:#9CA3AF; line-height:1;">Energy</div>
                        <div style="font-size:0.95rem; font-weight:800; color:#F9FAFB;"><?php echo (int)$energyCur; ?>/<?php echo (int)$energyMax; ?></div>
                    </div>
                    <div style="padding:0.5rem 0.75rem; border:1px solid rgba(212,175,55,0.55); border-radius:10px; background:rgba(212,175,55,0.28);">
                        <div style="font-size:0.75rem; color:#D1B45A; line-height:1;">Gym EXP</div>
                        <div style="font-size:0.95rem; font-weight:900; color:#D4AF37;"><?php echo number_format($userGymExp); ?></div>
                    </div>
                    <div style="padding:0.5rem 0.75rem; border:1px solid rgba(212,175,55,0.55); border-radius:10px; background:rgba(212,175,55,0.28);">
                        <div style="font-size:0.75rem; color:#D1B45A; line-height:1;">Total Stats</div>
                        <div style="font-size:0.95rem; font-weight:900; color:#D4AF37;"><?php echo number_format($totalStats); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($successMessage): ?>
            <div class="alert alert-success" style="margin-bottom: 1rem;">
                <div class="alert-content"><div class="alert-message"><?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></div></div>
            </div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger" style="margin-bottom: 1rem;">
                <div class="alert-content"><div class="alert-message"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div></div>
            </div>
        <?php endif; ?>

        <?php if ($trainingResult): ?>
            <div class="card" style="margin-bottom: 1rem; border: 2px solid rgba(212,175,55,0.75);">
                <div class="card-header" style="background: linear-gradient(135deg, rgba(0,0,0,0.75) 0%, rgba(30,30,30,0.75) 100%);">
                    <h2 class="card-title" style="color:#D4AF37;">Training Results</h2>
                </div>
                <div class="card-body">
                    <div class="grid grid-3" style="gap: 1rem;">
                        <div style="text-align:center; padding: 1rem; border:1px solid rgba(212,175,55,0.45); background:rgba(212,175,55,0.28); border-radius:12px;">
                            <div style="font-size:2rem; font-weight:900; color:#D4AF37; margin-bottom:0.35rem;">+<?php echo (int)$trainingResult['gain']; ?></div>
                            <div style="font-size:0.85rem; color:#9CA3AF;"><?php echo htmlspecialchars($trainingResult['stat'], ENT_QUOTES, 'UTF-8'); ?></div>
                            <div style="font-size:0.75rem; color:#6B7280; margin-top:0.35rem;"><?php echo (int)$trainingResult['trains']; ?> trains</div>
                        </div>
                        <div style="text-align:center; padding: 1rem; border:1px solid rgba(59,130,246,0.45); background:rgba(59,130,246,0.28); border-radius:12px;">
                            <div style="font-size:2rem; font-weight:900; color:#3B82F6; margin-bottom:0.35rem;">+<?php echo (int)$trainingResult['xp_gained']; ?></div>
                            <div style="font-size:0.85rem; color:#9CA3AF;">Experience</div>
                            <div style="font-size:0.75rem; color:#6B7280; margin-top:0.35rem;">-<?php echo (int)$trainingResult['energy_spent']; ?> energy</div>
                        </div>
                        <div style="text-align:center; padding: 1rem; border:1px solid rgba(16,185,129,0.45); background:rgba(16,185,129,0.28); border-radius:12px;">
                            <div style="font-size:2rem; font-weight:900; color:#10B981; margin-bottom:0.35rem;">+<?php echo (int)$trainingResult['gym_exp_gain']; ?></div>
                            <div style="font-size:0.85rem; color:#9CA3AF;">Gym EXP</div>
                            <div style="font-size:0.75rem; color:#6B7280; margin-top:0.35rem;"><?php echo number_format((int)$trainingResult['gym_exp_now']); ?> total</div>
                        </div>
                    </div>
                    <div style="text-align:center; margin-top:0.9rem; color:#6B7280; font-size:0.8rem;">
                        Trained at <span style="color:#D4AF37; font-weight:900;"><?php echo htmlspecialchars((string)$trainingResult['gym_name'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Active gym header strip (Torn-like) -->
        <div class="card" style="margin-bottom: 1rem;">
            <div class="card-body" style="display:flex; justify-content:space-between; gap:1rem; align-items:flex-start; flex-wrap:wrap;">
                <div style="min-width:280px;">
                    <div style="font-size:0.8rem; color:#9CA3AF; margin-bottom:0.15rem;">You are training at</div>
                    <div style="font-size:1.15rem; font-weight:900; color:#F9FAFB;"><?php echo htmlspecialchars($activeGymName, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div style="font-size:0.8rem; color:#6B7280; margin-top:0.25rem;">
                        <?php if ($activeGymClass !== ''): ?>
                            Class: <span style="color:#F9FAFB; font-weight:800;"><?php echo htmlspecialchars($activeGymClass, ENT_QUOTES, 'UTF-8'); ?></span> •
                        <?php endif; ?>
                        Membership: <span style="color:#D4AF37; font-weight:900;"><?php echo '$' . number_format($activeMembershipCost); ?></span> •
                        Energy usage: <span style="color:#3B82F6; font-weight:900;"><?php echo (int)$activeEnergyCost; ?></span> per train
                        • Max trains: <span style="color:#D4AF37; font-weight:900;"><?php echo (int)$maxTrainsForActive; ?></span>
                    </div>
                </div>

                <div style="flex:1; min-width:260px;">
                    <div style="font-size:0.78rem; color:#9CA3AF; margin-bottom:0.35rem; font-weight:900; letter-spacing:0.05em; text-transform:uppercase;">
                        Gym Focus
                    </div>
                    <div class="tc-focus-grid">
                        <div class="tc-focus-row">
                            <div class="tc-focus-label">Strength</div>
                            <div class="tc-focus-bar"><div class="tc-focus-fill" style="width:<?php echo tcFocusPct($focusS, $maxFocus); ?>%;"></div></div>
                            <div class="tc-focus-ex"><?php echo htmlspecialchars($exS, ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                        <div class="tc-focus-row">
                            <div class="tc-focus-label">Defense</div>
                            <div class="tc-focus-bar"><div class="tc-focus-fill" style="width:<?php echo tcFocusPct($focusD, $maxFocus); ?>%;"></div></div>
                            <div class="tc-focus-ex"><?php echo htmlspecialchars($exD, ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                        <div class="tc-focus-row">
                            <div class="tc-focus-label">Speed</div>
                            <div class="tc-focus-bar"><div class="tc-focus-fill" style="width:<?php echo tcFocusPct($focusSp, $maxFocus); ?>%;"></div></div>
                            <div class="tc-focus-ex"><?php echo htmlspecialchars($exSp, ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                        <div class="tc-focus-row">
                            <div class="tc-focus-label">Dexterity</div>
                            <div class="tc-focus-bar"><div class="tc-focus-fill" style="width:<?php echo tcFocusPct($focusDx, $maxFocus); ?>%;"></div></div>
                            <div class="tc-focus-ex"><?php echo htmlspecialchars($exDx, ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                    </div>
                </div>

                <div style="display:flex; gap:0.75rem; align-items:center; flex-wrap:wrap;">
                    <div style="display:flex; align-items:center; gap:0.5rem; padding:0.5rem 0.75rem; border:1px solid #374151; border-radius:10px; background:rgba(0,0,0,0.45);">
                        <div style="font-size:0.75rem; color:#9CA3AF;">Trains</div>
                        <select id="tcTrainTimesSelect" class="tc-select" <?php echo ($maxTrainsForActive < 1) ? 'disabled' : ''; ?>>
                            <?php if ($maxTrainsForActive < 1): ?>
                                <option value="1">0</option>
                            <?php else: ?>
                                <?php
                                    $preset = [1, 5, 10, 25, 50, 100];
                                    $seen = [];
                                    foreach ($preset as $p) {
                                        if ($p <= $maxTrainsForActive && !isset($seen[$p])) {
                                            $seen[$p] = true;
                                            echo '<option value="' . (int)$p . '">' . (int)$p . '</option>';
                                        }
                                    }
                                    if (!isset($seen[$maxTrainsForActive])) {
                                        echo '<option value="' . (int)$maxTrainsForActive . '">' . (int)$maxTrainsForActive . '</option>';
                                    }
                                ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <a class="btn btn-secondary btn-sm" href="/modules/gym/index.php" style="white-space:nowrap;">Reset</a>
                </div>
            </div>
        </div>

        <!-- 4 Stat training boxes -->
        <div class="card" style="margin-bottom: 1rem;">
            <div class="card-body">
                <div class="tc-train-grid">
                    <?php
                        $statKeys = ['strength','defense','speed','dexterity'];
                        foreach ($statKeys as $k):
                            $val = (int)($stats[$k] ?? 0);
                            $label = tcStatLabel($k);
                            $desc  = tcStatDesc($k);
                            $canTrain = ($maxTrainsForActive >= 1);

                            $exKey = tcGymExerciseKeyForStat($k);
                            $exercise = (string)($activeGym[$exKey] ?? $label);
                    ?>
                        <div class="tc-statbox">
                            <div class="tc-statbox-top">
                                <div class="tc-statbox-title"><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></div>
                                <div class="tc-statbox-value"><?php echo number_format($val); ?></div>
                            </div>

                            <div class="tc-statbox-desc"><?php echo htmlspecialchars($desc, ENT_QUOTES, 'UTF-8'); ?></div>

                            <div class="tc-statbox-meta">
                                <span class="tc-meta-pill"><?php echo (int)$activeEnergyCost; ?> energy per train</span>
                                <span class="tc-meta-pill" style="border-color:rgba(212,175,55,0.45); background:rgba(212,175,55,0.28); color:#D4AF37;">
                                    <?php echo htmlspecialchars($exercise, ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </div>

                            <?php if (!$canTrain): ?>
                                <div class="tc-meta-warn">Not enough energy</div>
                            <?php endif; ?>

                            <form method="POST" class="tc-train-form" onsubmit="return tcInjectTrainTimes(this);">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="action" value="train">
                                <input type="hidden" name="gym_id" value="<?php echo (int)$activeGymId; ?>">
                                <input type="hidden" name="stat_type" value="<?php echo htmlspecialchars($k, ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="train_times" value="1">
                                <button type="submit" class="btn btn-primary btn-block" <?php echo $canTrain ? '' : 'disabled'; ?>>TRAIN</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div style="margin-top:1rem; padding-top:1rem; border-top:1px solid #1F2937; color:#6B7280; font-size:0.8rem; text-align:center;">
                    Gym EXP unlocks better gyms. Keep training to open the city up.
                </div>
            </div>
        </div>

        <!-- Gyms grid -->
        <div class="page-section" style="margin-top: 1.25rem;">
            <div class="section-header">
                <h2 class="section-title">Gyms</h2>
                <p class="section-description">Unlocked by Gym EXP. Some may also require cash/bank.</p>
            </div>

            <div class="tc-gym-grid">
                <?php foreach ($gyms as $gym):
                    $gymId = (int)($gym['id'] ?? 0);
                    $isUnlocked = tcGymUnlocked($gym, $unlockedGymIds, $userGymExp) || ((int)($gym['tier'] ?? 1) === 1);
                    $isActive = ($gymId === $activeGymId);

                    $reqExp = (int)($gym['gym_exp_required'] ?? 0);
                    $energyCost = (int)($gym['energy_cost_per_train'] ?? 0);
                    $baseGain = (int)($gym['base_stat_gain'] ?? 0);

                    $needsExp = ($reqExp > $userGymExp);
                    $expLeft = max(0, $reqExp - $userGymExp);

                    $ucash = (float)($gym['unlock_cost_cash'] ?? 0);
                    $ubank = (float)($gym['unlock_cost_bank'] ?? 0);
                ?>
                    <div class="tc-gym-tile <?php echo $isUnlocked ? 'is-unlocked' : 'is-locked'; ?> <?php echo $isActive ? 'is-active' : ''; ?>">
                        <div class="tc-gym-icon">
                            <span class="tc-gym-icon-mark"><?php echo $isUnlocked ? '◆' : '🔒'; ?></span>
                        </div>

                        <div class="tc-gym-name"><?php echo htmlspecialchars((string)$gym['name'], ENT_QUOTES, 'UTF-8'); ?></div>

                        <div class="tc-gym-mini">
                            <span class="tc-mini"><?php echo (int)$energyCost; ?>E</span>
                            <span class="tc-mini">+<?php echo (int)$baseGain; ?></span>
                            <span class="tc-mini">EXP <?php echo (int)$reqExp; ?></span>
                        </div>

                        <?php if ($isUnlocked): ?>
                            <a class="tc-gym-select" href="/modules/gym/index.php?gym_id=<?php echo (int)$gymId; ?>">Select</a>
                        <?php else: ?>
                            <div class="tc-lockbox">
                                <div class="tc-locktitle">Locked</div>
                                <div class="tc-lockreq">
                                    <div>Gym EXP required: <span style="color:#D4AF37; font-weight:900;"><?php echo number_format($reqExp); ?></span></div>
                                    <div>Remaining: <span style="color:#F9FAFB; font-weight:900;"><?php echo number_format($expLeft); ?></span></div>
                                    <?php if ($ucash > 0): ?><div>Cash: <?php echo formatCash((float)$ucash); ?></div><?php endif; ?>
                                    <?php if ($ubank > 0): ?><div>Bank: <?php echo formatCash((float)$ubank); ?></div><?php endif; ?>
                                </div>
                                <?php if (!$needsExp): ?>
                                    <form method="POST" style="margin-top:0.5rem;">
                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="action" value="unlock">
                                        <input type="hidden" name="gym_id" value="<?php echo (int)$gymId; ?>">
                                        <button type="submit" class="btn btn-warning btn-block btn-sm">Unlock</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recent Training -->
        <?php if (!empty($recentTraining)): ?>
            <div class="page-section" style="margin-top: 1.5rem;">
                <div class="section-header"><h2 class="section-title">Recent Training</h2></div>
                <div class="card">
                    <div class="card-body" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Gym</th>
                                        <th>Stat</th>
                                        <th>Gain</th>
                                        <th>Energy</th>
                                        <th>XP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentTraining as $log): ?>
                                        <tr>
                                            <td style="font-size:0.8125rem; color:#9CA3AF;"><?php echo date('M j, g:i A', strtotime((string)$log['created_at'])); ?></td>
                                            <td style="color:#F9FAFB; font-weight:600;"><?php echo htmlspecialchars((string)$log['gym_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><span class="badge badge-secondary"><?php echo htmlspecialchars(ucfirst((string)$log['stat_trained']), ENT_QUOTES, 'UTF-8'); ?></span></td>
                                            <td style="color:#10B981; font-weight:800;">+<?php echo (int)$log['stat_gain']; ?></td>
                                            <td style="color:#3B82F6; font-weight:800;">-<?php echo (int)$log['energy_spent']; ?></td>
                                            <td style="color:#D4AF37; font-weight:900;">+<?php echo (int)$log['xp_gained']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<style>
.tc-train-grid{ display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:0.9rem; }
.tc-statbox{
    border:1px solid rgba(55,65,81,0.9);
    background:rgba(0,0,0,0.55);
    border-radius:14px;
    padding:0.9rem;
    box-shadow:0 10px 22px rgba(0,0,0,0.45);
}
.tc-statbox-top{ display:flex; justify-content:space-between; align-items:baseline; gap:0.75rem; margin-bottom:0.35rem; }
.tc-statbox-title{ font-weight:900; color:#F9FAFB; letter-spacing:0.02em; }
.tc-statbox-value{ font-weight:1000; color:#D4AF37; }
.tc-statbox-desc{ color:#9CA3AF; font-size:0.82rem; margin-bottom:0.75rem; min-height:2.2em; }
.tc-statbox-meta{ display:flex; align-items:center; gap:0.5rem; flex-wrap:wrap; margin-bottom:0.65rem; }
.tc-meta-pill{
    display:inline-flex; align-items:center;
    padding:0.3rem 0.55rem;
    border-radius:999px;
    border:1px solid rgba(59,130,246,0.45);
    background:rgba(59,130,246,0.28);
    color:#9CA3AF;
    font-size:0.75rem;
    white-space:nowrap;
}
.tc-meta-warn{ color:#EF4444; font-size:0.75rem; font-weight:900; margin-bottom:0.5rem; }
.tc-train-form{ margin:0; }
.tc-select{
    background:rgba(0,0,0,0.7);
    border:1px solid #374151;
    color:#F9FAFB;
    border-radius:10px;
    padding:0.35rem 0.5rem;
    font-weight:800;
    min-width:90px;
}

.tc-focus-grid{ display:grid; gap:0.35rem; }
.tc-focus-row{
    display:grid;
    grid-template-columns: 90px 1fr 140px;
    gap:0.5rem;
    align-items:center;
}
.tc-focus-label{ color:#9CA3AF; font-size:0.78rem; font-weight:900; }
.tc-focus-bar{
    height:10px;
    border-radius:999px;
    background:rgba(255,255,255,0.27);
    border:1px solid rgba(55,65,81,0.9);
    overflow:hidden;
}
.tc-focus-fill{
    height:100%;
    background:rgba(212,175,55,0.85);
    border-right:1px solid rgba(212,175,55,0.65);
}
.tc-focus-ex{
    color:#6B7280;
    font-size:0.78rem;
    text-align:right;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.tc-gym-grid{ display:grid; grid-template-columns:repeat(6, minmax(0, 1fr)); gap:0.9rem; }
.tc-gym-tile{
    border:1px solid rgba(55,65,81,0.9);
    background:rgba(0,0,0,0.5);
    border-radius:14px;
    padding:0.85rem;
    position:relative;
    overflow:hidden;
    min-height:170px;
}
.tc-gym-tile.is-active{
    border-color:rgba(212,175,55,0.8);
    box-shadow:0 0 0 2px rgba(212,175,55,0.35) inset, 0 14px 28px rgba(0,0,0,0.48);
}
.tc-gym-tile.is-locked{ opacity:0.9; }
.tc-gym-icon{
    width:44px; height:44px;
    border-radius:12px;
    display:flex; align-items:center; justify-content:center;
    border:1px solid rgba(212,175,55,0.45);
    background:rgba(212,175,55,0.28);
    margin-bottom:0.6rem;
}
.tc-gym-icon-mark{ font-size:1.1rem; }
.tc-gym-name{ font-weight:900; color:#F9FAFB; margin-bottom:0.4rem; font-size:0.95rem; line-height:1.2; }
.tc-gym-mini{ display:flex; gap:0.4rem; flex-wrap:wrap; margin-bottom:0.6rem; }
.tc-mini{
    font-size:0.72rem;
    color:#9CA3AF;
    border:1px solid rgba(55,65,81,0.9);
    background:rgba(0,0,0,0.45);
    padding:0.2rem 0.45rem;
    border-radius:999px;
    font-weight:800;
}
.tc-gym-select{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:100%;
    padding:0.45rem 0.6rem;
    border-radius:12px;
    border:1px solid rgba(212,175,55,0.55);
    background:rgba(212,175,55,0.28);
    color:#D4AF37;
    font-weight:900;
    text-decoration:none;
}
.tc-gym-select:hover{ background:rgba(212,175,55,0.32); }
.tc-lockbox{ margin-top:0.5rem; border-top:1px solid rgba(55,65,81,0.9); padding-top:0.6rem; }
.tc-locktitle{ color:#EF4444; font-weight:1000; font-size:0.78rem; letter-spacing:0.08em; text-transform:uppercase; margin-bottom:0.25rem; }
.tc-lockreq{ color:#9CA3AF; font-size:0.78rem; line-height:1.35; }

.table { width: 100%; border-collapse: collapse; }
.table thead { background: rgba(31, 41, 55, 0.7); }
.table th{
    padding: 0.75rem 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 900;
    color: #9CA3AF;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #374151;
}
.table td{ padding: 0.875rem 1rem; border-bottom: 1px solid #1F2937; font-size: 0.875rem; }
.table tbody tr:hover{ background: rgba(31, 41, 55, 0.5); }
.table tbody tr:last-child td{ border-bottom: none; }

.badge{
    display: inline-block;
    padding: 0.25rem 0.625rem;
    font-size: 0.75rem;
    font-weight: 900;
    line-height: 1;
    border-radius: 0.375rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}
.badge-secondary{
    background: rgba(107, 114, 128, 0.4);
    color: #9CA3AF;
    border: 1px solid rgba(107, 114, 128, 0.5);
}

@media (max-width: 1100px){
    .tc-train-grid{ grid-template-columns:repeat(2, minmax(0, 1fr)); }
    .tc-gym-grid{ grid-template-columns:repeat(4, minmax(0, 1fr)); }
    .tc-focus-row{ grid-template-columns: 90px 1fr 120px; }
}
@media (max-width: 768px){
    .tc-train-grid{ grid-template-columns:1fr; }
    .tc-gym-grid{ grid-template-columns:repeat(2, minmax(0, 1fr)); }
    .table-responsive{ overflow-x:auto; }
    .table{ min-width: 620px; }
    .tc-focus-row{ grid-template-columns: 84px 1fr 110px; }
}
</style>

<script>
function tcInjectTrainTimes(form){
    const sel = document.getElementById('tcTrainTimesSelect');
    if (!sel) return true;
    const v = parseInt(sel.value || '1', 10);
    const hidden = form.querySelector('input[name="train_times"]');
    if (hidden) hidden.value = String(isNaN(v) ? 1 : v);
    return true;
}
</script>

</body>
</html>






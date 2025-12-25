<?php
/**
 * ===============================================================
 * TRENCH CITY - GYM TRAINING SYSTEM
 * ===============================================================
 * MAIN GYM PAGE (gym_shell.php)
 *
 * Tables used (must exist):
 * - gyms (id, name, tier, gym_exp_required, energy_cost_per_train, base_stat_gain,
 *         strength_mult, speed_mult, defense_mult, dexterity_mult,
 *         ex_strength, ex_speed, ex_defense, ex_dexterity,
 *         unlock_cost_cash, unlock_cost_bank, gym_class)
 * - gym_unlocks (user_id, gym_id, unlocked_at)
 * - training_logs
 * - player_stats
 * - player_bars
 * - users
 */

declare(strict_types=1);

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

/**
 * Baseline audit notes:
 * - Training was handled directly in this file with multi-train and gym EXP output.
 * - Gym list was a grid/strip layout, not a two-column list + training panel.
 * - Training logs were queried for UI use (now hidden per spec).
 */

function tcGymStatMult(array $gym, string $statType): float {
    $k = $statType . '_mult';
    $v = isset($gym[$k]) ? (float)$gym[$k] : 1.0;
    return ($v > 0) ? $v : 1.0;
}

function tcGymDots(array $gym, string $statType): float {
    $k = $statType . '_mult';
    $v = isset($gym[$k]) ? (float)$gym[$k] : 0.0;
    return max(0.0, $v);
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

function tcFormatStatValue(float $v): string {
    $rounded = round($v, 2);
    if (abs($rounded - round($rounded)) < 0.005) {
        return number_format((int)round($rounded));
    }
    return number_format($rounded, 2);
}

function tcIsUserJailed(?array $user): bool {
    if (!$user || empty($user['jail_until'])) {
        return false;
    }
    return strtotime((string)$user['jail_until']) > time();
}

function tcFindCrimsGymId(array $gyms): ?int {
    foreach ($gyms as $gym) {
        $name = strtolower((string)($gym['name'] ?? ''));
        $gymClass = strtolower((string)($gym['gym_class'] ?? ''));
        if ($gymClass === 'crims' || str_contains($name, 'crim')) {
            return (int)($gym['id'] ?? 0) ?: null;
        }
    }
    return null;
}

function tcFindGeorgesGymId(array $gyms): ?int {
    foreach ($gyms as $gym) {
        $name = strtolower((string)($gym['name'] ?? ''));
        if (str_contains($name, 'george')) {
            return (int)($gym['id'] ?? 0) ?: null;
        }
    }
    return null;
}

function resolveTrainingModifiers(int $userId, string $statKey): array {
    return [
        'goal_oriented' => false,
        'faction_steadfast_pct' => 0.0,
        'education_gym_pct' => 0.0,
        'company_gym_pct' => 0.0,
        'book_gym_pct' => 0.0,
        'property_gym_perk_pct' => 0.0,
    ];
}

function calcHappyLoss(int $energyPerTrain, array $modifiers): int {
    // Exact rule: 5 Happy per 10 Energy (floor)
    // Examples: 5e -> 2, 10e -> 5, 25e -> 12
    $loss = (int)floor($energyPerTrain / 2);

    if (!empty($modifiers['goal_oriented'])) {
        $loss = (int)floor($loss * 0.5);
    }

    return max(0, $loss);
}

function calcGymGain(float $currentStat, int $happy, float $baseGainPerEnergy, float $gymStatMult, int $energyPerTrain, array $modifiers): float {
    // Torn-like behavior: smaller gains, Happy matters, diminishing returns as stats rise.
    // Exact Torn server numbers are not public; this is a calibrated approximation.
    $happyMult = 1 + log10(($happy / 1000) + 1);
    $statSizeMult = 1 / (1 + pow($currentStat / 60000, 0.75));

    $m = 1.0;
    $m *= 1.0 + (float)($modifiers['faction_steadfast_pct'] ?? 0.0);
    $m *= 1.0 + (float)($modifiers['education_gym_pct'] ?? 0.0);
    $m *= 1.0 + (float)($modifiers['company_gym_pct'] ?? 0.0);
    $m *= 1.0 + (float)($modifiers['book_gym_pct'] ?? 0.0);
    $m *= 1.0 + (float)($modifiers['property_gym_perk_pct'] ?? 0.0);

    // Global scale to stop early gyms giving chunky integer jumps.
    $GLOBAL_SCALE = 0.12;

    $gain = $energyPerTrain * $baseGainPerEnergy * $gymStatMult * $happyMult * $statSizeMult * $m * $GLOBAL_SCALE;
    return max(0.0, $gain);
}

/**
 * Torn-like: gym exp progression should track energy spent training (1:1).
 */
function calcGymExpGain(int $energyPerTrain): int {
    return max(0, $energyPerTrain);
}

function tcMeetsSpecialistRequirements(array $stats, array $gym): bool {
    $name = strtolower((string)($gym['name'] ?? ''));
    $strength = (float)($stats['strength'] ?? 0);
    $defense = (float)($stats['defense'] ?? 0);
    $speed = (float)($stats['speed'] ?? 0);
    $dexterity = (float)($stats['dexterity'] ?? 0);
    $all = [
        'strength' => $strength,
        'defense' => $defense,
        'speed' => $speed,
        'dexterity' => $dexterity,
    ];
    arsort($all);
    $top = array_key_first($all);
    $second = array_slice($all, 1, 1, true);
    $secondVal = $second ? (float)array_values($second)[0] : 0.0;

    $needsTop = [
        'gym 3000' => 'strength',
        'mr. isoyamas' => 'defense',
        'total rebound' => 'speed',
        'elites' => 'dexterity',
    ];
    foreach ($needsTop as $needle => $statKey) {
        if (str_contains($name, $needle)) {
            return $statKey === $top && ($secondVal <= 0 || $all[$statKey] >= ($secondVal * 1.25));
        }
    }

    if (str_contains($name, 'balboa') || str_contains($name, 'frontline')) {
        $strDef = $strength + $defense;
        $spdDex = $speed + $dexterity;
        if ($strDef <= 0 || $spdDex <= 0) {
            return false;
        }
        return $strDef >= ($spdDex * 1.25) || $spdDex >= ($strDef * 1.25);
    }

    return true;
}

function canAccessGym(int $userId, array $gym, array $context, array $unlockedGymIds, bool $starterAllowed): array {
    if (!empty($context['is_jailed']) && empty($context['is_crims_gym'])) {
        return [false, 'In jail: only Crims gym is available.'];
    }
    if (!empty($context['is_jailed']) && !empty($context['is_crims_gym'])) {
        return [true, null];
    }

    $gymId = (int)($gym['id'] ?? 0);
    if (!in_array($gymId, $unlockedGymIds, true) && !$starterAllowed) {
        return [false, 'No membership.'];
    }

    if (!empty($context['is_specialist']) && !tcMeetsSpecialistRequirements($context['stats'], $gym)) {
        return [false, 'Specialist requirements not met.'];
    }

    return [true, null];
}

$flash = $_SESSION['gym_flash'] ?? null;
unset($_SESSION['gym_flash']);

// Training handler (multi-train supported)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'train') {
    $csrf = $_POST['csrf_token'] ?? '';
    $nonce = $_POST['train_nonce'] ?? '';
    $sessionNonce = $_SESSION['gym_train_nonce'] ?? '';

    if (!csrf_check($csrf) || $nonce === '' || $sessionNonce === '' || !hash_equals($sessionNonce, $nonce)) {
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
        header('Location: /gym.php');
        exit;
    }

    unset($_SESSION['gym_train_nonce']);

    $gymId = (int)($_POST['gym_id'] ?? 0);
    $statKey = (string)($_POST['stat_key'] ?? '');
    $trainTimes = (int)($_POST['trains_count'] ?? 1);
    $allowedStats = ['strength', 'defense', 'speed', 'dexterity'];

    if ($trainTimes < 1) $trainTimes = 1;
    if ($trainTimes > 50) $trainTimes = 50;

    if ($gymId <= 0 || !in_array($statKey, $allowedStats, true)) {
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
        header('Location: /gym.php');
        exit;
    }

    $starterRow = $db->fetchOne("SELECT id FROM gyms ORDER BY tier ASC, id ASC LIMIT 1");
    $starterGymId = (int)($starterRow['id'] ?? 0);

    $isJailed = tcIsUserJailed($user);
    $isCrimsGym = false;

    if ($isJailed) {
        $crimsGym = $db->fetchOne(
            "SELECT * FROM gyms WHERE LOWER(COALESCE(gym_class,'')) = 'crims' OR LOWER(name) LIKE '%crim%' LIMIT 1"
        );
        if ($crimsGym) {
            $gym = $crimsGym;
            $gymId = (int)$gym['id'];
            $isCrimsGym = true;
        } else {
            $gym = $db->fetchOne("SELECT * FROM gyms WHERE id = :id LIMIT 1", ['id' => $gymId]);
        }
    } else {
        $gym = $db->fetchOne("SELECT * FROM gyms WHERE id = :id LIMIT 1", ['id' => $gymId]);
    }

    if (!$gym) {
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
        header('Location: /gym.php');
        exit;
    }

    $gymDots = tcGymDots($gym, $statKey);
    if ($gymDots <= 0) {
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'This gym cannot train that stat.'];
        header('Location: /gym.php?gym_id=' . $gymId);
        exit;
    }

    if ($isJailed && $statKey === 'dexterity') {
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'You cannot train Dexterity in jail.'];
        header('Location: /gym.php?gym_id=' . $gymId);
        exit;
    }

    $energyCostPerTrain = (int)($gym['energy_cost_per_train'] ?? 0);
    if ($energyCostPerTrain <= 0) {
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
        header('Location: /gym.php?gym_id=' . $gymId);
        exit;
    }

    $unlocked = $db->fetchOne(
        "SELECT gym_id FROM gym_unlocks WHERE user_id = :uid AND gym_id = :gid LIMIT 1",
        ['uid' => $userId, 'gid' => $gymId]
    );
    $starterAllowed = ($gymId === $starterGymId && (int)($gym['membership_cost_cash'] ?? 0) === 0 && (int)($gym['gym_exp_required'] ?? 0) === 0);

    $gymClass = strtolower((string)($gym['gym_class'] ?? ''));
    $gymNameLower = strtolower((string)($gym['name'] ?? ''));
    $isSpecialist = ($gymClass !== '' && str_contains($gymClass, 'special'))
        || str_contains($gymNameLower, 'gym 3000')
        || str_contains($gymNameLower, 'isoyama')
        || str_contains($gymNameLower, 'total rebound')
        || str_contains($gymNameLower, 'elites')
        || str_contains($gymNameLower, 'balboa')
        || str_contains($gymNameLower, 'frontline');

    $context = [
        'is_jailed' => $isJailed,
        'is_crims_gym' => $isCrimsGym,
        'is_specialist' => $isSpecialist,
        'stats' => $stats,
    ];

    [$allowed, $denyReason] = canAccessGym($userId, $gym, $context, $unlocked ? [$gymId] : [], $starterAllowed);
    if (!$allowed) {
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => $denyReason ?: 'Invalid training request.'];
        header('Location: /gym.php?gym_id=' . $gymId);
        exit;
    }

    $energyCost = $energyCostPerTrain * $trainTimes;
    $xpGain = $energyCost * 2;

    $statLabel = tcStatLabel($statKey);

    $formatStatGain = function (float $value): string {
        $rounded = round($value, 2);
        if (abs($rounded - round($rounded)) < 0.005) {
            return (string)(int)round($rounded);
        }
        return number_format($rounded, 2);
    };

    try {
        $db->beginTransaction();

        $bars = $db->fetchOne(
            "SELECT * FROM player_bars WHERE user_id = :id LIMIT 1 FOR UPDATE",
            ['id' => $userId]
        );
        $stats = $db->fetchOne(
            "SELECT * FROM player_stats WHERE user_id = :id LIMIT 1 FOR UPDATE",
            ['id' => $userId]
        );
        $userRow = $db->fetchOne(
            "SELECT id, xp, level FROM users WHERE id = :id LIMIT 1 FOR UPDATE",
            ['id' => $userId]
        );
        $ugp = $db->fetchOne(
            "SELECT user_id, gym_exp FROM user_gym_progress WHERE user_id = :id LIMIT 1 FOR UPDATE",
            ['id' => $userId]
        );
        if (!$ugp) {
            $db->execute(
                "INSERT INTO user_gym_progress (user_id, gym_exp, updated_at) VALUES (:uid, 0, NOW())",
                ['uid' => $userId]
            );
            $ugp = ['user_id' => $userId, 'gym_exp' => 0];
        }

        if (!$bars || !$stats || !$userRow) {
            throw new RuntimeException('Missing player data.');
        }

        if (isset($bars['life_current']) && (int)$bars['life_current'] <= 0) {
            $db->rollBack();
            $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
            header('Location: /gym.php?gym_id=' . $gymId);
            exit;
        }

        $energyCurrent = (int)($bars['energy_current'] ?? 0);
        if ($energyCurrent < $energyCost) {
            $db->rollBack();
            $_SESSION['gym_flash'] = [
                'type' => 'error',
                'message' => "Not enough Energy to train. Need {$energyCost}, you have {$energyCurrent}."
            ];
            header('Location: /gym.php?gym_id=' . $gymId);
            exit;
        }

        $happyCurrent = (int)($bars['happy_current'] ?? 0);
        $currentStat = (float)($stats[$statKey] ?? 0);

        $modifiers = resolveTrainingModifiers($userId, $statKey);

        $totalStatGain = 0.0;
        $totalHappyLoss = 0;
        $totalEnergySpent = 0;
        $totalGymExpGain = 0;

        $georgesGym = $db->fetchOne("SELECT id FROM gyms WHERE LOWER(name) LIKE '%george%' LIMIT 1");
        $georgesGymId = (int)($georgesGym['id'] ?? 0);
        $hasUnlockedGeorges = false;
        if ($georgesGymId > 0) {
            $georgesUnlocked = $db->fetchOne(
                "SELECT gym_id FROM gym_unlocks WHERE user_id = :uid AND gym_id = :gid LIMIT 1",
                ['uid' => $userId, 'gid' => $georgesGymId]
            );
            $hasUnlockedGeorges = (bool)$georgesUnlocked;
        }

        $runningHappy = $happyCurrent;
        $runningStat = $currentStat;
        $runningEnergy = $energyCurrent;

        for ($i = 0; $i < $trainTimes; $i++) {
            if ($runningEnergy < $energyCostPerTrain) {
                break;
            }

            // Torn-like ordering: gain uses CURRENT happy, then happy is reduced after.
            $baseGainPerEnergy = (float)($gym['base_stat_gain'] ?? 0.9);
            $statGain = calcGymGain($runningStat, $runningHappy, $baseGainPerEnergy, $gymDots, $energyCostPerTrain, $modifiers);
            $runningStat += $statGain;
            $totalStatGain += $statGain;

            $runningEnergy -= $energyCostPerTrain;
            $totalEnergySpent += $energyCostPerTrain;

            $happyLoss = calcHappyLoss($energyCostPerTrain, $modifiers);
            $runningHappy = max(0, $runningHappy - $happyLoss);
            $totalHappyLoss += $happyLoss;

            if (!$hasUnlockedGeorges) {
                $totalGymExpGain += calcGymExpGain($energyCostPerTrain);
            }
        }

        // Torn-like: do NOT force minimum gain; allow 0 at low happy / high stat / bad gym.
        $statGainFloat = round((float)$totalStatGain, 6);
        // Torn-like: allow fractional gains (no forced minimum 1).
        $newStatValue = (float)$currentStat + (float)$statGainFloat;
        $energyAfter = $runningEnergy;
        $happyAfter = $runningHappy;
$db->execute(
            "UPDATE player_stats SET {$statKey} = :new_value WHERE user_id = :user_id",
            ['new_value' => $newStatValue, 'user_id' => $userId]
        );

        updateUserBars($userId, [
            'energy_current' => $energyAfter,
            'happy_current' => $happyAfter,
        ]);

        $newXp = (int)$userRow['xp'] + $xpGain;
        $newLevel = calculateLevel($newXp);
        $db->execute(
            "UPDATE users SET xp = :xp, level = :level WHERE id = :id",
            ['xp' => $newXp, 'level' => $newLevel, 'id' => $userId]
        );

        if (!$hasUnlockedGeorges && $totalGymExpGain > 0) {
            $db->execute(
                "UPDATE user_gym_progress SET gym_exp = gym_exp + :add, updated_at = NOW() WHERE user_id = :uid",
                ['add' => $totalGymExpGain, 'uid' => $userId]
            );
        }

        $db->execute(
            "INSERT INTO training_logs (user_id, gym_id, stat_trained, energy_spent, stat_gain, xp_gained, created_at)
             VALUES (:user_id, :gym_id, :stat_trained, :energy_spent, :stat_gain, :xp_gained, NOW())",
            [
                'user_id' => $userId,
                'gym_id' => $gymId,
                'stat_trained' => $statKey,
                'energy_spent' => $totalEnergySpent,
                'stat_gain' => $statGainFloat,
                'xp_gained' => $xpGain,
            ]
        );

        $db->commit();

        logPlayerAction($userId, 'gym_train', [
            'gym_id' => $gymId,
            'stat' => $statKey,
            'gain' => $statGainFloat,
            'energy' => $totalEnergySpent,
            'happy_loss' => $totalHappyLoss,
            'xp' => $xpGain,
        ]);

        $gainDisplay = $formatStatGain((float)$statGainFloat);

        $_SESSION['gym_flash'] = [
            'type' => 'success',
            'banner' => "Training complete! +{$gainDisplay} {$statLabel} | +{$xpGain} XP",
            'line' => "+{$gainDisplay} {$statLabel} - {$totalEnergySpent} Energy - {$totalHappyLoss} Happy",
            'gym_name' => (string)($gym['name'] ?? 'Gym'),
        ];
    } catch (Throwable $e) {
        if ($db && $db->inTransaction()) {
            $db->rollBack();
        }
        tc_log("[GYM] Training error for user {$userId}: {$e->getMessage()}", 'error');
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
    }

    header('Location: /gym.php?gym_id=' . $gymId);
    exit;
}

// Unlock handler (membership purchase)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'unlock') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
        header('Location: /gym.php');
        exit;
    }

    $gymId = (int)($_POST['gym_id'] ?? 0);
    $gym = $db->fetchOne("SELECT * FROM gyms WHERE id = :id LIMIT 1", ['id' => $gymId]);
    if (!$gym) {
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
        header('Location: /gym.php');
        exit;
    }

    $alreadyUnlocked = $db->fetchOne(
        "SELECT gym_id FROM gym_unlocks WHERE user_id = :uid AND gym_id = :gid LIMIT 1",
        ['uid' => $userId, 'gid' => $gymId]
    );

    if ($alreadyUnlocked) {
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
        header('Location: /gym.php');
        exit;
    }

    $ugp = $db->fetchOne(
        "SELECT user_id, gym_exp FROM user_gym_progress WHERE user_id = :uid LIMIT 1",
        ['uid' => $userId]
    );
    if (!$ugp) {
        $db->execute(
            "INSERT INTO user_gym_progress (user_id, gym_exp, updated_at) VALUES (:uid, 0, NOW())",
            ['uid' => $userId]
        );
        $ugp = ['user_id' => $userId, 'gym_exp' => 0];
    }

    $requiredGymExp = (int)($gym['gym_exp_required'] ?? 0);
    $userGymExp = (int)($ugp['gym_exp'] ?? 0);
    if ($userGymExp < $requiredGymExp) {
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
        header('Location: /gym.php');
        exit;
    }

    $membershipCostCash = (float)($gym['membership_cost_cash'] ?? 0);
    $unlockCostCash = (float)($gym['unlock_cost_cash'] ?? 0);
    $unlockCostBank = (float)($gym['unlock_cost_bank'] ?? 0);
    $costCash = $membershipCostCash > 0 ? $membershipCostCash : $unlockCostCash;
    $costBank = $unlockCostBank;

    $userCash = (float)($user['cash'] ?? 0);
    $userBank = (float)($user['bank_balance'] ?? 0);

    if ($userCash < $costCash || $userBank < $costBank) {
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
        header('Location: /gym.php');
        exit;
    }

    try {
        $db->beginTransaction();

        $db->execute(
            "UPDATE users SET cash = :cash, bank_balance = :bank WHERE id = :user_id",
            [
                'cash' => $userCash - $costCash,
                'bank' => $userBank - $costBank,
                'user_id' => $userId
            ]
        );

        $db->execute(
            "INSERT INTO gym_unlocks (user_id, gym_id, unlocked_at) VALUES (:user_id, :gym_id, NOW())",
            ['user_id' => $userId, 'gym_id' => $gymId]
        );

        $db->commit();

        $_SESSION['active_gym_id'] = $gymId;
        $_SESSION['gym_flash'] = ['type' => 'notice', 'message' => 'Membership purchased.'];
    } catch (Exception $e) {
        $db->rollBack();
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
    }

    header('Location: /gym.php?gym_id=' . $gymId);
    exit;
}

$trainNonce = bin2hex(random_bytes(16));
$_SESSION['gym_train_nonce'] = $trainNonce;

$ugp = $db->fetchOne("SELECT user_id, gym_exp FROM user_gym_progress WHERE user_id = :uid LIMIT 1", ['uid' => $userId]);
if (!$ugp) {
    $db->execute("INSERT INTO user_gym_progress (user_id, gym_exp, updated_at) VALUES (:uid, 0, NOW())", ['uid' => $userId]);
    $ugp = ['user_id' => $userId, 'gym_exp' => 0];
}
$userGymExp = (int)($ugp['gym_exp'] ?? 0);

$gyms = $db->fetchAll("SELECT * FROM gyms ORDER BY gym_exp_required ASC, tier ASC, id ASC");

$starterGymId = 0;
if (!empty($gyms)) {
    $starterGymId = (int)($gyms[0]['id'] ?? 0);
}

$unlockedGymIds = [];
$unlockedRows = $db->fetchAll(
    "SELECT gym_id FROM gym_unlocks WHERE user_id = :user_id",
    ['user_id' => $userId]
);
foreach ($unlockedRows as $row) {
    $unlockedGymIds[] = (int)$row['gym_id'];
}

$isJailed = tcIsUserJailed($user);
$crimsGymId = tcFindCrimsGymId($gyms);

$requestedGymId = isset($_GET['gym_id']) ? (int)$_GET['gym_id'] : 0;
if ($requestedGymId > 0) {
    $reqGym = null;
    foreach ($gyms as $g) {
        if ((int)$g['id'] === $requestedGymId) {
            $reqGym = $g;
            break;
        }
    }
    $reqStarterAllowed = $reqGym && (int)($reqGym['membership_cost_cash'] ?? 0) === 0 && (int)($reqGym['gym_exp_required'] ?? 0) === 0;
    if (in_array($requestedGymId, $unlockedGymIds, true) || $reqStarterAllowed) {
        $_SESSION['active_gym_id'] = $requestedGymId;
    }
}

if ($isJailed && $crimsGymId) {
    $_SESSION['active_gym_id'] = $crimsGymId;
}

$activeGymId = (int)($_SESSION['active_gym_id'] ?? 0);
$activeGym = null;

if ($activeGymId > 0) {
    foreach ($gyms as $g) {
        if ((int)$g['id'] === $activeGymId) {
            $activeGym = $g;
            break;
        }
    }
}

if (!$activeGym) {
    $bestGym = null;
    foreach ($gyms as $g) {
        $gid = (int)$g['id'];
        $starterAllowed = (int)($g['membership_cost_cash'] ?? 0) === 0 && (int)($g['gym_exp_required'] ?? 0) === 0;
        if (!in_array($gid, $unlockedGymIds, true) && !$starterAllowed) {
            continue;
        }
        if ($bestGym === null || (int)$g['tier'] > (int)$bestGym['tier']) {
            $bestGym = $g;
        }
    }
    if ($bestGym) {
        $activeGym = $bestGym;
        $_SESSION['active_gym_id'] = (int)$bestGym['id'];
    } elseif (!empty($gyms)) {
        $activeGym = $gyms[0];
    }
}

$activeGymId = (int)($activeGym['id'] ?? 0);
$activeGymName = (string)($activeGym['name'] ?? 'Gym');
$activeEnergyCost = (int)($activeGym['energy_cost_per_train'] ?? 0);
$energyCur = (int)($bars['energy_current'] ?? 0);
$happyCur = (int)($bars['happy_current'] ?? 0);

$totalStats = (int)($stats['strength'] ?? 0) + (int)($stats['speed'] ?? 0) + (int)($stats['defense'] ?? 0) + (int)($stats['dexterity'] ?? 0);

$tc_page_title = 'Gym - Trench City';

include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
                <div></div>
            </div>
        </div>

        <?php if (!empty($flash['type']) && $flash['type'] === 'success'): ?>
            <div class="tc-card tc-result">
                <div class="tc-result-left">
                    <div class="tc-result-h">TRAINING RESULTS</div>
                    <div class="tc-result-gym"><?php echo htmlspecialchars((string)$flash['gym_name'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="tc-result-line"><?php echo htmlspecialchars((string)$flash['line'], ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <section class="tc-widget tc-widget-hero tc-train-panel" data-widget-id="gym-selected">
            <div class="tc-widget-header">
                <div>
                    <div class="tc-train-kicker">Selected Gym</div>
                    <div class="tc-train-title"><?php echo htmlspecialchars($activeGymName, ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
                <div class="tc-widget-actions">
                    <span class="tc-widget-meta">Energy per train: <?php echo (int)$activeEnergyCost; ?> • Total Stats: <?php echo number_format($totalStats); ?></span>
                    <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                </div>
            </div>
            <div class="tc-widget-body">
<?php if (!empty($flash['type']) && $flash['type'] === 'error'): ?>
                <div class="alert alert-danger" style="margin-bottom: 1rem;">
                    <div class="alert-content">
                        <div class="alert-message"><?php echo htmlspecialchars((string)$flash['message'], ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                </div>
            <?php elseif (!empty($flash['type']) && $flash['type'] === 'notice'): ?>
                <div class="alert alert-success" style="margin-bottom: 1rem;">
                    <div class="alert-content">
                        <div class="alert-message"><?php echo htmlspecialchars((string)$flash['message'], ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="tc-hero-cards">
                <?php
                    $statTiles = ['strength', 'defense', 'speed', 'dexterity'];
                    foreach ($statTiles as $key):
                        $label = tcStatLabel($key);
                        $desc = tcStatDesc($key);
                        $val = (float)($stats[$key] ?? 0);
                        $gymDots = tcGymDots($activeGym ?? [], $key);
                        $isUnlocked = in_array($activeGymId, $unlockedGymIds, true) || ((int)($activeGym['membership_cost_cash'] ?? 0) === 0 && (int)($activeGym['gym_exp_required'] ?? 0) === 0);
                        $isCrimsActive = $isJailed && $crimsGymId && $activeGymId === $crimsGymId;
                        $isUnlocked = $isUnlocked || $isCrimsActive;
                        $isDexJailBlocked = $isJailed && $key === 'dexterity';
                        $canTrain = ($isUnlocked && $activeEnergyCost > 0 && $gymDots > 0 && !$isDexJailBlocked);
                ?>
                    <section class="tc-widget tc-widget-hero tc-hero-card" data-widget-id="gym-<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="tc-widget-header">
                            <h3 class="tc-widget-title"><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></h3>
                            <div class="tc-widget-actions">
                                <span class="tc-hero-value"><?php echo tcFormatStatValue($val); ?></span>
                                <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                            </div>
                        </div>
                        <div class="tc-widget-body">
                            <div class="tc-hero-desc"><?php echo htmlspecialchars($desc, ENT_QUOTES, 'UTF-8'); ?></div>
                            <div class="tc-hero-energy"><?php echo (int)$activeEnergyCost; ?> energy per train</div>
                            <div class="tc-hero-controls">
                                <form method="POST" action="/gym.php" class="tc-hero-form">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="train_nonce" value="<?php echo htmlspecialchars($trainNonce, ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="action" value="train">
                                    <input type="hidden" name="gym_id" value="<?php echo (int)$activeGymId; ?>">
                                    <input type="hidden" name="stat_key" value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>">
                                    <select name="trains_count" class="tc-hero-qty" aria-label="Trains">
                                        <?php foreach ([1, 5, 10, 25, 50] as $count): ?>
                                            <option value="<?php echo (int)$count; ?>"><?php echo (int)$count; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="tc-hero-train" <?php echo $canTrain ? '' : 'disabled'; ?>>Train</button>
                                </form>
                            </div>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
                </div>
        </section>


        <section class="tc-widget tc-widget-hero tc-gym-features" aria-label="Gyms" data-widget-id="gym-list">
            <div class="tc-widget-header">
                <h2 class="tc-widget-title">Gyms</h2>
                <div class="tc-widget-actions">
                    <span class="tc-widget-meta">Select a gym to train</span>
                    <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                </div>
            </div>
            <div class="tc-widget-body">
                <div class="tc-gym-features-wrap">
                <div class="tc-gym-grid" id="tcGymGrid">
<?php foreach ($gyms as $gym):
    $gymId = (int)($gym['id'] ?? 0);
    $starterAllowed = (int)($gym['membership_cost_cash'] ?? 0) === 0 && (int)($gym['gym_exp_required'] ?? 0) === 0;
    $hasMembership = in_array($gymId, $unlockedGymIds, true) || $starterAllowed;
    $reqExp = (int)($gym['gym_exp_required'] ?? 0);
    $isAvailable = $userGymExp >= $reqExp;
    $isActive = ($gymId === $activeGymId);
    $tier = (int)($gym['tier'] ?? 1);
?>
    <?php if ($hasMembership): ?>
        <a class="tc-gym-tile<?php echo $isActive ? ' is-active' : ''; ?>" href="/gym.php?gym_id=<?php echo (int)$gymId; ?>">
            <span class="tc-gym-tile-icon"><?php echo $isActive ? '✓' : '•'; ?></span>
            <span class="tc-gym-tile-label"><?php echo htmlspecialchars((string)$gym['name'], ENT_QUOTES, 'UTF-8'); ?></span>
            <span class="tc-gym-tile-tier">Tier <?php echo (int)$tier; ?></span>
        </a>
    <?php else: ?>
        <?php if ($isAvailable): ?>
            <a class="tc-gym-tile is-locked is-available" href="/gym.php?gym_id=<?php echo (int)$gymId; ?>">
                <span class="tc-gym-tile-icon">🔓</span>
                <span class="tc-gym-tile-label"><?php echo htmlspecialchars((string)$gym['name'], ENT_QUOTES, 'UTF-8'); ?></span>
                <span class="tc-gym-tile-tier">Available</span>
            </a>
        <?php else: ?>
            <div class="tc-gym-tile is-locked">
                <span class="tc-gym-tile-icon">🔒</span>
                <span class="tc-gym-tile-label"><?php echo htmlspecialchars((string)$gym['name'], ENT_QUOTES, 'UTF-8'); ?></span>
                <span class="tc-gym-tile-tier">Locked</span>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>
                </div>

                <div class="tc-gym-detail" aria-live="polite">
                    <?php
                        $detailGym = $activeGym;
                        if ($requestedGymId > 0) {
                            foreach ($gyms as $g) {
                                if ((int)$g['id'] === $requestedGymId) {
                                    $detailGym = $g;
                                    break;
                                }
                            }
                        }
                        $detailGymId = (int)($detailGym['id'] ?? 0);
                        $detailStarterAllowed = (int)($detailGym['membership_cost_cash'] ?? 0) === 0 && (int)($detailGym['gym_exp_required'] ?? 0) === 0;
                        $detailUnlocked = in_array($detailGymId, $unlockedGymIds, true) || $detailStarterAllowed;
                        $detailEnergy = (int)($detailGym['energy_cost_per_train'] ?? 0);
                        $detailTier = (int)($detailGym['tier'] ?? 1);
                        $detailReqExp = (int)($detailGym['gym_exp_required'] ?? 0);
                        $detailAvailable = $userGymExp >= $detailReqExp;
                        $detailMembershipCash = (float)($detailGym['membership_cost_cash'] ?? 0);
                        $detailCashFallback = (float)($detailGym['unlock_cost_cash'] ?? 0);
                        $detailBankFallback = (float)($detailGym['unlock_cost_bank'] ?? 0);
                        $detailCash = $detailMembershipCash > 0 ? $detailMembershipCash : $detailCashFallback;
                        $detailBank = $detailBankFallback;
                        $detailNeedsMoney = ($detailCash > 0 || $detailBank > 0);
                        $detailCanUnlock = $detailAvailable && !$detailUnlocked && (!$detailNeedsMoney || (($user['cash'] ?? 0) >= $detailCash && ($user['bank_balance'] ?? 0) >= $detailBank)) && !$detailStarterAllowed;
                    ?>
                    <h3 style="margin:0 0 8px;"><?php echo htmlspecialchars((string)($detailGym['name'] ?? 'Gym'), ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p style="margin:0 0 12px; opacity:0.92;">Tier <?php echo (int)$detailTier; ?> • <?php echo (int)$detailEnergy; ?> energy per train</p>

                    <div class="tc-gym-detail-pills">
                        <span class="tc-gym-pill">Str x<?php echo number_format(tcGymStatMult($detailGym, 'strength'), 2); ?></span>
                        <span class="tc-gym-pill">Def x<?php echo number_format(tcGymStatMult($detailGym, 'defense'), 2); ?></span>
                        <span class="tc-gym-pill">Spd x<?php echo number_format(tcGymStatMult($detailGym, 'speed'), 2); ?></span>
                        <span class="tc-gym-pill">Dex x<?php echo number_format(tcGymStatMult($detailGym, 'dexterity'), 2); ?></span>
                    </div>

                    <?php if ($detailUnlocked): ?>
                        <div style="margin-top:12px;">
                            <a class="tc-gym-detail-btn" href="/gym.php?gym_id=<?php echo (int)$detailGymId; ?>">
                                <?php echo $detailGymId === $activeGymId ? 'Selected' : 'Select'; ?>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="tc-gym-detail-lock">
                            <div class="tc-gym-detail-locktitle"><?php echo $detailAvailable ? 'Available' : 'Locked'; ?></div>
                            <?php if (!$detailAvailable): ?>
                                <div class="tc-gym-detail-lockreq">Requires: more gym experience</div>
                            <?php endif; ?>
                            <?php if ($detailCash > 0): ?><div class="tc-gym-detail-lockreq">Cash: <?php echo formatCash((float)$detailCash); ?></div><?php endif; ?>
                            <?php if ($detailBank > 0): ?><div class="tc-gym-detail-lockreq">Bank: <?php echo formatCash((float)$detailBank); ?></div><?php endif; ?>
                            <?php if ($detailCanUnlock): ?>
                                <form method="POST" style="margin-top:0.6rem;">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="action" value="unlock">
                                    <input type="hidden" name="gym_id" value="<?php echo (int)$detailGymId; ?>">
                                    <button type="submit" class="tc-btn tc-btn-primary" style="width:100%;">Buy Membership</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        </section>

    </div>
</div>

<style>
.tc-train-panel .tc-widget-body{ padding:0.85rem; }
.tc-train-kicker{ font-size:0.7rem; letter-spacing:0.08em; text-transform:uppercase; color:#9CA3AF; }
.tc-train-title{ font-size:1.1rem; font-weight:1500; color:#F9FAFB; }
.tc-widget-meta{
    font-size:0.8rem;
    color:#F8E6A3;
    text-align:right;
    font-weight:1500;
    letter-spacing:0.02em;
    padding:0.25rem 0.55rem;
    border-radius:999px;
    background:rgba(212,175,55,0.16);
    border:1px solid rgba(212,175,55,0.35);
}

.tc-result{ margin-bottom:1rem; }
.tc-result.tc-card{ padding:0.75rem; }
.tc-result-h{ font-size:0.72rem; letter-spacing:0.08em; font-weight:1500; color:#9CA3AF; text-transform:uppercase; margin-bottom:0.35rem; }
.tc-result-gym{ font-size:1rem; font-weight:1500; color:#D4AF37; margin-bottom:0.25rem; }
.tc-result-line{ font-size:0.85rem; color:#E5E7EB; }

.tc-hero-cards{
    display:grid;
    grid-template-columns:repeat(4, minmax(0, 1fr));
    gap:0.75rem;
    align-items:stretch;
    grid-auto-rows:1fr;
}
.tc-hero-card{
    overflow:hidden;
    height:100%;
    box-sizing:border-box;
    align-self:stretch;
}
.tc-hero-card.tc-widget{
    height:160px;
    margin:0;
}
.tc-hero-card .tc-widget-header{
    padding:0.55rem 0.75rem;
}
.tc-hero-card .tc-widget-body{
    padding:0.75rem;
    display:flex;
    flex-direction:column;
    height:calc(100% - 44px);
}
.tc-hero-cards .tc-hero-card + .tc-hero-card{
    margin-top:0;
}
.tc-hero-title{ font-weight:1500; color:#E5E7EB; font-size:0.88rem; }
.tc-hero-value{ font-weight:1500; color:#D4AF37; font-size:0.88rem; }
.tc-hero-desc{
    color:#9CA3AF;
    font-size:0.76rem;
    line-height:1.2;
    height:2.4em;
    margin-bottom:0.35rem;
    overflow:hidden;
}
.tc-hero-energy{ color:#D1D5DB; font-size:0.76rem; }
.tc-hero-controls{
    margin-top:auto;
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:0.4rem;
}
.tc-hero-qty{
    width:28px;
    height:28px;
    border-radius:6px;
    border:1px solid rgba(55,65,81,0.7);
    background:rgba(0,0,0,0.35);
    color:#E5E7EB;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:0.8rem;
    font-weight:1500;
    padding:0;
    text-align:center;
}
.tc-hero-form{ margin:0; display:flex; align-items:center; gap:0.4rem; }
.tc-hero-train{
    width:120px;
    height:30px;
    border-radius:6px;
    border:1px solid rgba(212,175,55,0.75);
    background:rgba(212,175,55,0.12);
    color:#D4AF37;
    font-weight:1500;
    letter-spacing:0.04em;
}
.tc-hero-train:hover{ background:rgba(212,175,55,0.18); }
.tc-hero-train:disabled{ opacity:0.55; cursor:not-allowed; }

.tc-gym-features{ margin-top:18px; }
.tc-gym-features .tc-widget-body{ padding:22px 26px; }
.tc-gym-features-wrap{
    display:grid;
    grid-template-columns:1fr 1.1fr;
    gap:18px;
    align-items:start;
}
.tc-gym-grid{
    display:grid;
    grid-template-columns:repeat(6, minmax(0, 1fr));
    gap:10px;
    max-height:190px;
    overflow:auto;
    padding-right:4px;
}
.tc-gym-tile{
    appearance:none;
    border:1px solid rgba(255,255,255,0.23);
    background:rgba(0,0,0,0.25);
    border-radius:12px;
    padding:8px 6px;
    text-align:center;
    display:grid;
    gap:6px;
    align-content:start;
    color:inherit;
    text-decoration:none;
    transition:transform .12s ease, border-color .12s ease;
}
@media (hover:hover){
    .tc-gym-tile:hover{ transform:translateY(-1px); }
}
.tc-gym-tile.is-active{
    border-color:rgba(255,255,255,0.33);
    transform:translateY(-1px);
}
.tc-gym-tile.is-locked{ opacity:0.65; cursor:default; }
.tc-gym-tile-icon{
    width:24px;
    height:24px;
    border-radius:8px;
    display:grid;
    place-items:center;
    margin:0 auto;
    color:#D4AF37;
    border:none;
    background:transparent;
    font-weight:1500;
}
.tc-gym-tile-label{
    font-size:12px;
    opacity:.9;
    line-height:1.1;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}
.tc-gym-tile-tier{
    font-size:11px;
    opacity:.75;
}
.tc-gym-detail{
    border:1px solid rgba(255,255,255,0.21);
    background:rgba(0,0,0,0.21);
    border-radius:16px;
    padding:16px 16px 14px;
}
.tc-gym-detail-pills{
    display:flex;
    flex-wrap:wrap;
    gap:6px;
}
.tc-gym-pill{
    padding:0.2rem 0.45rem;
    border-radius:999px;
    border:1px solid rgba(55,65,81,0.6);
    font-size:0.72rem;
    color:#9CA3AF;
}
.tc-gym-detail-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:100%;
    padding:0.4rem 0.5rem;
    border-radius:8px;
    border:1px solid rgba(212,175,55,0.75);
    background:rgba(212,175,55,0.12);
    color:#D4AF37;
    font-weight:1500;
    text-decoration:none;
}
.tc-gym-detail-btn:hover{ background:rgba(212,175,55,0.18); }
.tc-gym-detail-lock{
    border-radius:12px;
    border:1px solid rgba(55,65,81,0.7);
    background:rgba(3,7,18,0.78);
    padding:0.65rem;
    text-align:center;
    margin-top:12px;
}
.tc-gym-detail-locktitle{ font-weight:1500; color:#F9FAFB; margin-bottom:0.35rem; }
.tc-gym-detail-lockreq{ font-size:0.78rem; color:#9CA3AF; }

@media (max-width: 768px){
    .tc-hero-cards{ grid-template-columns:1fr; }
}
@media (max-width: 980px){
    .tc-gym-features-wrap{ grid-template-columns:1fr; }
    .tc-gym-grid{ grid-template-columns:repeat(4, minmax(0, 1fr)); max-height:none; }
}
@media (max-width: 520px){
    .tc-gym-grid{ grid-template-columns:repeat(3, minmax(0, 1fr)); }
}
</style>

</body>
</html>

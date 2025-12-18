<?php
/**
 * ===============================================================
 * TRENCH CITY - GYM TRAINING SYSTEM (Phase 3)
 * ===============================================================
 * Full-featured gym training module with:
 * - Multiple gyms with unlock requirements
 * - Energy-based training system
 * - Dynamic stat gain calculation
 * - XP rewards
 * - Training history logs
 * - Dark Luxury UI theme
 *
 * Author: Architect
 * Version: 1.0.0
 * ===============================================================
 */

// Bootstrap and authentication
require_once __DIR__ . '/../../core/bootstrap.php';
requireLogin();

// Initialize database connection
global $db;

// Get current user data
$userId = currentUserId();
$user = getUser($userId);
$stats = getUserStats($userId);
$bars = getUserBars($userId);

// Validate data loaded
if (!$user || !$stats || !$bars) {
    header('Location: /dashboard.php');
    exit;
}

// Initialize response variables
$successMessage = '';
$errorMessage = '';
$trainingResult = null;

// ===============================================================
// PROCESS TRAINING ACTION
// ===============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'train') {

    // CSRF Protection
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errorMessage = 'Invalid session. Please refresh the page and try again.';
    }

    // Get form data
    $gymId = isset($_POST['gym_id']) ? (int)$_POST['gym_id'] : 0;
    $statType = isset($_POST['stat_type']) ? trim($_POST['stat_type']) : '';

    // Validate stat type
    $validStats = ['strength', 'speed', 'defense', 'dexterity'];
    if (empty($errorMessage) && !in_array($statType, $validStats)) {
        $errorMessage = 'Invalid stat type selected.';
    }

    // Fetch gym data
    if (empty($errorMessage)) {
        $gym = $db->fetchOne(
            "SELECT * FROM gyms WHERE id = :id LIMIT 1",
            ['id' => $gymId]
        );

        if (!$gym) {
            $errorMessage = 'Invalid gym selected.';
        }
    }

    // Check if gym is unlocked
    if (empty($errorMessage) && $gym) {
        $isUnlocked = $db->fetchOne(
            "SELECT id FROM gym_unlocks WHERE user_id = :user_id AND gym_id = :gym_id LIMIT 1",
            ['user_id' => $userId, 'gym_id' => $gymId]
        );

        // Street Gym (tier 1) is always unlocked
        if (!$isUnlocked && (int)$gym['tier'] > 1) {
            $errorMessage = 'This gym is locked. You must unlock it first.';
        }
    }

    // Check energy requirement
    if (empty($errorMessage) && $gym) {
        $energyCost = (int)$gym['energy_cost_per_train'];
        $currentEnergy = (int)$bars['energy_current'];

        if ($currentEnergy < $energyCost) {
            $errorMessage = "Not enough energy. You need {$energyCost} energy to train at this gym.";
        }
    }

    // Process training
    if (empty($errorMessage) && $gym) {
        try {
            // Start transaction
            $db->beginTransaction();

            // Calculate stat gain
            $currentStatValue = (int)$stats[$statType];
            $baseGain = (int)$gym['base_stat_gain'];

            // Apply dynamic gain formula based on current stat level
            $statGainMultiplier = 1.0;
            if ($currentStatValue < 100) {
                // Early levels: higher gains
                $statGainMultiplier = 1.5;
            } elseif ($currentStatValue < 1000) {
                // Mid levels: moderate gains
                $statGainMultiplier = 1.0;
            } else {
                // High levels: slower gains
                $statGainMultiplier = 0.5;
            }

            // Apply happiness bonus (0-20% bonus based on happiness)
            $happyBonus = ((int)$bars['happy_current'] / (int)$bars['happy_max']) * 0.20;
            $finalMultiplier = $statGainMultiplier * (1 + $happyBonus);

            // Calculate final stat gain (minimum 1)
            $statGain = max(1, (int)ceil($baseGain * $finalMultiplier));
            $newStatValue = $currentStatValue + $statGain;

            // Calculate XP reward (10-20 XP based on gym tier)
            $xpGain = 10 + ((int)$gym['tier'] * 2);

            // Update player stats
            $db->execute(
                "UPDATE player_stats SET {$statType} = :new_value WHERE user_id = :user_id",
                ['new_value' => $newStatValue, 'user_id' => $userId]
            );

            // Update energy
            $newEnergy = $currentEnergy - $energyCost;
            $db->execute(
                "UPDATE player_bars SET energy_current = :energy WHERE user_id = :user_id",
                ['energy' => $newEnergy, 'user_id' => $userId]
            );

            // Award XP
            awardXP($userId, $xpGain);

            // Log training session
            $db->execute(
                "INSERT INTO training_logs (user_id, gym_id, stat_trained, energy_spent, stat_gain, xp_gained, created_at)
                 VALUES (:user_id, :gym_id, :stat_trained, :energy_spent, :stat_gain, :xp_gained, NOW())",
                [
                    'user_id' => $userId,
                    'gym_id' => $gymId,
                    'stat_trained' => $statType,
                    'energy_spent' => $energyCost,
                    'stat_gain' => $statGain,
                    'xp_gained' => $xpGain
                ]
            );

            // Commit transaction
            $db->commit();

            // Set success message
            $trainingResult = [
                'stat' => ucfirst($statType),
                'gain' => $statGain,
                'new_value' => $newStatValue,
                'xp_gained' => $xpGain,
                'energy_spent' => $energyCost,
                'gym_name' => $gym['name']
            ];

            $successMessage = "Training complete! +{$statGain} " . ucfirst($statType) . " | +{$xpGain} XP";

            // Refresh user data
            $stats = getUserStats($userId);
            $bars = getUserBars($userId);
            $user = getUser($userId);

        } catch (Exception $e) {
            $db->rollBack();
            $errorMessage = 'Training failed. Please try again.';
            tc_log("[GYM] Training error for user {$userId}: {$e->getMessage()}", 'error');
        }
    }
}

// ===============================================================
// PROCESS GYM UNLOCK
// ===============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'unlock') {

    $gymId = isset($_POST['gym_id']) ? (int)$_POST['gym_id'] : 0;

    // Fetch gym data
    $gym = $db->fetchOne(
        "SELECT * FROM gyms WHERE id = :id LIMIT 1",
        ['id' => $gymId]
    );

    if (!$gym) {
        $errorMessage = 'Invalid gym selected.';
    }

    // Check if already unlocked
    if (empty($errorMessage)) {
        $isUnlocked = $db->fetchOne(
            "SELECT id FROM gym_unlocks WHERE user_id = :user_id AND gym_id = :gym_id LIMIT 1",
            ['user_id' => $userId, 'gym_id' => $gymId]
        );

        if ($isUnlocked) {
            $errorMessage = 'You have already unlocked this gym.';
        }
    }

    // Check funds
    if (empty($errorMessage)) {
        $unlockCostCash = (float)$gym['unlock_cost_cash'];
        $unlockCostBank = (float)$gym['unlock_cost_bank'];
        $userCash = (float)$user['cash'];
        $userBank = (float)$user['bank_balance'];

        if ($userCash < $unlockCostCash || $userBank < $unlockCostBank) {
            $errorMessage = 'Insufficient funds to unlock this gym.';
        }
    }

    // Process unlock
    if (empty($errorMessage)) {
        try {
            $db->beginTransaction();

            // Deduct costs
            $newCash = $userCash - $unlockCostCash;
            $newBank = $userBank - $unlockCostBank;

            $db->execute(
                "UPDATE users SET cash = :cash, bank_balance = :bank WHERE id = :user_id",
                ['cash' => $newCash, 'bank' => $newBank, 'user_id' => $userId]
            );

            // Unlock gym
            $db->execute(
                "INSERT INTO gym_unlocks (user_id, gym_id, unlocked_at) VALUES (:user_id, :gym_id, NOW())",
                ['user_id' => $userId, 'gym_id' => $gymId]
            );

            $db->commit();

            $successMessage = "Gym unlocked successfully! You can now train at {$gym['name']}.";

            // Refresh user data
            $user = getUser($userId);

        } catch (Exception $e) {
            $db->rollBack();
            $errorMessage = 'Failed to unlock gym. Please try again.';
            tc_log("[GYM] Unlock error for user {$userId}: {$e->getMessage()}", 'error');
        }
    }
}

// ===============================================================
// FETCH ALL GYMS WITH UNLOCK STATUS
// ===============================================================
$gyms = $db->fetchAll("SELECT * FROM gyms ORDER BY tier ASC");

// Get all unlocked gym IDs for current user
$unlockedGymIds = [];
$unlockedGyms = $db->fetchAll(
    "SELECT gym_id FROM gym_unlocks WHERE user_id = :user_id",
    ['user_id' => $userId]
);
foreach ($unlockedGyms as $unlock) {
    $unlockedGymIds[] = (int)$unlock['gym_id'];
}

// ===============================================================
// FETCH RECENT TRAINING LOGS
// ===============================================================
$recentTraining = $db->fetchAll(
    "SELECT tl.*, g.name as gym_name
     FROM training_logs tl
     INNER JOIN gyms g ON tl.gym_id = g.id
     WHERE tl.user_id = :user_id
     ORDER BY tl.created_at DESC
     LIMIT 10",
    ['user_id' => $userId]
);

// Calculate total stats for requirements checking
$totalStats = (int)$stats['strength'] + (int)$stats['speed'] +
              (int)$stats['defense'] + (int)$stats['dexterity'];

// ===============================================================
// RENDER HTML
// ===============================================================
$tc_page_title = 'Gym - Trench City';
include __DIR__ . '/../../includes/postlogin-header.php';
?>

<!-- Sidebar -->
<?php include __DIR__ . '/../../includes/postlogin-sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="content-header">
            <h1 class="content-title">Gym Training</h1>
            <p class="content-description">Build your stats and become stronger</p>
        </div>

        <!-- Success/Error Messages -->
        <?php if ($successMessage): ?>
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            <div class="alert-content">
                <div class="alert-message"><?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
        <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
            <div class="alert-content">
                <div class="alert-message"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Training Result Details -->
        <?php if ($trainingResult): ?>
        <div class="card" style="margin-bottom: 1.5rem; border: 2px solid #D4AF37;">
            <div class="card-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
                <h2 class="card-title" style="color: #D4AF37;">Training Results</h2>
            </div>
            <div class="card-body">
                <div class="grid grid-2" style="gap: 1rem;">
                    <div style="text-align: center; padding: 1rem; background: rgba(212, 175, 55, 0.1); border-radius: 8px;">
                        <div style="font-size: 2rem; color: #D4AF37; margin-bottom: 0.5rem;">+<?php echo $trainingResult['gain']; ?></div>
                        <div style="font-size: 0.875rem; color: #9CA3AF;"><?php echo $trainingResult['stat']; ?> Gain</div>
                        <div style="font-size: 0.75rem; color: #6B7280; margin-top: 0.25rem;">
                            <?php echo number_format($trainingResult['new_value'] - $trainingResult['gain']); ?> �
                            <?php echo number_format($trainingResult['new_value']); ?>
                        </div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: rgba(59, 130, 246, 0.1); border-radius: 8px;">
                        <div style="font-size: 2rem; color: #3B82F6; margin-bottom: 0.5rem;">+<?php echo $trainingResult['xp_gained']; ?></div>
                        <div style="font-size: 0.875rem; color: #9CA3AF;">Experience Points</div>
                        <div style="font-size: 0.75rem; color: #6B7280; margin-top: 0.25rem;">
                            -<?php echo $trainingResult['energy_spent']; ?> Energy
                        </div>
                    </div>
                </div>
                <div style="text-align: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #374151;">
                    <p style="font-size: 0.875rem; color: #9CA3AF; margin: 0;">
                        Trained at <span style="color: #D4AF37; font-weight: 600;"><?php echo htmlspecialchars($trainingResult['gym_name'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Current Stats Overview -->
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <h2 class="card-title">Your Combat Stats</h2>
            </div>
            <div class="card-body">
                <div class="grid grid-2" style="gap: 1.5rem;">
                    <!-- Strength -->
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="color: #9CA3AF; font-size: 0.875rem;">Strength</span>
                            <span style="color: #F9FAFB; font-weight: 600;"><?php echo number_format((int)$stats['strength']); ?></span>
                        </div>
                        <div class="bar-wrapper" style="height: 10px;">
                            <div class="bar-fill bar-life" style="width: <?php echo min(100, ((int)$stats['strength'] / 50)); ?>%;"></div>
                        </div>
                    </div>

                    <!-- Defense -->
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="color: #9CA3AF; font-size: 0.875rem;">Defense</span>
                            <span style="color: #F9FAFB; font-weight: 600;"><?php echo number_format((int)$stats['defense']); ?></span>
                        </div>
                        <div class="bar-wrapper" style="height: 10px;">
                            <div class="bar-fill bar-nerve" style="width: <?php echo min(100, ((int)$stats['defense'] / 50)); ?>%;"></div>
                        </div>
                    </div>

                    <!-- Speed -->
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="color: #9CA3AF; font-size: 0.875rem;">Speed</span>
                            <span style="color: #F9FAFB; font-weight: 600;"><?php echo number_format((int)$stats['speed']); ?></span>
                        </div>
                        <div class="bar-wrapper" style="height: 10px;">
                            <div class="bar-fill bar-happy" style="width: <?php echo min(100, ((int)$stats['speed'] / 50)); ?>%;"></div>
                        </div>
                    </div>

                    <!-- Dexterity -->
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="color: #9CA3AF; font-size: 0.875rem;">Dexterity</span>
                            <span style="color: #F9FAFB; font-weight: 600;"><?php echo number_format((int)$stats['dexterity']); ?></span>
                        </div>
                        <div class="bar-wrapper" style="height: 10px;">
                            <div class="bar-fill bar-energy" style="width: <?php echo min(100, ((int)$stats['dexterity'] / 50)); ?>%;"></div>
                        </div>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #374151;">
                    <div style="display: inline-block; padding: 0.5rem 1rem; background: rgba(212, 175, 55, 0.1); border-radius: 6px;">
                        <span style="color: #9CA3AF; font-size: 0.875rem;">Total Stats:</span>
                        <span style="color: #D4AF37; font-weight: 700; font-size: 1.125rem; margin-left: 0.5rem;">
                            <?php echo number_format($totalStats); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Gyms -->
        <div class="page-section">
            <div class="section-header">
                <h2 class="section-title">Available Gyms</h2>
                <p class="section-description">Choose a gym to train your stats</p>
            </div>

            <div class="grid grid-2" style="gap: 1.5rem;">
                <?php foreach ($gyms as $gym):
                    $gymId = (int)$gym['id'];
                    $isUnlocked = in_array($gymId, $unlockedGymIds) || (int)$gym['tier'] === 1;
                    $energyCost = (int)$gym['energy_cost_per_train'];
                    $hasEnoughEnergy = (int)$bars['energy_current'] >= $energyCost;
                    $canTrain = $isUnlocked && $hasEnoughEnergy;
                    $tierLabel = ['', 'Basic', 'Advanced', 'Elite', 'Premium'][(int)$gym['tier']] ?? 'Unknown';
                ?>
                <div class="card <?php echo $isUnlocked ? '' : 'card-locked'; ?>" style="<?php echo $isUnlocked ? '' : 'opacity: 0.7; border-color: #4B5563;'; ?>">
                    <div class="card-header" style="position: relative;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 class="card-title"><?php echo htmlspecialchars($gym['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <span class="badge badge-<?php echo $isUnlocked ? 'success' : 'secondary'; ?>" style="font-size: 0.75rem;">
                                <?php echo $tierLabel; ?>
                            </span>
                        </div>
                        <?php if (!$isUnlocked): ?>
                        <div style="position: absolute; top: 1rem; right: 1rem; font-size: 1.5rem; opacity: 0.5;">=</div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <p style="color: #9CA3AF; font-size: 0.875rem; margin-bottom: 1rem;">
                            <?php echo htmlspecialchars($gym['description'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>

                        <div class="divider"></div>

                        <!-- Gym Stats -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin: 1rem 0;">
                            <div>
                                <div style="color: #6B7280; font-size: 0.75rem; margin-bottom: 0.25rem;">Energy Cost</div>
                                <div style="color: #3B82F6; font-weight: 600;"><?php echo $energyCost; ?> Energy</div>
                            </div>
                            <div>
                                <div style="color: #6B7280; font-size: 0.75rem; margin-bottom: 0.25rem;">Base Gain</div>
                                <div style="color: #10B981; font-weight: 600;">+<?php echo (int)$gym['base_stat_gain']; ?> per train</div>
                            </div>
                        </div>

                        <?php if (!$isUnlocked): ?>
                        <div class="divider"></div>
                        <div style="margin-top: 1rem; padding: 0.75rem; background: rgba(239, 68, 68, 0.1); border-radius: 6px; border: 1px solid rgba(239, 68, 68, 0.3);">
                            <div style="color: #EF4444; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Unlock Requirements</div>
                            <div style="color: #9CA3AF; font-size: 0.8125rem;">
                                <?php if ((float)$gym['unlock_cost_cash'] > 0): ?>
                                <div>Cash: <?php echo formatCash((float)$gym['unlock_cost_cash']); ?></div>
                                <?php endif; ?>
                                <?php if ((float)$gym['unlock_cost_bank'] > 0): ?>
                                <div>Bank: <?php echo formatCash((float)$gym['unlock_cost_bank']); ?></div>
                                <?php endif; ?>
                            </div>
                            <form method="POST" style="margin-top: 0.75rem;">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="action" value="unlock">
                                <input type="hidden" name="gym_id" value="<?php echo $gymId; ?>">
                                <button type="submit" class="btn btn-warning btn-block">
                                    Unlock Gym
                                </button>
                            </form>
                        </div>
                        <?php else: ?>
                        <div class="divider"></div>

                        <!-- Training Actions -->
                        <div style="margin-top: 1rem;">
                            <div style="color: #9CA3AF; font-size: 0.75rem; margin-bottom: 0.75rem; text-align: center;">
                                Select stat to train:
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                                <form method="POST" style="margin: 0;">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="action" value="train">
                                    <input type="hidden" name="gym_id" value="<?php echo $gymId; ?>">
                                    <input type="hidden" name="stat_type" value="strength">
                                    <button type="submit" class="btn btn-primary btn-block btn-sm" <?php echo $canTrain ? '' : 'disabled'; ?>>
                                        Strength
                                    </button>
                                </form>
                                <form method="POST" style="margin: 0;">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="action" value="train">
                                    <input type="hidden" name="gym_id" value="<?php echo $gymId; ?>">
                                    <input type="hidden" name="stat_type" value="defense">
                                    <button type="submit" class="btn btn-primary btn-block btn-sm" <?php echo $canTrain ? '' : 'disabled'; ?>>
                                        Defense
                                    </button>
                                </form>
                                <form method="POST" style="margin: 0;">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="action" value="train">
                                    <input type="hidden" name="gym_id" value="<?php echo $gymId; ?>">
                                    <input type="hidden" name="stat_type" value="speed">
                                    <button type="submit" class="btn btn-primary btn-block btn-sm" <?php echo $canTrain ? '' : 'disabled'; ?>>
                                        Speed
                                    </button>
                                </form>
                                <form method="POST" style="margin: 0;">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="action" value="train">
                                    <input type="hidden" name="gym_id" value="<?php echo $gymId; ?>">
                                    <input type="hidden" name="stat_type" value="dexterity">
                                    <button type="submit" class="btn btn-primary btn-block btn-sm" <?php echo $canTrain ? '' : 'disabled'; ?>>
                                        Dexterity
                                    </button>
                                </form>
                            </div>
                            <?php if (!$hasEnoughEnergy): ?>
                            <div style="text-align: center; margin-top: 0.5rem; color: #EF4444; font-size: 0.75rem;">
                                Not enough energy
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recent Training History -->
        <?php if (!empty($recentTraining)): ?>
        <div class="page-section" style="margin-top: 2rem;">
            <div class="section-header">
                <h2 class="section-title">Recent Training Sessions</h2>
            </div>

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
                                    <td style="font-size: 0.8125rem; color: #9CA3AF;">
                                        <?php echo date('M j, g:i A', strtotime($log['created_at'])); ?>
                                    </td>
                                    <td style="color: #F9FAFB; font-weight: 500;">
                                        <?php echo htmlspecialchars($log['gym_name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            <?php echo ucfirst($log['stat_trained']); ?>
                                        </span>
                                    </td>
                                    <td style="color: #10B981; font-weight: 600;">
                                        +<?php echo (int)$log['stat_gain']; ?>
                                    </td>
                                    <td style="color: #3B82F6;">
                                        -<?php echo (int)$log['energy_spent']; ?>
                                    </td>
                                    <td style="color: #D4AF37; font-weight: 600;">
                                        +<?php echo (int)$log['xp_gained']; ?>
                                    </td>
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

<!-- Load CSS Assets -->
<link rel="stylesheet" href="/assets/css/tc-tokens.css">
<link rel="stylesheet" href="/assets/css/tc-themes.css">
<link rel="stylesheet" href="/assets/css/tc-components.css">
<link rel="stylesheet" href="/assets/css/tc-layout.css">

<!-- Custom Gym Styles -->
<style>
/* Gym-specific enhancements */
.card-locked {
    position: relative;
}

.card-locked::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: repeating-linear-gradient(
        45deg,
        transparent,
        transparent 10px,
        rgba(75, 85, 99, 0.05) 10px,
        rgba(75, 85, 99, 0.05) 20px
    );
    pointer-events: none;
    border-radius: 8px;
}

.btn-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.btn-block {
    width: 100%;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table thead {
    background: rgba(31, 41, 55, 0.5);
}

.table th {
    padding: 0.75rem 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #9CA3AF;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #374151;
}

.table td {
    padding: 0.875rem 1rem;
    border-bottom: 1px solid #1F2937;
    font-size: 0.875rem;
}

.table tbody tr:hover {
    background: rgba(31, 41, 55, 0.3);
}

.table tbody tr:last-child td {
    border-bottom: none;
}

.badge {
    display: inline-block;
    padding: 0.25rem 0.625rem;
    font-size: 0.75rem;
    font-weight: 600;
    line-height: 1;
    border-radius: 0.375rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.badge-success {
    background: rgba(16, 185, 129, 0.2);
    color: #10B981;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.badge-secondary {
    background: rgba(107, 114, 128, 0.2);
    color: #9CA3AF;
    border: 1px solid rgba(107, 114, 128, 0.3);
}

.badge-warning {
    background: rgba(245, 158, 11, 0.2);
    color: #F59E0B;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .grid-2 {
        grid-template-columns: 1fr;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        min-width: 600px;
    }
}
</style>

</body>
</html>

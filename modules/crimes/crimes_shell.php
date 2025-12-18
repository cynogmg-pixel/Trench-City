<?php
/**
 * ===============================================================
 * TRENCH CITY - CRIMES SYSTEM (Phase 4)
 * ===============================================================
 * Full-featured criminal activities module with:
 * - 5 crime categories (Petty � Elite)
 * - Nerve-based system (1-15 nerve per crime)
 * - Dynamic success calculation based on stats + level
 * - Cash and XP rewards
 * - Jail/Hospital mechanics with lockout timers
 * - Crime history tracking
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
$crimeResult = null;

// ===============================================================
// CHECK JAIL/HOSPITAL STATUS
// ===============================================================
$isInJail = false;
$jailReleaseTime = null;
$isInHospital = false;
$hospitalReleaseTime = null;

if (!empty($user['jail_until'])) {
    $jailUntil = strtotime($user['jail_until']);
    if ($jailUntil > time()) {
        $isInJail = true;
        $jailReleaseTime = $user['jail_until'];
    }
}

if (!empty($user['hospital_until'])) {
    $hospitalUntil = strtotime($user['hospital_until']);
    if ($hospitalUntil > time()) {
        $isInHospital = true;
        $hospitalReleaseTime = $user['hospital_until'];
    }
}

// ===============================================================
// PROCESS CRIME ATTEMPT
// ===============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'commit_crime') {

    // CSRF Protection
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errorMessage = 'Invalid session. Please refresh the page and try again.';
    }
    // Check if player is in jail or hospital
    elseif ($isInJail) {
        $errorMessage = 'You cannot commit crimes while in jail!';
    } elseif ($isInHospital) {
        $errorMessage = 'You cannot commit crimes while in the hospital!';
    } else {
        // Get crime ID
        $crimeId = isset($_POST['crime_id']) ? (int)$_POST['crime_id'] : 0;

        // Fetch crime data
        $crime = $db->fetchOne(
            "SELECT * FROM crimes WHERE id = :id LIMIT 1",
            ['id' => $crimeId]
        );

        if (!$crime) {
            $errorMessage = 'Invalid crime selected.';
        }

        // Check level requirement
        if (empty($errorMessage) && (int)$user['level'] < (int)$crime['min_level']) {
            $errorMessage = "You need to be level {$crime['min_level']} to commit this crime.";
        }

        // Check stats requirement (total stats)
        if (empty($errorMessage)) {
            $totalStats = (int)$stats['strength'] + (int)$stats['speed'] +
                         (int)$stats['defense'] + (int)$stats['dexterity'];
            if ($totalStats < (int)$crime['min_stats']) {
                $errorMessage = "You need at least {$crime['min_stats']} total stats to commit this crime.";
            }
        }

        // Check nerve requirement
        if (empty($errorMessage)) {
            $nerveCost = (int)$crime['nerve_cost'];
            $currentNerve = (int)$bars['nerve_current'];

            if ($currentNerve < $nerveCost) {
                $errorMessage = "Not enough nerve. You need {$nerveCost} nerve to commit this crime.";
            }
        }

        // Process crime attempt
        if (empty($errorMessage) && $crime) {
            try {
                // Start transaction
                $db->beginTransaction();

                // Calculate success rate
                $totalStats = (int)$stats['strength'] + (int)$stats['speed'] +
                             (int)$stats['defense'] + (int)$stats['dexterity'];
                $baseSuccessRate = (float)$crime['base_success_rate'];
                $statBonus = $totalStats / 100; // 1% per 100 total stats
                $levelBonus = (int)$user['level'] / 2; // 0.5% per level

                $finalSuccessRate = min(95, $baseSuccessRate + $statBonus + $levelBonus);

                // Roll for success
                $roll = mt_rand(1, 10000) / 100; // Random 0.01 - 100.00
                $isSuccess = $roll <= $finalSuccessRate;

                // Initialize result variables
                $cashEarned = 0;
                $xpEarned = 0;
                $wentToJail = false;
                $wentToHospital = false;

                // Process success
                if ($isSuccess) {
                    // Calculate cash reward
                    $cashMin = (float)$crime['cash_min'];
                    $cashMax = (float)$crime['cash_max'];
                    $cashEarned = mt_rand((int)($cashMin * 100), (int)($cashMax * 100)) / 100;

                    // Award full XP
                    $xpEarned = (int)$crime['xp_reward'];

                    // Award cash
                    $db->execute(
                        "UPDATE users SET cash = cash + :cash WHERE id = :id",
                        ['cash' => $cashEarned, 'id' => $userId]
                    );

                    // Award XP
                    awardXP($userId, $xpEarned);

                    $successMessage = "Success! You earned " . formatCash($cashEarned) . " and {$xpEarned} XP!";
                } else {
                    // Crime failed - award reduced XP
                    $xpEarned = (int)round((int)$crime['xp_reward'] * 0.3); // 30% XP on failure
                    awardXP($userId, $xpEarned);

                    // Roll for jail
                    $jailRoll = mt_rand(1, 10000) / 100;
                    if ($jailRoll <= (float)$crime['jail_chance']) {
                        $wentToJail = true;
                        $jailMinutes = mt_rand(30, 60); // 30-60 minutes
                        $jailUntil = date('Y-m-d H:i:s', time() + ($jailMinutes * 60));

                        $db->execute(
                            "UPDATE users SET jail_until = :jail_until WHERE id = :id",
                            ['jail_until' => $jailUntil, 'id' => $userId]
                        );

                        $errorMessage = "Crime failed! You were caught and sent to jail for {$jailMinutes} minutes!";
                    }

                    // Roll for hospital (if not jailed)
                    if (!$wentToJail) {
                        $hospitalRoll = mt_rand(1, 10000) / 100;
                        if ($hospitalRoll <= (float)$crime['hospital_chance']) {
                            $wentToHospital = true;
                            $hospitalMinutes = mt_rand(15, 30); // 15-30 minutes
                            $hospitalUntil = date('Y-m-d H:i:s', time() + ($hospitalMinutes * 60));

                            $db->execute(
                                "UPDATE users SET hospital_until = :hospital_until WHERE id = :id",
                                ['hospital_until' => $hospitalUntil, 'id' => $userId]
                            );

                            $errorMessage = "Crime failed! You were injured and hospitalized for {$hospitalMinutes} minutes!";
                        }
                    }

                    // If neither jail nor hospital, just failed
                    if (!$wentToJail && !$wentToHospital) {
                        $errorMessage = "Crime failed! You earned {$xpEarned} XP from the experience.";
                    }
                }

                // Deduct nerve
                $newNerve = max(0, (int)$bars['nerve_current'] - (int)$crime['nerve_cost']);
                updateUserBars($userId, ['nerve_current' => $newNerve]);

                // Log crime attempt
                $db->execute(
                    "INSERT INTO crime_logs (user_id, crime_id, success, cash_earned, xp_earned, jail, hospital, created_at)
                     VALUES (:user_id, :crime_id, :success, :cash_earned, :xp_earned, :jail, :hospital, NOW())",
                    [
                        'user_id' => $userId,
                        'crime_id' => $crimeId,
                        'success' => $isSuccess ? 1 : 0,
                        'cash_earned' => $cashEarned,
                        'xp_earned' => $xpEarned,
                        'jail' => $wentToJail ? 1 : 0,
                        'hospital' => $wentToHospital ? 1 : 0
                    ]
                );

                // Commit transaction
                $db->commit();

                // Store result for display
                $crimeResult = [
                    'crime_name' => $crime['name'],
                    'success' => $isSuccess,
                    'cash_earned' => $cashEarned,
                    'xp_earned' => $xpEarned,
                    'jail' => $wentToJail,
                    'hospital' => $wentToHospital,
                    'success_rate' => round($finalSuccessRate, 2)
                ];

                // Reload user data
                $user = getUser($userId);
                $bars = getUserBars($userId);

                // Update jail/hospital status
                if ($wentToJail) {
                    $isInJail = true;
                    $jailReleaseTime = $jailUntil;
                }
                if ($wentToHospital) {
                    $isInHospital = true;
                    $hospitalReleaseTime = $hospitalUntil;
                }

            } catch (Exception $e) {
                $db->rollback();
                $errorMessage = 'An error occurred while processing the crime. Please try again.';
                tc_log("[CRIMES] Error: {$e->getMessage()}", 'error');
            }
        }
    }
}

// ===============================================================
// FETCH ALL CRIMES BY CATEGORY
// ===============================================================
$categoriesOrder = ['petty', 'theft', 'violence', 'organized', 'elite'];
$crimesByCategory = [];

foreach ($categoriesOrder as $category) {
    $crimes = $db->fetchAll(
        "SELECT * FROM crimes WHERE category = :category ORDER BY min_level ASC, difficulty ASC",
        ['category' => $category]
    );
    $crimesByCategory[$category] = $crimes ?: [];
}

// Calculate total stats for requirements checking
$totalStats = (int)$stats['strength'] + (int)$stats['speed'] +
             (int)$stats['defense'] + (int)$stats['dexterity'];

// ===============================================================
// FETCH CRIME HISTORY (Last 10 attempts)
// ===============================================================
$crimeHistory = $db->fetchAll(
    "SELECT cl.*, c.name as crime_name, c.category
     FROM crime_logs cl
     JOIN crimes c ON cl.crime_id = c.id
     WHERE cl.user_id = :user_id
     ORDER BY cl.created_at DESC
     LIMIT 10",
    ['user_id' => $userId]
);

// Calculate success rate
$totalAttempts = $db->fetchOne(
    "SELECT COUNT(*) as total, SUM(success) as successes FROM crime_logs WHERE user_id = :user_id",
    ['user_id' => $userId]
);

$successRate = 0;
if ($totalAttempts && (int)$totalAttempts['total'] > 0) {
    $successRate = round(((int)$totalAttempts['successes'] / (int)$totalAttempts['total']) * 100, 1);
}

// ===============================================================
// HTML OUTPUT
// ===============================================================
$tc_page_title = 'Crimes - Trench City';
include __DIR__ . '/../../includes/postlogin-header.php';
?>

<!-- Main Content -->
<div class="main-content">
    <div class="content-wrapper">
        <style>

        .header {
            background: var(--bg-card);
            border: 2px solid var(--gold);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(203, 161, 53, 0.15);
        }

        .header h1 {
            color: var(--gold);
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 0 0 20px rgba(203, 161, 53, 0.5);
        }

        .header p {
            color: var(--text-dim);
            font-size: 1.1em;
        }

        .stats-bar {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-label {
            color: var(--text-dim);
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .stat-value {
            color: var(--gold);
            font-size: 1.4em;
            font-weight: bold;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(46, 204, 113, 0.15);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .alert-error {
            background: rgba(231, 76, 60, 0.15);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .alert-warning {
            background: rgba(243, 156, 18, 0.15);
            border: 1px solid var(--warning);
            color: var(--warning);
        }

        .lockout-notice {
            background: var(--bg-card);
            border: 2px solid var(--danger);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: center;
        }

        .lockout-notice h2 {
            color: var(--danger);
            margin-bottom: 15px;
        }

        .lockout-timer {
            font-size: 2em;
            color: var(--gold);
            font-weight: bold;
            margin: 15px 0;
        }

        .category-section {
            margin-bottom: 35px;
        }

        .category-header {
            background: linear-gradient(135deg, var(--bg-card) 0%, #252525 100%);
            border-left: 4px solid var(--gold);
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .category-header h2 {
            color: var(--gold);
            font-size: 1.8em;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .crimes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .crime-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .crime-card:hover {
            border-color: var(--gold);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(203, 161, 53, 0.2);
        }

        .crime-card.locked {
            opacity: 0.5;
            border-color: var(--text-dim);
        }

        .crime-card.locked:hover {
            transform: none;
            box-shadow: none;
        }

        .crime-header {
            border-bottom: 1px solid var(--border);
            padding-bottom: 12px;
            margin-bottom: 15px;
        }

        .crime-name {
            color: var(--gold);
            font-size: 1.3em;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .crime-description {
            color: var(--text-dim);
            font-size: 0.9em;
            line-height: 1.4;
        }

        .crime-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin: 15px 0;
        }

        .crime-stat {
            background: rgba(203, 161, 53, 0.1);
            padding: 8px;
            border-radius: 5px;
            text-align: center;
        }

        .crime-stat-label {
            color: var(--text-dim);
            font-size: 0.75em;
            display: block;
            margin-bottom: 3px;
        }

        .crime-stat-value {
            color: var(--gold);
            font-weight: bold;
            font-size: 1.1em;
        }

        .requirements {
            background: rgba(52, 152, 219, 0.1);
            border-left: 3px solid var(--info);
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 0.9em;
        }

        .requirements.failed {
            background: rgba(231, 76, 60, 0.1);
            border-left-color: var(--danger);
        }

        .commit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dim) 100%);
            color: var(--bg-dark);
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .commit-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 16px rgba(203, 161, 53, 0.4);
        }

        .commit-btn:disabled {
            background: var(--text-dim);
            cursor: not-allowed;
            transform: none;
        }

        .history-section {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 25px;
            margin-top: 40px;
        }

        .history-section h2 {
            color: var(--gold);
            margin-bottom: 20px;
            font-size: 1.8em;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
        }

        .history-table th {
            background: rgba(203, 161, 53, 0.15);
            color: var(--gold);
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid var(--gold);
        }

        .history-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
        }

        .history-table tr:hover {
            background: var(--bg-hover);
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.85em;
            font-weight: bold;
        }

        .badge-success {
            background: var(--success);
            color: white;
        }

        .badge-failed {
            background: var(--danger);
            color: white;
        }

        .badge-jail {
            background: var(--warning);
            color: white;
        }

        .badge-hospital {
            background: var(--info);
            color: white;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: var(--gold);
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: var(--text-light);
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .crimes-grid {
                grid-template-columns: 1fr;
            }

            .stats-bar {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 1.8em;
            }

            .history-table {
                font-size: 0.85em;
            }
        }
    </style>

        <!-- Page Header -->
        <div class="content-header">
            <h1 class="content-title">Criminal Activities</h1>
            <p class="content-description">Choose your crime, test your luck, and reap the rewards... or face the consequences.</p>
        </div>

        <!-- Stats Bar -->
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-label">Nerve</div>
                <div class="stat-value"><?php echo (int)$bars['nerve_current']; ?> / <?php echo (int)$bars['nerve_max']; ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Level</div>
                <div class="stat-value"><?php echo (int)$user['level']; ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Total Stats</div>
                <div class="stat-value"><?php echo formatNumber($totalStats); ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Cash</div>
                <div class="stat-value"><?php echo formatCash((float)$user['cash']); ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Success Rate</div>
                <div class="stat-value"><?php echo $successRate; ?>%</div>
            </div>
        </div>

        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <?php if ($isInJail): ?>
            <div class="lockout-notice">
                <h2>= You Are In Jail</h2>
                <p>You were caught during a crime and are serving time.</p>
                <div class="lockout-timer" id="jail-timer" data-release="<?php echo $jailReleaseTime; ?>">
                    Calculating...
                </div>
                <p>You cannot commit crimes until your sentence is complete.</p>
            </div>
        <?php elseif ($isInHospital): ?>
            <div class="lockout-notice">
                <h2><� You Are In The Hospital</h2>
                <p>You were injured during a crime and are recovering.</p>
                <div class="lockout-timer" id="hospital-timer" data-release="<?php echo $hospitalReleaseTime; ?>">
                    Calculating...
                </div>
                <p>You cannot commit crimes until you are released.</p>
            </div>
        <?php endif; ?>

        <!-- Crime Categories -->
        <?php
        $categoryNames = [
            'petty' => 'Petty Crimes',
            'theft' => 'Theft & Burglary',
            'violence' => 'Violent Crimes',
            'organized' => 'Organized Crime',
            'elite' => 'Elite Operations'
        ];

        foreach ($categoriesOrder as $category):
            if (empty($crimesByCategory[$category])) continue;
        ?>
            <div class="category-section">
                <div class="category-header">
                    <h2><?php echo $categoryNames[$category]; ?></h2>
                </div>

                <div class="crimes-grid">
                    <?php foreach ($crimesByCategory[$category] as $crime):
                        // Check requirements
                        $meetsLevel = (int)$user['level'] >= (int)$crime['min_level'];
                        $meetsStats = $totalStats >= (int)$crime['min_stats'];
                        $hasNerve = (int)$bars['nerve_current'] >= (int)$crime['nerve_cost'];
                        $canCommit = $meetsLevel && $meetsStats && $hasNerve && !$isInJail && !$isInHospital;

                        // Calculate success rate for this crime
                        $baseSuccessRate = (float)$crime['base_success_rate'];
                        $statBonus = $totalStats / 100;
                        $levelBonus = (int)$user['level'] / 2;
                        $finalSuccessRate = min(95, $baseSuccessRate + $statBonus + $levelBonus);
                    ?>
                        <div class="crime-card <?php echo $canCommit ? '' : 'locked'; ?>">
                            <div class="crime-header">
                                <div class="crime-name"><?php echo htmlspecialchars($crime['name']); ?></div>
                                <div class="crime-description"><?php echo htmlspecialchars($crime['description']); ?></div>
                            </div>

                            <div class="crime-stats">
                                <div class="crime-stat">
                                    <span class="crime-stat-label">Nerve Cost</span>
                                    <span class="crime-stat-value"><?php echo (int)$crime['nerve_cost']; ?></span>
                                </div>
                                <div class="crime-stat">
                                    <span class="crime-stat-label">Success Rate</span>
                                    <span class="crime-stat-value"><?php echo round($finalSuccessRate, 1); ?>%</span>
                                </div>
                                <div class="crime-stat">
                                    <span class="crime-stat-label">Cash Reward</span>
                                    <span class="crime-stat-value"><?php echo formatCash((float)$crime['cash_min']); ?> - <?php echo formatCash((float)$crime['cash_max']); ?></span>
                                </div>
                                <div class="crime-stat">
                                    <span class="crime-stat-label">XP Reward</span>
                                    <span class="crime-stat-value"><?php echo formatNumber((int)$crime['xp_reward']); ?> XP</span>
                                </div>
                            </div>

                            <div class="requirements <?php echo $canCommit ? '' : 'failed'; ?>">
                                <strong>Requirements:</strong><br>
                                Level: <?php echo (int)$crime['min_level']; ?> <?php echo $meetsLevel ? '' : ''; ?><br>
                                Total Stats: <?php echo formatNumber((int)$crime['min_stats']); ?> <?php echo $meetsStats ? '' : ''; ?><br>
                                Risk: Jail <?php echo (float)$crime['jail_chance']; ?>% | Hospital <?php echo (float)$crime['hospital_chance']; ?>%
                            </div>

                            <form method="POST" style="margin-top: 15px;">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="action" value="commit_crime">
                                <input type="hidden" name="crime_id" value="<?php echo (int)$crime['id']; ?>">
                                <button type="submit" class="commit-btn" <?php echo $canCommit ? '' : 'disabled'; ?>>
                                    Commit Crime
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Crime History -->
        <?php if (!empty($crimeHistory)): ?>
            <div class="history-section">
                <h2>Recent Criminal Activity</h2>
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Crime</th>
                            <th>Result</th>
                            <th>Cash</th>
                            <th>XP</th>
                            <th>Consequences</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($crimeHistory as $log): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($log['crime_name']); ?></td>
                                <td>
                                    <?php if ((int)$log['success']): ?>
                                        <span class="badge badge-success">SUCCESS</span>
                                    <?php else: ?>
                                        <span class="badge badge-failed">FAILED</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo formatCash((float)$log['cash_earned']); ?></td>
                                <td><?php echo formatNumber((int)$log['xp_earned']); ?></td>
                                <td>
                                    <?php if ((int)$log['jail']): ?>
                                        <span class="badge badge-jail">JAIL</span>
                                    <?php endif; ?>
                                    <?php if ((int)$log['hospital']): ?>
                                        <span class="badge badge-hospital">HOSPITAL</span>
                                    <?php endif; ?>
                                    <?php if (!(int)$log['jail'] && !(int)$log['hospital']): ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('M j, g:i A', strtotime($log['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Timer countdown for jail/hospital
        function updateTimer(elementId, releaseTime) {
            const element = document.getElementById(elementId);
            if (!element) return;

            const targetTime = new Date(releaseTime).getTime();

            function update() {
                const now = new Date().getTime();
                const distance = targetTime - now;

                if (distance < 0) {
                    element.textContent = 'Released! Refresh page.';
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                element.textContent = `${hours}h ${minutes}m ${seconds}s`;
            }

            update();
            setInterval(update, 1000);
        }

        // Initialize timers
        const jailTimer = document.getElementById('jail-timer');
        if (jailTimer) {
            updateTimer('jail-timer', jailTimer.getAttribute('data-release'));
        }

        const hospitalTimer = document.getElementById('hospital-timer');
        if (hospitalTimer) {
            updateTimer('hospital-timer', hospitalTimer.getAttribute('data-release'));
        }
    </script>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

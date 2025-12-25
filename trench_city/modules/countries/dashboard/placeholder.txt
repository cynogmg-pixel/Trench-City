<?php
/**
 * ================================================================
 * COMBAT SYSTEM - PLAYER VS PLAYER
 * Trench City V2 Master Skeleton
 * ================================================================
 *
 * Features:
 * - Player vs Player attacks
 * - Dynamic combat calculation based on stats
 * - Hospital system for defeated players
 * - Cash stealing mechanics
 * - XP rewards for combat
 * - Attack history and statistics
 * - Energy-based system
 *
 * @version 1.0.0
 * @author Trench City Development Team
 */

// ================================================================
// BOOTSTRAP & SECURITY
// ================================================================

require_once __DIR__ . '/../../core/bootstrap.php';
requireLogin();
if (function_exists('tc_enforce_feature_flag')) {
    tc_enforce_feature_flag('disable_fighting', 'Combat Offline', 'Combat is temporarily disabled by admin action.');
}

$userId = currentUserId();
$db = getDB();

// ================================================================
// HELPER FUNCTIONS
// ================================================================

/**
 * Get combat configuration value
 */
function getCombatConfig(string $key, $default = null) {
    global $db;
    $row = $db->fetchOne(
        "SELECT config_value FROM combat_config WHERE config_key = :key LIMIT 1",
        ['key' => $key]
    );
    return $row['config_value'] ?? $default;
}

/**
 * Check if player is in hospital or jail
 */
function getPlayerStatus(int $userId): array {
    global $db;
    $user = $db->fetchOne(
        "
        SELECT
            username,
            level,
            cash,
            hospital_until,
            jail_until,
            status
        FROM users
        WHERE id = :id
    ",
        ['id' => $userId]
    );

    if (!$user) {
        return ['available' => false, 'reason' => 'User not found'];
    }

    $now = new DateTime();

    // Check if in hospital
    if ($user['hospital_until']) {
        $hospitalUntil = new DateTime($user['hospital_until']);
        if ($hospitalUntil > $now) {
            return [
                'available' => false,
                'reason' => 'hospitalized',
                'until' => $hospitalUntil->format('Y-m-d H:i:s'),
                'user' => $user
            ];
        }
    }

    // Check if in jail
    if ($user['jail_until']) {
        $jailUntil = new DateTime($user['jail_until']);
        if ($jailUntil > $now) {
            return [
                'available' => false,
                'reason' => 'jailed',
                'until' => $jailUntil->format('Y-m-d H:i:s'),
                'user' => $user
            ];
        }
    }

    // Check if banned
    if ($user['status'] !== 'active') {
        return [
            'available' => false,
            'reason' => 'inactive',
            'user' => $user
        ];
    }

    return [
        'available' => true,
        'user' => $user
    ];
}

/**
 * Calculate total battle stats for a player
 */
function getTotalBattleStats(int $userId): int {
    global $db;

    // Get base stats
    $baseRow = $db->fetchOne(
        "
        SELECT
            COALESCE(strength, 0) +
            COALESCE(speed, 0) +
            COALESCE(defense, 0) +
            COALESCE(dexterity, 0) as total_stats
        FROM player_stats
        WHERE user_id = :id
    ",
        ['id' => $userId]
    );
    $baseStats = (int)($baseRow['total_stats'] ?? 40); // Default minimum stats (10 each * 4)

    // Get equipped item bonuses from market_items
    $bonusRow = $db->fetchOne(
        "
        SELECT
            SUM(COALESCE(m.strength_bonus, 0)) +
            SUM(COALESCE(m.defense_bonus, 0)) +
            SUM(COALESCE(m.speed_bonus, 0)) as total_item_bonus
        FROM user_inventory i
        JOIN market_items m ON i.item_id = m.id
        WHERE i.user_id = :id AND i.equipped = 1
    ",
        ['id' => $userId]
    );
    $itemBonus = (int)($bonusRow['total_item_bonus'] ?? 0);

    return $baseStats + $itemBonus;
}

/**
 * Calculate combat outcome
 */
function calculateCombat(int $attackerStats, int $defenderStats): array {
    $baseHitChance = (int)getCombatConfig('base_hit_chance', 50);

    // Calculate stat advantage/disadvantage
    $statDiff = $attackerStats - $defenderStats;
    $statModifier = ($statDiff / max($attackerStats, $defenderStats)) * 30; // Up to ±30% from stats

    $hitChance = $baseHitChance + $statModifier;
    $hitChance = max(5, min(95, $hitChance)); // Clamp between 5% and 95%

    $roll = mt_rand(1, 100);
    $success = $roll <= $hitChance;

    if ($success) {
        // Calculate damage based on stat difference
        $baseDamage = 20;
        $damageModifier = ($attackerStats / max($defenderStats, 1)) * 1.5;
        $damage = (int)($baseDamage * $damageModifier);
        $damage = max(10, min(100, $damage)); // Clamp damage
    } else {
        $damage = 0;
    }

    return [
        'success' => $success,
        'hit_chance' => round($hitChance, 1),
        'damage' => $damage,
        'roll' => $roll
    ];
}

/**
 * Process combat attack
 */
function processAttack(int $attackerId, int $defenderId): array {
    global $db;

    // Check energy
    $bars = getUserBars($attackerId);
    $energyCost = (int)getCombatConfig('energy_cost_attack', 10);

    if ($bars['energy_current'] < $energyCost) {
        return [
            'success' => false,
            'error' => "Not enough energy! You need {$energyCost} energy to attack."
        ];
    }

    // Check attacker status
    $attackerStatus = getPlayerStatus($attackerId);
    if (!$attackerStatus['available']) {
        return [
            'success' => false,
            'error' => 'You cannot attack while in ' . $attackerStatus['reason']
        ];
    }

    // Check defender status
    $defenderStatus = getPlayerStatus($defenderId);
    if (!$defenderStatus['available']) {
        $reason = $defenderStatus['reason'] == 'hospitalized' ? 'in the hospital' : 'unavailable';
        return [
            'success' => false,
            'error' => 'Target is ' . $reason
        ];
    }

    // Can't attack yourself
    if ($attackerId == $defenderId) {
        return [
            'success' => false,
            'error' => 'You cannot attack yourself!'
        ];
    }

    // Get stats
    $attackerStats = getTotalBattleStats($attackerId);
    $defenderStats = getTotalBattleStats($defenderId);
    $defender = $defenderStatus['user'];

    // Calculate combat
    $combat = calculateCombat($attackerStats, $defenderStats);

    $db->beginTransaction();

    try {
        // Deduct energy
        updateUserBars($attackerId, [
            'energy_current' => $bars['energy_current'] - $energyCost
        ]);

        $cashStolen = 0;
        $hospitalTime = 0;
        $outcome = 'loss';

        if ($combat['success']) {
            // Attacker wins
            $outcome = 'win';

            // Calculate cash stolen
            $minPercent = (float)getCombatConfig('cash_steal_percent_min', 1);
            $maxPercent = (float)getCombatConfig('cash_steal_percent_max', 5);
            $stealPercent = mt_rand((int)($minPercent * 100), (int)($maxPercent * 100)) / 100;
            $cashStolen = min($defender['cash'], $defender['cash'] * ($stealPercent / 100));
            $cashStolen = round($cashStolen, 2);

            // Transfer cash
            if ($cashStolen > 0) {
                $db->execute(
                    "UPDATE users SET cash = cash - :amount WHERE id = :id",
                    ['amount' => $cashStolen, 'id' => $defenderId]
                );
                $db->execute(
                    "UPDATE users SET cash = cash + :amount WHERE id = :id",
                    ['amount' => $cashStolen, 'id' => $attackerId]
                );
            }

            // Hospitalize defender
            $minTime = (int)getCombatConfig('hospital_time_min', 15);
            $maxTime = (int)getCombatConfig('hospital_time_max', 60);
            $hospitalTime = mt_rand($minTime, $maxTime);

            $hospitalUntil = (new DateTime())->add(new DateInterval("PT{$hospitalTime}M"));
            $db->execute(
                "UPDATE users SET hospital_until = :until WHERE id = :id",
                [
                    'until' => $hospitalUntil->format('Y-m-d H:i:s'),
                    'id' => $defenderId
                ]
            );

            // Award XP to attacker
            $xpGain = (int)getCombatConfig('xp_base_win', 50);
            awardXP($attackerId, $xpGain);
        } else {
            // Attacker loses
            $xpGain = (int)getCombatConfig('xp_base_loss', 10);
            awardXP($attackerId, $xpGain);
        }

        // Log combat
        $db->execute(
            "
            INSERT INTO combat_logs
            (attacker_id, defender_id, success, damage_dealt, xp_earned, cash_stolen,
             attacker_total_stats, defender_total_stats, outcome, hospital_time)
            VALUES (:attacker_id, :defender_id, :success, :damage_dealt, :xp_earned, :cash_stolen,
                    :attacker_total_stats, :defender_total_stats, :outcome, :hospital_time)
        ",
            [
                'attacker_id' => $attackerId,
                'defender_id' => $defenderId,
                'success' => (int)$combat['success'],
                'damage_dealt' => $combat['damage'],
                'xp_earned' => $xpGain,
                'cash_stolen' => $cashStolen,
                'attacker_total_stats' => $attackerStats,
                'defender_total_stats' => $defenderStats,
                'outcome' => $outcome,
                'hospital_time' => $hospitalTime
            ]
        );

        $db->commit();

        return [
            'success' => true,
            'combat' => $combat,
            'outcome' => $outcome,
            'cash_stolen' => $cashStolen,
            'xp_earned' => $xpGain,
            'hospital_time' => $hospitalTime,
            'defender' => $defender
        ];

    } catch (Exception $e) {
        $db->rollBack();
        return [
            'success' => false,
            'error' => 'Combat failed: ' . $e->getMessage()
        ];
    }
}

/**
 * Get recent combat history
 */
function getCombatHistory(int $userId, int $limit = 10): array {
    global $db;

    return $db->fetchAll("
        SELECT
            cl.*,
            CASE
                WHEN cl.attacker_id = :user_id THEN 'attack'
                ELSE 'defense'
            END as battle_type,
            CASE
                WHEN cl.attacker_id = :user_id THEN u_defender.username
                ELSE u_attacker.username
            END as opponent_name,
            CASE
                WHEN cl.attacker_id = :user_id THEN u_defender.level
                ELSE u_attacker.level
            END as opponent_level
        FROM combat_logs cl
        LEFT JOIN users u_attacker ON cl.attacker_id = u_attacker.id
        LEFT JOIN users u_defender ON cl.defender_id = u_defender.id
        WHERE cl.attacker_id = :user_id OR cl.defender_id = :user_id
        ORDER BY cl.created_at DESC
        LIMIT :limit_rows
    ",
        ['user_id' => $userId, 'limit_rows' => $limit]
    );
}

/**
 * Find players to attack
 */
function findTargets(int $userId, int $limit = 20): array {
    global $db;

    $userLevel = getUser($userId)['level'];

    $minLevel = max(1, $userLevel - 10);
    $maxLevel = $userLevel + 10;

    return $db->fetchAll("
        SELECT
            u.id,
            u.username,
            u.level,
            u.cash,
            (ps.strength + ps.speed + ps.defense + ps.dexterity) as total_stats
        FROM users u
        LEFT JOIN player_stats ps ON u.id = ps.user_id
        WHERE u.id != :user_id
            AND u.status = 'active'
            AND (u.hospital_until IS NULL OR u.hospital_until < NOW())
            AND (u.jail_until IS NULL OR u.jail_until < NOW())
            AND u.level BETWEEN :min_level AND :max_level
        ORDER BY RAND()
        LIMIT :limit_rows
    ",
        [
            'user_id' => $userId,
            'min_level' => $minLevel,
            'max_level' => $maxLevel,
            'limit_rows' => $limit
        ]
    );
}

// ================================================================
// REQUEST HANDLING
// ================================================================

$action = $_POST['action'] ?? $_GET['action'] ?? 'view';
$message = '';
$error = '';

// Handle attack action
if ($action === 'attack' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token. Please refresh the page and try again.';
    } else {
        $targetId = (int)($_POST['target_id'] ?? 0);

        if ($targetId > 0) {
            $result = processAttack($userId, $targetId);

            if ($result['success']) {
                if ($result['outcome'] === 'win') {
                    $message = "Victory! You defeated {$result['defender']['username']} (Level {$result['defender']['level']}). ";
                    $message .= "You stole £" . formatCash($result['cash_stolen']) . " and earned {$result['xp_earned']} XP. ";
                    $message .= "They are hospitalized for {$result['hospital_time']} minutes.";
                } else {
                    $message = "You were defeated by {$result['defender']['username']}! You earned {$result['xp_earned']} XP for trying.";
                }
            } else {
                $error = $result['error'];
            }
        }
    }
}

// Get current player data
$user = getUser($userId);
$stats = getUserStats($userId);
$bars = getUserBars($userId);
$totalStats = getTotalBattleStats($userId);

// Get combat history
$history = getCombatHistory($userId, 10);

// Get available targets
$targets = findTargets($userId, 20);

// Check if player is hospitalized
$playerStatus = getPlayerStatus($userId);
$isHospitalized = !$playerStatus['available'] && $playerStatus['reason'] === 'hospitalized';
$hospitalUntil = $isHospitalized ? new DateTime($playerStatus['until']) : null;

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$tc_page_title = 'Combat Arena - Trench City';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<main class="tc-main-content">
        <h1 class="tc-page-title">⚔️ Combat Arena</h1>

        <?php if ($message): ?>
            <div class="tc-alert tc-alert--success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="tc-alert tc-alert--danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($isHospitalized): ?>
            <div class="tc-card tc-card--danger">
                <h2>🏥 Hospitalized</h2>
                <p>You are currently recovering in the hospital.</p>
                <p>You will be released in: <strong id="hospital-timer">Calculating...</strong></p>
            </div>
            <script>
                const hospitalUntil = new Date('<?= $hospitalUntil->format('Y-m-d H:i:s') ?>');
                function updateHospitalTimer() {
                    const now = new Date();
                    const diff = hospitalUntil - now;
                    if (diff <= 0) {
                        document.getElementById('hospital-timer').textContent = 'You can leave now!';
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        const minutes = Math.floor(diff / 60000);
                        const seconds = Math.floor((diff % 60000) / 1000);
                        document.getElementById('hospital-timer').textContent = `${minutes}m ${seconds}s`;
                    }
                }
                setInterval(updateHospitalTimer, 1000);
                updateHospitalTimer();
            </script>
        <?php else: ?>

        <!-- Player Stats Card -->
        <div class="tc-card">
            <h2>Your Battle Stats</h2>
            <div class="tc-stats-grid">
                <div>
                    <strong>Total Stats:</strong> <?= number_format($totalStats) ?>
                </div>
                <div>
                    <strong>Strength:</strong> <?= number_format($stats['strength']) ?>
                </div>
                <div>
                    <strong>Speed:</strong> <?= number_format($stats['speed']) ?>
                </div>
                <div>
                    <strong>Defense:</strong> <?= number_format($stats['defense']) ?>
                </div>
                <div>
                    <strong>Dexterity:</strong> <?= number_format($stats['dexterity']) ?>
                </div>
                <div>
                    <strong>Energy:</strong> <?= $bars['energy_current'] ?> / <?= $bars['energy_max'] ?>
                </div>
            </div>
        </div>

        <!-- Available Targets -->
        <div class="tc-card">
            <h2>Available Targets</h2>
            <?php if (empty($targets)): ?>
                <p>No suitable targets found. Try again later or train your stats!</p>
            <?php else: ?>
                <table class="tc-table">
                    <thead>
                        <tr>
                            <th>Player</th>
                            <th>Level</th>
                            <th>Total Stats</th>
                            <th>Cash</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($targets as $target): ?>
                            <tr>
                                <td><?= htmlspecialchars($target['username']) ?></td>
                                <td><?= $target['level'] ?></td>
                                <td><?= number_format($target['total_stats'] ?: 40) ?></td>
                                <td>£<?= formatCash($target['cash']) ?></td>
                                <td>
                                    <?php if ($bars['energy_current'] >= 10): ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="attack">
                                            <input type="hidden" name="target_id" value="<?= $target['id'] ?>">
                                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                            <button type="submit" class="tc-btn tc-btn--danger tc-btn--sm">Attack</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="tc-text-muted">No Energy</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <?php endif; // End hospitalized check ?>

        <!-- Combat History -->
        <div class="tc-card">
            <h2>Combat History</h2>
            <?php if (empty($history)): ?>
                <p>No combat history yet. Start fighting to build your reputation!</p>
            <?php else: ?>
                <table class="tc-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Opponent</th>
                            <th>Result</th>
                            <th>Cash</th>
                            <th>XP</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $battle): ?>
                            <?php
                                $isAttacker = $battle['battle_type'] === 'attack';
                                $wonBattle = ($isAttacker && $battle['success']) || (!$isAttacker && !$battle['success']);
                                $resultClass = $wonBattle ? 'tc-text-success' : 'tc-text-danger';
                                $resultText = $wonBattle ? '✓ Won' : '✗ Lost';
                            ?>
                            <tr>
                                <td><?= $isAttacker ? '⚔️ Attack' : '🛡️ Defense' ?></td>
                                <td><?= htmlspecialchars($battle['opponent_name']) ?> (Lv<?= $battle['opponent_level'] ?>)</td>
                                <td class="<?= $resultClass ?>"><?= $resultText ?></td>
                                <td>£<?= formatCash($battle['cash_stolen']) ?></td>
                                <td>+<?= $battle['xp_earned'] ?> XP</td>
                                <td><?= date('M j, g:i A', strtotime($battle['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

</main>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>


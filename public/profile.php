<?php
require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

$currentUserId = currentUserId();
$db = getDB();

$profileId = (int)($_GET['id'] ?? $currentUserId);

// Get user profile
$profile = $db->fetchOne(
    "SELECT id, username, level, xp, cash, bank_balance, status, created_at, last_login_at FROM users WHERE id = :id",
    ['id' => $profileId]
);

if (!$profile) {
    header('Location: /dashboard.php');
    exit;
}

// Get stats
$stats = getUserStats($profileId);
$bars = getUserBars($profileId);

$isOwnProfile = ($profileId == $currentUserId);

// Get combat statistics
$combatStats = $db->fetchOne("
    SELECT
        COUNT(*) as total_fights,
        SUM(CASE WHEN attacker_id = ? AND success = 1 THEN 1 ELSE 0 END) as attack_wins,
        SUM(CASE WHEN attacker_id = ? AND success = 0 THEN 1 ELSE 0 END) as attack_losses,
        SUM(CASE WHEN defender_id = ? AND success = 0 THEN 1 ELSE 0 END) as defense_wins,
        SUM(CASE WHEN defender_id = ? AND success = 1 THEN 1 ELSE 0 END) as defense_losses
    FROM combat_logs
    WHERE attacker_id = ? OR defender_id = ?
", [$profileId, $profileId, $profileId, $profileId, $profileId, $profileId]);

$totalWins = ($combatStats['attack_wins'] ?? 0) + ($combatStats['defense_wins'] ?? 0);
$totalLosses = ($combatStats['attack_losses'] ?? 0) + ($combatStats['defense_losses'] ?? 0);
$totalFights = $combatStats['total_fights'] ?? 0;
$winRate = $totalFights > 0 ? round(($totalWins / $totalFights) * 100, 1) : 0;

// Training count
$trainingRow = $db->fetchOne(
    "SELECT COUNT(*) as total_sessions FROM training_logs WHERE user_id = :id",
    ['id' => $profileId]
);
$trainingCount = (int)($trainingRow['total_sessions'] ?? 0);

// Crime count
$crimeStats = $db->fetchOne(
    "SELECT COUNT(*) as total_crimes, SUM(CASE WHEN success = 1 THEN 1 ELSE 0 END) as successful_crimes FROM crime_logs WHERE user_id = :id",
    ['id' => $profileId]
);


$tc_page_title = htmlspecialchars($profile['username']) . "'s Profile - Trench City";
include __DIR__ . '/../includes/postlogin-header.php';
?>

<!-- Main Content -->
<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">👤 <?= htmlspecialchars($profile['username']) ?>'s Profile</h1>
            <p class="content-description">Level <?= (int)$profile['level'] ?> Player</p>
        </div>

        <?php if (!$isOwnProfile): ?>
            <div class="tc-card" style="display: flex; gap: 0.5rem;">
                <a href="/combat.php?target=<?= $profile['id'] ?>" class="tc-btn tc-btn--danger">⚔️ Attack</a>
                <a href="/mail.php?to=<?= urlencode($profile['username']) ?>" class="tc-btn tc-btn--primary">📧 Send Mail</a>
            </div>
        <?php endif; ?>

        <div class="tc-grid tc-grid--2">
            <!-- Basic Info -->
            <div class="tc-card">
                <h2>📋 Basic Information</h2>
                <table class="tc-table">
                    <tr><td><strong>Username:</strong></td><td><?= htmlspecialchars($profile['username']) ?></td></tr>
                    <tr><td><strong>Level:</strong></td><td><?= $profile['level'] ?></td></tr>
                    <tr><td><strong>XP:</strong></td><td><?= number_format($profile['xp']) ?></td></tr>
                    <tr><td><strong>Status:</strong></td><td><?= ucfirst($profile['status']) ?></td></tr>
                    <tr><td><strong>Joined:</strong></td><td><?= date('M j, Y', strtotime($profile['created_at'])) ?></td></tr>
                    <tr><td><strong>Last Seen:</strong></td><td><?= $profile['last_login_at'] ? date('M j, g:i A', strtotime($profile['last_login_at'])) : 'Never' ?></td></tr>
                </table>
            </div>

            <!-- Stats -->
            <div class="tc-card">
                <h2>💪 Battle Stats</h2>
                <table class="tc-table">
                    <tr><td><strong>Strength:</strong></td><td><?= number_format($stats['strength']) ?></td></tr>
                    <tr><td><strong>Speed:</strong></td><td><?= number_format($stats['speed']) ?></td></tr>
                    <tr><td><strong>Defense:</strong></td><td><?= number_format($stats['defense']) ?></td></tr>
                    <tr><td><strong>Dexterity:</strong></td><td><?= number_format($stats['dexterity']) ?></td></tr>
                    <tr>
                        <td><strong>Total Stats:</strong></td>
                        <td><strong><?= number_format($stats['strength'] + $stats['speed'] + $stats['defense'] + $stats['dexterity']) ?></strong></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Combat Statistics -->
        <div class="tc-card">
            <h2>⚔️ Combat Record</h2>
            <div class="tc-stats-grid">
                <div class="tc-stat-card">
                    <div class="tc-stat-label">Total Fights</div>
                    <div class="tc-stat-value"><?= number_format($totalFights) ?></div>
                </div>
                <div class="tc-stat-card">
                    <div class="tc-stat-label">Wins</div>
                    <div class="tc-stat-value tc-text-success"><?= number_format($totalWins) ?></div>
                </div>
                <div class="tc-stat-card">
                    <div class="tc-stat-label">Losses</div>
                    <div class="tc-stat-value tc-text-danger"><?= number_format($totalLosses) ?></div>
                </div>
                <div class="tc-stat-card">
                    <div class="tc-stat-label">Win Rate</div>
                    <div class="tc-stat-value"><?= $winRate ?>%</div>
                </div>
            </div>
        </div>

        <!-- Activity Statistics -->
        <div class="tc-card">
            <h2>📊 Activity Statistics</h2>
            <div class="tc-stats-grid">
                <div class="tc-stat-card">
                    <div class="tc-stat-label">Gym Sessions</div>
                    <div class="tc-stat-value"><?= number_format($trainingCount) ?></div>
                </div>
                <div class="tc-stat-card">
                    <div class="tc-stat-label">Crimes Attempted</div>
                    <div class="tc-stat-value"><?= number_format($crimeStats['total_crimes'] ?? 0) ?></div>
                </div>
                <div class="tc-stat-card">
                    <div class="tc-stat-label">Successful Crimes</div>
                    <div class="tc-stat-value tc-text-success"><?= number_format($crimeStats['successful_crimes'] ?? 0) ?></div>
                </div>
                <?php if ($isOwnProfile): ?>
                    <div class="tc-stat-card">
                        <div class="tc-stat-label">Net Worth</div>
                        <div class="tc-stat-value">£<?= formatCash($profile['cash'] + $profile['bank_balance']) ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($isOwnProfile): ?>
            <div class="tc-card">
                <h2>🔧 Quick Links</h2>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="/gym.php" class="tc-btn tc-btn--primary">💪 Train</a>
                    <a href="/crimes.php" class="tc-btn tc-btn--primary">🎭 Commit Crime</a>
                    <a href="/bank.php" class="tc-btn tc-btn--primary">🏦 Bank</a>
                    <a href="/settings.php" class="tc-btn tc-btn--secondary">⚙️ Settings</a>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>

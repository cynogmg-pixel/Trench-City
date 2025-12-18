<?php
require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

$userId = currentUserId();
$db = getDB();

$category = $_GET['category'] ?? 'level';

// Get leaderboard data
$validCategories = ['level', 'cash', 'strength', 'speed', 'defense', 'dexterity'];
if (!in_array($category, $validCategories)) $category = 'level';

if (in_array($category, ['strength', 'speed', 'defense', 'dexterity'])) {
    $leaders = $db->fetchAll("
        SELECT u.id, u.username, u.level, ps.{$category} as stat_value
        FROM users u
        LEFT JOIN player_stats ps ON u.id = ps.user_id
        WHERE u.status = 'active'
        ORDER BY ps.{$category} DESC, u.level DESC
        LIMIT 50
    ");
} elseif ($category === 'cash') {
    $leaders = $db->fetchAll("
        SELECT id, username, level, (cash + bank_balance) as stat_value
        FROM users
        WHERE status = 'active'
        ORDER BY (cash + bank_balance) DESC
        LIMIT 50
    ");
} else {
    $leaders = $db->fetchAll("
        SELECT id, username, level, xp as stat_value
        FROM users
        WHERE status = 'active'
        ORDER BY level DESC, xp DESC
        LIMIT 50
    ");
}

// Find current user's rank
$currentUserRank = 0;
foreach ($leaders as $index => $leader) {
    if ($leader['id'] == $userId) {
        $currentUserRank = $index + 1;
        break;
    }
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$tc_page_title = 'Leaderboards - Trench City';
include __DIR__ . '/../includes/postlogin-header.php';
?>

<!-- Main Content -->
<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">🏆 Leaderboards</h1>
            <p class="content-description">Top players in Trench City</p>
        </div>

        <div class="tc-card">
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
                <a href="?category=level" class="tc-btn tc-btn--<?= $category === 'level' ? 'primary' : 'secondary' ?>">📊 Level</a>
                <a href="?category=cash" class="tc-btn tc-btn--<?= $category === 'cash' ? 'primary' : 'secondary' ?>">💰 Net Worth</a>
                <a href="?category=strength" class="tc-btn tc-btn--<?= $category === 'strength' ? 'primary' : 'secondary' ?>">💪 Strength</a>
                <a href="?category=speed" class="tc-btn tc-btn--<?= $category === 'speed' ? 'primary' : 'secondary' ?>">⚡ Speed</a>
                <a href="?category=defense" class="tc-btn tc-btn--<?= $category === 'defense' ? 'primary' : 'secondary' ?>">🛡️ Defense</a>
                <a href="?category=dexterity" class="tc-btn tc-btn--<?= $category === 'dexterity' ? 'primary' : 'secondary' ?>">🎯 Dexterity</a>
            </div>

            <?php if ($currentUserRank > 0): ?>
                <div class="tc-alert tc-alert--info">Your Rank: #<?= $currentUserRank ?></div>
            <?php endif; ?>

            <table class="tc-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Player</th>
                        <th>Level</th>
                        <th><?= ucfirst($category) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leaders as $index => $leader): ?>
                        <tr <?= $leader['id'] == $userId ? 'style="background-color: rgba(212, 175, 55, 0.1);"' : '' ?>>
                            <td><strong>#<?= $index + 1 ?></strong></td>
                            <td>
                                <a href="/profile.php?id=<?= $leader['id'] ?>" style="color: var(--tc-color-primary);">
                                    <?= htmlspecialchars($leader['username']) ?>
                                </a>
                            </td>
                            <td><?= $leader['level'] ?></td>
                            <td>
                                <?php if ($category === 'cash'): ?>
                                    £<?= formatCash($leader['stat_value']) ?>
                                <?php else: ?>
                                    <?= number_format($leader['stat_value']) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>

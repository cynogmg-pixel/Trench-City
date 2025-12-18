<?php
/**
 * TRENCH CITY - PLAYERS
 * Browse and search all players in the game
 */

require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

$userId = currentUserId();
$user = getUser($userId);
$db = getDB();

if (!$user || !$db) {
    header('Location: /login.php');
    exit;
}

// Get search query if provided
$search = trim($_GET['search'] ?? '');

// Fetch players (limit to 50 for now)
if ($search) {
    $players = $db->fetchAll(
        "SELECT id, username, level, status, last_login_at, created_at
         FROM users
         WHERE username LIKE :search
         ORDER BY level DESC, username ASC
         LIMIT 50",
        ['search' => "%{$search}%"]
    );
} else {
    $players = $db->fetchAll(
        "SELECT id, username, level, status, last_login_at, created_at
         FROM users
         ORDER BY level DESC, username ASC
         LIMIT 50"
    );
}

$tc_page_title = 'Players - Trench City';
include __DIR__ . '/../includes/postlogin-header.php';
?>

<!-- Main Content -->
<div class="main-content">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="content-header">
            <h1 class="content-title">🌐 Player Directory</h1>
            <p class="content-description">Browse all players in Trench City</p>
        </div>

        <!-- Search Bar -->
        <div class="tc-card" style="margin-top: 2rem;">
            <div style="padding: 1.5rem;">
                <form method="get" action="/players.php" style="display: flex; gap: 1rem;">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search by username..."
                        value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
                        style="flex: 1; padding: 0.75rem 1rem; background: #1F2937; border: 1px solid #374151;
                               border-radius: 0.5rem; color: #F9FAFB; font-size: 0.95rem;"
                    />
                    <button
                        type="submit"
                        style="padding: 0.75rem 1.5rem; background: #D4AF37; color: #0F172A; font-weight: 600;
                               border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.background='#C49F2F'"
                        onmouseout="this.style.background='#D4AF37'"
                    >
                        🔍 Search
                    </button>
                    <?php if ($search): ?>
                        <a
                            href="/players.php"
                            style="padding: 0.75rem 1.5rem; background: #374151; color: #F9FAFB; font-weight: 600;
                                   border: none; border-radius: 0.5rem; text-decoration: none; display: flex; align-items: center;"
                        >
                            Clear
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Players List -->
        <div class="tc-card" style="margin-top: 2rem;">
            <div style="padding: 1.5rem;">
                <h2 style="color: #D4AF37; margin-bottom: 1.5rem; font-size: 1.25rem;">
                    <?= $search ? "Search Results" : "All Players" ?>
                    <span style="color: #9CA3AF; font-weight: normal; font-size: 0.9rem;">
                        (<?= count($players) ?> found)
                    </span>
                </h2>

                <?php if (empty($players)): ?>
                    <div style="text-align: center; padding: 3rem 2rem; color: #9CA3AF;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                        <p>No players found matching your search.</p>
                    </div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #374151;">
                                    <th style="padding: 1rem; text-align: left; color: #9CA3AF; font-weight: 600;">Player</th>
                                    <th style="padding: 1rem; text-align: center; color: #9CA3AF; font-weight: 600;">Level</th>
                                    <th style="padding: 1rem; text-align: center; color: #9CA3AF; font-weight: 600;">Status</th>
                                    <th style="padding: 1rem; text-align: center; color: #9CA3AF; font-weight: 600;">Last Seen</th>
                                    <th style="padding: 1rem; text-align: center; color: #9CA3AF; font-weight: 600;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($players as $player): ?>
                                    <tr style="border-bottom: 1px solid #1F2937;">
                                        <td style="padding: 1rem;">
                                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #D4AF37, #C49F2F);
                                                            border-radius: 50%; display: flex; align-items: center; justify-content: center;
                                                            color: #0F172A; font-weight: bold; font-size: 1.25rem;">
                                                    <?= strtoupper(substr($player['username'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div style="color: #F9FAFB; font-weight: 600;">
                                                        <?= htmlspecialchars($player['username'], ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                    <div style="color: #6B7280; font-size: 0.85rem;">
                                                        ID: <?= $player['id'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 1rem; text-align: center;">
                                            <span style="background: #1F2937; color: #D4AF37; padding: 0.25rem 0.75rem;
                                                         border-radius: 0.5rem; font-weight: 600;">
                                                <?= (int)($player['level'] ?? 1) ?>
                                            </span>
                                        </td>
                                        <td style="padding: 1rem; text-align: center;">
                                            <?php if ($player['status'] === 'active'): ?>
                                                <span style="color: #10B981;">✓ Active</span>
                                            <?php else: ?>
                                                <span style="color: #EF4444;">⨯ <?= ucfirst($player['status']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding: 1rem; text-align: center; color: #9CA3AF; font-size: 0.9rem;">
                                            <?php
                                            if ($player['last_login_at']) {
                                                $lastSeen = strtotime($player['last_login_at']);
                                                $diff = time() - $lastSeen;
                                                if ($diff < 300) echo "🟢 Online";
                                                elseif ($diff < 3600) echo floor($diff / 60) . "m ago";
                                                elseif ($diff < 86400) echo floor($diff / 3600) . "h ago";
                                                else echo floor($diff / 86400) . "d ago";
                                            } else {
                                                echo "Never";
                                            }
                                            ?>
                                        </td>
                                        <td style="padding: 1rem; text-align: center;">
                                            <a href="/profile.php?id=<?= $player['id'] ?>"
                                               style="color: #D4AF37; text-decoration: none; font-weight: 600;">
                                                View Profile
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if (count($players) >= 50): ?>
                        <div style="margin-top: 1.5rem; padding: 1rem; background: #1F2937; border-radius: 0.5rem;
                                    text-align: center; color: #9CA3AF;">
                            Showing first 50 results. Use search to find specific players.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>

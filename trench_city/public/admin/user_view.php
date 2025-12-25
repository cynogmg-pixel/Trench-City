<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);
$userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$user = null;
$stats = null;
$bars = null;

if ($userId > 0) {
    if (function_exists('getUser')) {
        $user = getUser($userId);
    } elseif ($db) {
        $user = $db->fetchOne("SELECT * FROM users WHERE id = :id LIMIT 1", ['id' => $userId]);
    }

    if (function_exists('getUserStats')) {
        $stats = getUserStats($userId);
    }

    if (function_exists('getUserBars')) {
        $bars = getUserBars($userId);
    }
}

$tc_page_title = 'Owner Panel - User View';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">User Profile</h1>
            <p class="content-description">Review player account details.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>

        <?php if (!$user): ?>
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <p style="color: #D1D5DB; margin: 0;">User not found.</p>
                    <div style="margin-top: 1rem;">
                        <a class="btn btn-secondary" href="/admin/users.php">Back to users</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="grid grid-2">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Account</h2>
                    </div>
                    <div class="card-body">
                        <div style="display: grid; gap: 0.75rem;">
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #9CA3AF;">ID</span>
                                <span style="color: #F9FAFB; font-weight: 600;"><?php echo (int)$user['id']; ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #9CA3AF;">Username</span>
                                <span style="color: #F9FAFB; font-weight: 600;"><?php echo htmlspecialchars($user['username'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #9CA3AF;">Email</span>
                                <span style="color: #F9FAFB; font-weight: 600;"><?php echo htmlspecialchars($user['email'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #9CA3AF;">Level</span>
                                <span style="color: #F9FAFB; font-weight: 600;"><?php echo isset($user['level']) ? (int)$user['level'] : '-'; ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #9CA3AF;">XP</span>
                                <span style="color: #F9FAFB; font-weight: 600;"><?php echo isset($user['xp']) ? number_format((int)$user['xp']) : '-'; ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #9CA3AF;">Status</span>
                                <span style="color: #F9FAFB; font-weight: 600;"><?php echo htmlspecialchars($user['status'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        </div>
                        <div style="margin-top: 1.5rem;">
                            <a class="btn btn-primary" href="/admin/user_edit.php?id=<?php echo (int)$user['id']; ?>">Edit User</a>
                            <a class="btn btn-secondary" href="/admin/users.php">Back to list</a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Balances</h2>
                    </div>
                    <div class="card-body">
                        <div style="display: grid; gap: 0.75rem;">
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #9CA3AF;">Cash</span>
                                <span style="color: #F9FAFB; font-weight: 600;"><?php echo isset($user['cash']) ? formatCash((float)$user['cash']) : '-'; ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #9CA3AF;">Bank</span>
                                <span style="color: #F9FAFB; font-weight: 600;"><?php echo isset($user['bank_balance']) ? formatCash((float)$user['bank_balance']) : '-'; ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #9CA3AF;">Last Login</span>
                                <span style="color: #F9FAFB; font-weight: 600;"><?php echo htmlspecialchars($user['last_login_at'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #9CA3AF;">Created</span>
                                <span style="color: #F9FAFB; font-weight: 600;"><?php echo htmlspecialchars($user['created_at'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-2" style="margin-top: 2rem;">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Stats</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($stats): ?>
                            <div style="display: grid; gap: 0.75rem;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #9CA3AF;">Strength</span>
                                    <span style="color: #F9FAFB; font-weight: 600;"><?php echo number_format((int)($stats['strength'] ?? 0)); ?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #9CA3AF;">Speed</span>
                                    <span style="color: #F9FAFB; font-weight: 600;"><?php echo number_format((int)($stats['speed'] ?? 0)); ?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #9CA3AF;">Defense</span>
                                    <span style="color: #F9FAFB; font-weight: 600;"><?php echo number_format((int)($stats['defense'] ?? 0)); ?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #9CA3AF;">Dexterity</span>
                                    <span style="color: #F9FAFB; font-weight: 600;"><?php echo number_format((int)($stats['dexterity'] ?? 0)); ?></span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div style="color: #9CA3AF;">No stats found.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Bars</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($bars): ?>
                            <div style="display: grid; gap: 0.75rem;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #9CA3AF;">Energy</span>
                                    <span style="color: #F9FAFB; font-weight: 600;"><?php echo (int)($bars['energy_current'] ?? 0); ?> / <?php echo (int)($bars['energy_max'] ?? 0); ?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #9CA3AF;">Nerve</span>
                                    <span style="color: #F9FAFB; font-weight: 600;"><?php echo (int)($bars['nerve_current'] ?? 0); ?> / <?php echo (int)($bars['nerve_max'] ?? 0); ?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #9CA3AF;">Happy</span>
                                    <span style="color: #F9FAFB; font-weight: 600;"><?php echo (int)($bars['happy_current'] ?? 0); ?> / <?php echo (int)($bars['happy_max'] ?? 0); ?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #9CA3AF;">Life</span>
                                    <span style="color: #F9FAFB; font-weight: 600;"><?php echo (int)($bars['life_current'] ?? 0); ?> / <?php echo (int)($bars['life_max'] ?? 0); ?></span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div style="color: #9CA3AF;">No bars found.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

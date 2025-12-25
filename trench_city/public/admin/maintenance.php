<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);
$columns = tc_admin_user_columns($db);

$flagPath = defined('STORAGE_PATH')
    ? STORAGE_PATH . '/maintenance.flag'
    : __DIR__ . '/../../storage/maintenance.flag';

$flagActive = file_exists($flagPath);
$messages = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token.';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'toggle_maintenance') {
            if ($flagActive) {
                if (@unlink($flagPath)) {
                    $flagActive = false;
                    $messages[] = 'Maintenance flag disabled.';
                } else {
                    $errors[] = 'Failed to disable maintenance flag.';
                }
            } else {
                $dir = dirname($flagPath);
                if (!is_dir($dir)) {
                    @mkdir($dir, 0750, true);
                }
                if (@file_put_contents($flagPath, 'enabled ' . date('Y-m-d H:i:s'), LOCK_EX) !== false) {
                    $flagActive = true;
                    $messages[] = 'Maintenance flag enabled.';
                } else {
                    $errors[] = 'Failed to enable maintenance flag.';
                }
            }

            if (function_exists('logPlayerAction')) {
                $adminActorId = isset($admin_user['id']) ? (int)$admin_user['id'] : 0;
                logPlayerAction($adminActorId, 'admin_maintenance_toggle', [
                    'enabled' => $flagActive,
                    'flag_path' => $flagPath,
                ]);
            }
        }

        if ($action === 'recalc_level') {
            $targetId = (int)($_POST['user_id'] ?? 0);
            if ($targetId <= 0) {
                $errors[] = 'Enter a valid user id.';
            } elseif (!in_array('xp', $columns, true) || !in_array('level', $columns, true)) {
                $errors[] = 'XP or level columns not available.';
            } elseif (!$db) {
                $errors[] = 'Database connection unavailable.';
            } else {
                try {
                    $userRow = $db->fetchOne(
                        "SELECT id, xp, level FROM users WHERE id = :id LIMIT 1",
                        ['id' => $targetId]
                    );

                    if (!$userRow) {
                        $errors[] = 'User not found.';
                    } else {
                        $currentXp = (int)($userRow['xp'] ?? 0);
                        $newLevel = calculateLevel($currentXp);
                        if ($newLevel !== (int)($userRow['level'] ?? 0)) {
                            $db->execute(
                                "UPDATE users SET level = :level WHERE id = :id",
                                ['level' => $newLevel, 'id' => $targetId]
                            );
                            $messages[] = 'Level recalculated.';
                        } else {
                            $messages[] = 'Level already synced.';
                        }

                        if (function_exists('logPlayerAction')) {
                            $adminActorId = isset($admin_user['id']) ? (int)$admin_user['id'] : 0;
                            logPlayerAction($adminActorId, 'admin_recalc_level', [
                                'target_user_id' => $targetId,
                                'xp' => $currentXp,
                                'level' => $newLevel,
                            ]);
                        }
                    }
                } catch (Throwable $e) {
                    $errors[] = 'Failed to recalculate level.';
                }
            }
        }
    }
}

$tc_page_title = 'Owner Panel - Maintenance';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Maintenance</h1>
            <p class="content-description">Owner-only maintenance controls.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>

        <?php if ($messages): ?>
            <div class="alert alert-success">
                <div class="alert-content">
                    <div class="alert-message"><?php echo htmlspecialchars(implode(' ', $messages), ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="alert alert-warning">
                <div class="alert-content">
                    <div class="alert-message"><?php echo htmlspecialchars(implode(' ', $errors), ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid grid-2">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Maintenance Mode</h2>
                </div>
                <div class="card-body">
                    <p style="color: #D1D5DB; margin-top: 0;">
                        Toggle a maintenance flag file. When enabled, post-login pages are locked for
                        non-owner users.
                    </p>
                    <div style="margin: 1rem 0; color: #9CA3AF;">
                        Status: <?php echo $flagActive ? 'Enabled' : 'Disabled'; ?>
                    </div>
                    <form method="post" action="/admin/maintenance.php">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="action" value="toggle_maintenance" />
                        <button class="btn <?php echo $flagActive ? 'btn-danger' : 'btn-primary'; ?>" type="submit">
                            <?php echo $flagActive ? 'Disable' : 'Enable'; ?> Maintenance
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Recalculate Level</h2>
                </div>
                <div class="card-body">
                    <p style="color: #D1D5DB; margin-top: 0;">Re-sync level for a single user based on XP.</p>
                    <form method="post" action="/admin/maintenance.php" style="display: grid; gap: 0.75rem; max-width: 320px;">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="action" value="recalc_level" />
                        <input
                            type="number"
                            name="user_id"
                            min="1"
                            placeholder="User ID"
                            style="padding: 0.75rem 1rem; background: #1F2937; border: 1px solid #374151;
                                   border-radius: 0.5rem; color: #F9FAFB; font-size: 0.95rem;"
                        />
                        <button class="btn btn-primary" type="submit">Recalculate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

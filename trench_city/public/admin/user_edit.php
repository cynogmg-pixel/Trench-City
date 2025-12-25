<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);
$columns = tc_admin_user_columns($db);

$targetId = isset($_POST['id']) ? (int)$_POST['id'] : (int)($_GET['id'] ?? 0);
$targetUser = null;
$bars = null;
$messages = [];
$errors = [];

$hasEmailVerified = in_array('email_verified', $columns, true);
$canAdjustXp = in_array('xp', $columns, true) && in_array('level', $columns, true);
$canAdjustBars = function_exists('updateUserBars');
$canAdjustCash = in_array('cash', $columns, true);
$canAdjustBank = in_array('bank_balance', $columns, true);
$canEditStatus = in_array('status', $columns, true);

if ($targetId > 0) {
    if (function_exists('getUser')) {
        $targetUser = getUser($targetId);
    } elseif ($db) {
        $targetUser = $db->fetchOne("SELECT * FROM users WHERE id = :id LIMIT 1", ['id' => $targetId]);
    }

    if (function_exists('getUserBars')) {
        $bars = getUserBars($targetId);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token.';
    } elseif (!$targetUser) {
        $errors[] = 'User not found.';
    } else {
        $updates = [];
        $params = ['id' => $targetId];
        $changes = [];

        if ($hasEmailVerified) {
            $newVerified = isset($_POST['email_verified']) ? 1 : 0;
            if ((int)($targetUser['email_verified'] ?? 0) !== $newVerified) {
                $updates[] = 'email_verified = :email_verified';
                $params['email_verified'] = $newVerified;
                $changes['email_verified'] = $newVerified;
            }
        }

        if ($canEditStatus && isset($_POST['status'])) {
            $newStatus = (string)$_POST['status'];
            if (in_array($newStatus, ['active', 'banned', 'inactive'], true) && ($targetUser['status'] ?? '') !== $newStatus) {
                $updates[] = 'status = :status';
                $params['status'] = $newStatus;
                $changes['status'] = $newStatus;
            }
        }

        if ($canAdjustXp && isset($_POST['xp'])) {
            $newXp = max(0, (int)$_POST['xp']);
            $newLevel = calculateLevel($newXp);
            if ((int)($targetUser['xp'] ?? 0) !== $newXp) {
                $updates[] = 'xp = :xp';
                $params['xp'] = $newXp;
                $changes['xp'] = $newXp;
            }
            if ((int)($targetUser['level'] ?? 0) !== $newLevel) {
                $updates[] = 'level = :level';
                $params['level'] = $newLevel;
                $changes['level'] = $newLevel;
            }
        }

        if ($canAdjustCash && isset($_POST['cash'])) {
            $newCash = max(0, (float)$_POST['cash']);
            if ((float)($targetUser['cash'] ?? 0) !== $newCash) {
                $updates[] = 'cash = :cash';
                $params['cash'] = $newCash;
                $changes['cash'] = $newCash;
            }
        }

        if ($canAdjustBank && isset($_POST['bank_balance'])) {
            $newBank = max(0, (float)$_POST['bank_balance']);
            if ((float)($targetUser['bank_balance'] ?? 0) !== $newBank) {
                $updates[] = 'bank_balance = :bank_balance';
                $params['bank_balance'] = $newBank;
                $changes['bank_balance'] = $newBank;
            }
        }

        if ($updates && $db) {
            try {
                $db->execute("UPDATE users SET " . implode(', ', $updates) . " WHERE id = :id", $params);
                $messages[] = 'User details updated.';
            } catch (Throwable $e) {
                $errors[] = 'Failed to update user details.';
            }
        }

        if ($canAdjustBars) {
            $barFields = ['energy_current', 'nerve_current', 'happy_current', 'life_current'];
            $barUpdates = [];
            foreach ($barFields as $field) {
                if (isset($_POST[$field]) && $_POST[$field] !== '') {
                    $barUpdates[$field] = max(0, (int)$_POST[$field]);
                }
            }

            if ($barUpdates) {
                $updated = updateUserBars($targetId, $barUpdates);
                if ($updated) {
                    $messages[] = 'Bars updated.';
                    $changes['bars'] = $barUpdates;
                } else {
                    $errors[] = 'Failed to update bars.';
                }
            }
        }

        if ($changes) {
            if (function_exists('logPlayerAction')) {
                $adminActorId = isset($admin_user['id']) ? (int)$admin_user['id'] : $targetId;
                logPlayerAction($adminActorId, 'admin_user_update', [
                    'target_user_id' => $targetId,
                    'changes' => $changes,
                ]);
            } else {
                $logDir = defined('LOG_PATH') ? LOG_PATH : __DIR__ . '/../../storage/logs';
                $entry = '[' . date('Y-m-d H:i:s') . '] admin_user_update target=' . $targetId . ' changes=' . json_encode($changes);
                @file_put_contents($logDir . '/admin_actions.log', $entry . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
        }

        if (!$errors) {
            if (function_exists('getUser')) {
                $targetUser = getUser($targetId);
            } elseif ($db) {
                $targetUser = $db->fetchOne("SELECT * FROM users WHERE id = :id LIMIT 1", ['id' => $targetId]);
            }

            if (function_exists('getUserBars')) {
                $bars = getUserBars($targetId);
            }
        }
    }
}

$tc_page_title = 'Owner Panel - User Edit';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Edit User</h1>
            <p class="content-description">Update account verification, XP, balances, and bars.</p>
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

        <?php if (!$targetUser): ?>
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <p style="color: #D1D5DB; margin: 0;">Select a user to edit.</p>
                    <div style="margin-top: 1rem;">
                        <a class="btn btn-secondary" href="/admin/users.php">Back to users</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <form method="post" action="/admin/user_edit.php?id=<?php echo (int)$targetId; ?>" style="display: grid; gap: 1.5rem;">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="id" value="<?php echo (int)$targetId; ?>" />

                        <div>
                            <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Account</h2>
                            <div style="display: grid; gap: 0.75rem;">
                                <div style="color: #9CA3AF;">Username: <span style="color: #F9FAFB; font-weight: 600;"><?php echo htmlspecialchars($targetUser['username'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></span></div>
                                <div style="color: #9CA3AF;">Email: <span style="color: #F9FAFB; font-weight: 600;"><?php echo htmlspecialchars($targetUser['email'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></span></div>
                            </div>
                        </div>

                        <div>
                            <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Verification</h2>
                            <?php if ($hasEmailVerified): ?>
                                <label style="display: inline-flex; align-items: center; gap: 0.5rem; color: #D1D5DB;">
                                    <input type="checkbox" name="email_verified" value="1" <?php echo !empty($targetUser['email_verified']) ? 'checked' : ''; ?> />
                                    Email verified
                                </label>
                            <?php else: ?>
                                <div style="color: #9CA3AF;">Email verification column not available.</div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Account Status</h2>
                            <?php if ($canEditStatus): ?>
                                <label style="display: grid; gap: 0.35rem; color: #9CA3AF; max-width: 240px;">
                                    <span>Status</span>
                                    <select name="status" style="padding: 0.6rem 0.8rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;">
                                        <?php $currentStatus = (string)($targetUser['status'] ?? 'active'); ?>
                                        <option value="active" <?php echo $currentStatus === 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="banned" <?php echo $currentStatus === 'banned' ? 'selected' : ''; ?>>Banned</option>
                                        <option value="inactive" <?php echo $currentStatus === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </label>
                            <?php else: ?>
                                <div style="color: #9CA3AF;">Status column not available.</div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Experience</h2>
                            <?php if ($canAdjustXp): ?>
                                <label style="display: grid; gap: 0.5rem; max-width: 320px;">
                                    <span style="color: #9CA3AF;">Set XP</span>
                                    <input
                                        type="number"
                                        name="xp"
                                        min="0"
                                        value="<?php echo (int)($targetUser['xp'] ?? 0); ?>"
                                        style="padding: 0.75rem 1rem; background: #1F2937; border: 1px solid #374151;
                                               border-radius: 0.5rem; color: #F9FAFB; font-size: 0.95rem;"
                                    />
                                </label>
                                <div style="color: #9CA3AF; margin-top: 0.5rem;">Level will be re-synced automatically.</div>
                            <?php else: ?>
                                <div style="color: #9CA3AF;">XP and level columns not available.</div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Balances</h2>
                            <?php if ($canAdjustCash || $canAdjustBank): ?>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; max-width: 520px;">
                                    <?php if ($canAdjustCash): ?>
                                        <label style="display: grid; gap: 0.5rem;">
                                            <span style="color: #9CA3AF;">Cash</span>
                                            <input type="number" name="cash" min="0" step="0.01" value="<?php echo isset($targetUser['cash']) ? (float)$targetUser['cash'] : 0; ?>" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                                        </label>
                                    <?php endif; ?>
                                    <?php if ($canAdjustBank): ?>
                                        <label style="display: grid; gap: 0.5rem;">
                                            <span style="color: #9CA3AF;">Bank</span>
                                            <input type="number" name="bank_balance" min="0" step="0.01" value="<?php echo isset($targetUser['bank_balance']) ? (float)$targetUser['bank_balance'] : 0; ?>" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                                        </label>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div style="color: #9CA3AF;">Cash or bank columns not available.</div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Bars</h2>
                            <?php if ($canAdjustBars): ?>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
                                    <label style="display: grid; gap: 0.5rem;">
                                        <span style="color: #9CA3AF;">Energy</span>
                                        <input type="number" name="energy_current" min="0" value="<?php echo (int)($bars['energy_current'] ?? 0); ?>" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                                    </label>
                                    <label style="display: grid; gap: 0.5rem;">
                                        <span style="color: #9CA3AF;">Nerve</span>
                                        <input type="number" name="nerve_current" min="0" value="<?php echo (int)($bars['nerve_current'] ?? 0); ?>" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                                    </label>
                                    <label style="display: grid; gap: 0.5rem;">
                                        <span style="color: #9CA3AF;">Happy</span>
                                        <input type="number" name="happy_current" min="0" value="<?php echo (int)($bars['happy_current'] ?? 0); ?>" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                                    </label>
                                    <label style="display: grid; gap: 0.5rem;">
                                        <span style="color: #9CA3AF;">Life</span>
                                        <input type="number" name="life_current" min="0" value="<?php echo (int)($bars['life_current'] ?? 0); ?>" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                                    </label>
                                </div>
                            <?php else: ?>
                                <div style="color: #9CA3AF;">Bars update helper not available.</div>
                            <?php endif; ?>
                        </div>

                        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                            <a class="btn btn-secondary" href="/admin/user_view.php?id=<?php echo (int)$targetId; ?>">View User</a>
                            <a class="btn btn-ghost" href="/admin/users.php">Back to users</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

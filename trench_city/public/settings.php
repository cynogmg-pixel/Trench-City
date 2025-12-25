<?php
/**
 * TRENCH CITY - SETTINGS
 * Account settings and preferences
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

$success = '';
$errors = [];

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errors[] = 'Invalid session. Please try again.';
    }

    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($errors)) {
        if (!password_verify($currentPassword, $user['password_hash'])) {
            $errors[] = 'Current password is incorrect.';
        } elseif (strlen($newPassword) < 8) {
            $errors[] = 'New password must be at least 8 characters.';
        } elseif ($newPassword !== $confirmPassword) {
            $errors[] = 'New passwords do not match.';
        } else {
            $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $db->execute(
                "UPDATE users SET password_hash = :hash WHERE id = :id",
                ['hash' => $newHash, 'id' => $userId]
            );
            $success = 'Password changed successfully!';
            tc_log("[SETTINGS] User {$userId} changed password", 'info');
        }
    }
}

// Handle email change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_email'])) {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errors[] = 'Invalid session. Please try again.';
    }

    $newEmail = trim($_POST['new_email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($errors)) {
        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address.';
        } elseif (!password_verify($password, $user['password_hash'])) {
            $errors[] = 'Password is incorrect.';
        } else {
            // Check if email already exists
            $existing = $db->fetchOne("SELECT id FROM users WHERE email = :email AND id != :id", [
                'email' => $newEmail,
                'id' => $userId
            ]);

            if ($existing) {
                $errors[] = 'This email is already in use.';
            } else {
                $db->execute(
                    "UPDATE users SET email = :email, email_verified = 0 WHERE id = :id",
                    ['email' => $newEmail, 'id' => $userId]
                );
                $success = 'Email updated successfully! Please verify your new email.';
                tc_log("[SETTINGS] User {$userId} changed email to {$newEmail}", 'info');

                // Refresh user data
                $user = getUser($userId);
            }
        }
    }
}

$tc_page_title = 'Settings - Trench City';
include __DIR__ . '/../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<!-- Main Content -->
<div class="main-content">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="content-header">
            <h1 class="content-title">⚙️ Account Settings</h1>
            <p class="content-description">Manage your account preferences and security</p>
        </div>

        <!-- Success/Error Messages -->
        <?php if ($success): ?>
            <div style="margin-top: 2rem; padding: 1rem 1.5rem; background: rgba(16, 185, 129, 0.25);
                        border-left: 4px solid #10B981; border-radius: 0.5rem; color: #10B981;">
                ✓ <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div style="margin-top: 2rem; padding: 1rem 1.5rem; background: rgba(239, 68, 68, 0.25);
                        border-left: 4px solid #EF4444; border-radius: 0.5rem; color: #EF4444;">
                <?php foreach ($errors as $error): ?>
                    <div>⨯ <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Account Information -->
        <div class="tc-card" style="margin-top: 2rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #1F2937;">
                <h2 style="color: #D4AF37; font-size: 1.25rem;">📋 Account Information</h2>
            </div>
            <div style="padding: 1.5rem;">
                <div style="display: grid; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; padding: 1rem; background: #1F2937; border-radius: 0.5rem;">
                        <div>
                            <div style="color: #9CA3AF; font-size: 0.85rem; margin-bottom: 0.25rem;">Username</div>
                            <div style="color: #F9FAFB; font-weight: 600;"><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?></div>
                        </div>
                        <div style="color: #6B7280; font-size: 0.85rem;">Cannot be changed</div>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding: 1rem; background: #1F2937; border-radius: 0.5rem;">
                        <div>
                            <div style="color: #9CA3AF; font-size: 0.85rem; margin-bottom: 0.25rem;">Email</div>
                            <div style="color: #F9FAFB; font-weight: 600;">
                                <?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>
                                <?php if (isset($user['email_verified']) && $user['email_verified']): ?>
                                    <span style="color: #10B981; margin-left: 0.5rem;">✓ Verified</span>
                                <?php else: ?>
                                    <span style="color: #F59E0B; margin-left: 0.5rem;">⚠ Unverified</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding: 1rem; background: #1F2937; border-radius: 0.5rem;">
                        <div>
                            <div style="color: #9CA3AF; font-size: 0.85rem; margin-bottom: 0.25rem;">Account Status</div>
                            <div style="color: #10B981; font-weight: 600;"><?= ucfirst($user['status']) ?></div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding: 1rem; background: #1F2937; border-radius: 0.5rem;">
                        <div>
                            <div style="color: #9CA3AF; font-size: 0.85rem; margin-bottom: 0.25rem;">Member Since</div>
                            <div style="color: #F9FAFB; font-weight: 600;">
                                <?= date('F j, Y', strtotime($user['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="tc-card" style="margin-top: 2rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #1F2937;">
                <h2 style="color: #D4AF37; font-size: 1.25rem;">🔒 Change Password</h2>
            </div>
            <div style="padding: 1.5rem;">
                <form method="post" action="/settings.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>" />
                    <input type="hidden" name="change_password" value="1" />

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; color: #D1D5DB; font-weight: 500; margin-bottom: 0.5rem;">
                            Current Password
                        </label>
                        <input
                            type="password"
                            name="current_password"
                            required
                            style="width: 100%; padding: 0.75rem 1rem; background: #1F2937; border: 1px solid #374151;
                                   border-radius: 0.5rem; color: #F9FAFB; font-size: 0.95rem;"
                        />
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; color: #D1D5DB; font-weight: 500; margin-bottom: 0.5rem;">
                            New Password
                        </label>
                        <input
                            type="password"
                            name="new_password"
                            required
                            minlength="8"
                            style="width: 100%; padding: 0.75rem 1rem; background: #1F2937; border: 1px solid #374151;
                                   border-radius: 0.5rem; color: #F9FAFB; font-size: 0.95rem;"
                        />
                        <div style="color: #9CA3AF; font-size: 0.85rem; margin-top: 0.5rem;">
                            Minimum 8 characters
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; color: #D1D5DB; font-weight: 500; margin-bottom: 0.5rem;">
                            Confirm New Password
                        </label>
                        <input
                            type="password"
                            name="confirm_password"
                            required
                            style="width: 100%; padding: 0.75rem 1rem; background: #1F2937; border: 1px solid #374151;
                                   border-radius: 0.5rem; color: #F9FAFB; font-size: 0.95rem;"
                        />
                    </div>

                    <button
                        type="submit"
                        style="padding: 0.75rem 2rem; background: #D4AF37; color: #0F172A; font-weight: 600;
                               border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.background='#C49F2F'"
                        onmouseout="this.style.background='#D4AF37'"
                    >
                        Update Password
                    </button>
                </form>
            </div>
        </div>

        <!-- Change Email -->
        <div class="tc-card" style="margin-top: 2rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #1F2937;">
                <h2 style="color: #D4AF37; font-size: 1.25rem;">📧 Change Email</h2>
            </div>
            <div style="padding: 1.5rem;">
                <form method="post" action="/settings.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>" />
                    <input type="hidden" name="change_email" value="1" />

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; color: #D1D5DB; font-weight: 500; margin-bottom: 0.5rem;">
                            New Email Address
                        </label>
                        <input
                            type="email"
                            name="new_email"
                            required
                            style="width: 100%; padding: 0.75rem 1rem; background: #1F2937; border: 1px solid #374151;
                                   border-radius: 0.5rem; color: #F9FAFB; font-size: 0.95rem;"
                        />
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; color: #D1D5DB; font-weight: 500; margin-bottom: 0.5rem;">
                            Confirm Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            required
                            style="width: 100%; padding: 0.75rem 1rem; background: #1F2937; border: 1px solid #374151;
                                   border-radius: 0.5rem; color: #F9FAFB; font-size: 0.95rem;"
                        />
                    </div>

                    <button
                        type="submit"
                        style="padding: 0.75rem 2rem; background: #D4AF37; color: #0F172A; font-weight: 600;
                               border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.background='#C49F2F'"
                        onmouseout="this.style.background='#D4AF37'"
                    >
                        Update Email
                    </button>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="tc-card" style="margin-top: 2rem; border: 1px solid #EF4444;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #EF4444;">
                <h2 style="color: #EF4444; font-size: 1.25rem;">⚠️ Danger Zone</h2>
            </div>
            <div style="padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="color: #F9FAFB; font-weight: 600; margin-bottom: 0.5rem;">Delete Account</div>
                        <div style="color: #9CA3AF; font-size: 0.9rem;">
                            Permanently delete your account and all associated data. This action cannot be undone.
                        </div>
                    </div>
                    <button
                        style="padding: 0.75rem 1.5rem; background: #EF4444; color: white; font-weight: 600;
                               border: none; border-radius: 0.5rem; cursor: pointer; white-space: nowrap;"
                        onclick="alert('Account deletion feature coming soon. Please contact support to delete your account.')"
                    >
                        Delete Account
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>





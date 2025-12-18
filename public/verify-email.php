<?php
/**
 * ================================================================
 * EMAIL VERIFICATION HANDLER + RESEND FLOW
 * Trench City V2
 * ================================================================
 */

require_once __DIR__ . '/../core/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$db = getDB();
$tokenParam = trim($_GET['token'] ?? '');
$success = false;
$message = '';
$errors = [];
$currentUser = null;

if (!empty($_SESSION['user_id'])) {
    // Allow unverified users to land here without getting redirected.
    requireLogin(true);
    $currentUser = getUser((int)$_SESSION['user_id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'resend') {
        if (!$currentUser) {
            $errors[] = 'You must be signed in to request a new verification email.';
        } elseif (!csrf_check($_POST['csrf_token'] ?? '')) {
            $errors[] = 'Invalid security token. Please refresh and try again.';
        } elseif ((int)($currentUser['email_verified'] ?? 0) === 1) {
            $message = 'Your email is already verified. You can proceed to the dashboard.';
        } else {
            $token = tc_issue_email_verification_token($currentUser['id'], $currentUser['email']);
            if ($token) {
                $sent = tc_send_email_verification_token($currentUser['id'], $currentUser['email'], $token);
                $message = $sent
                    ? 'Verification email resent. Please check your inbox.'
                    : 'Verification token generated. Check the dev log or notice below for the token.';
                tc_log("[AUTH] Verification resend user_id={$currentUser['id']}", 'info');
            } else {
                $errors[] = 'Unable to generate a new verification token. Please try again later.';
                tc_log("[AUTH] Verification resend failed user_id={$currentUser['id']}", 'error');
            }
        }
    }
}

if ($tokenParam !== '' && $db) {
    $user = $db->fetchOne(
        "SELECT id, username, email, email_verified, email_verification_sent_at
         FROM users
         WHERE email_verification_token = :token
         LIMIT 1",
        ['token' => $tokenParam]
    );

    if (!$user) {
        $errors[] = 'Invalid or expired verification link.';
    } elseif ((int)$user['email_verified'] === 1) {
        $success = true;
        $message = 'This email has already been verified. You can sign in now.';
    } else {
        $expiryRow = $db->fetchOne(
            "SELECT config_value FROM email_config WHERE config_key = 'verification_token_expiry' LIMIT 1"
        );
        $expiryHours = (int)($expiryRow['config_value'] ?? 24);

        $tokenExpired = false;
        if ($expiryHours > 0 && !empty($user['email_verification_sent_at'])) {
            try {
                $sentAt = new DateTime($user['email_verification_sent_at']);
                $expiresAt = (clone $sentAt)->modify("+{$expiryHours} hours");
                $tokenExpired = (new DateTime()) > $expiresAt;
            } catch (Throwable $e) {
                $tokenExpired = false;
            }
        }

        if ($tokenExpired) {
            $errors[] = "This verification link has expired (valid for {$expiryHours} hours). Please request a new one below.";
        } else {
            try {
                $db->beginTransaction();

                $db->execute(
                    "UPDATE users
                     SET email_verified = 1,
                         email_verified_at = NOW(),
                         email_verification_token = NULL
                     WHERE id = :id",
                    ['id' => $user['id']]
                );

                $db->execute(
                    "UPDATE email_verification_logs
                     SET verified_at = NOW()
                     WHERE user_id = :id AND token = :token",
                    ['id' => $user['id'], 'token' => $tokenParam]
                );

                $db->commit();

                $success = true;
                $message = "Email verified successfully! Welcome to Trench City, {$user['username']}.";
                tc_log("[AUTH] Email verified user_id={$user['id']} email={$user['email']}", 'info');

                if (!empty($_SESSION['user_id']) && (int)$_SESSION['user_id'] === (int)$user['id']) {
                    $_SESSION['email_verified'] = 1;
                    if ($currentUser) {
                        $currentUser['email_verified'] = 1;
                    }
                }
            } catch (Throwable $e) {
                if ($db->inTransaction()) {
                    $db->rollBack();
                }
                $errors[] = 'Verification failed. Please try again.';
                tc_log("[AUTH] Email verification failed: " . $e->getMessage(), 'error');
            }
        }
    }
}

$devToken = null;
if (is_dev() && isset($_SESSION['dev_last_verification_token'])) {
    $devToken = $_SESSION['dev_last_verification_token'];
    unset($_SESSION['dev_last_verification_token']);
}

$tc_page_title = 'Email Verification | Trench City';
require_once __DIR__ . '/../includes/prelogin-header.php';
?>

        <nav class="tc-app-header tc-prelogin-header">
            <div class="tc-brand-group">
                <a class="tc-brand" href="/">
                    <img
                        class="tc-brand-logo"
                        src="/assets/imgs/logo_dark.png"
                        alt="Trench City"
                        data-theme-logo
                        data-dark-logo="/assets/imgs/logo_dark.png"
                        data-light-logo="/assets/imgs/logo_light.png"
                    />
                    <span class="tc-brand-word tc-brand-word--gold">TRENCH</span>
                    <span class="tc-brand-word">CITY</span>
                </a>
                <button class="tc-theme-toggle" type="button" data-theme-toggle aria-label="Toggle color mode">
                    <span class="tc-theme-icon tc-theme-icon--sun" aria-hidden="true">&#9728;</span>
                    <span class="tc-theme-icon tc-theme-icon--moon" aria-hidden="true">&#9790;</span>
                </button>
            </div>
            <div class="tc-header-actions">
                <a class="tc-btn tc-btn-secondary" href="/">Home</a>
                <a class="tc-btn tc-btn-primary" href="/login.php">Sign in</a>
            </div>
        </nav>

        <main class="tc-prelogin-main">
            <div class="tc-prelogin-grid" style="max-width: 720px;">
                <section class="tc-card auth-card" style="padding: 32px;">
                    <h1 style="margin-bottom: 0.5rem;">Email Verification</h1>
                    <p class="tc-text-muted" style="margin-bottom: 1.25rem;">
                        Confirm your email to unlock the city. If your link expired, request a new one below.
                    </p>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <div class="alert-content">
                                <div class="alert-title">Issue detected</div>
                                <div class="alert-message"><?php echo htmlspecialchars(implode(' ', $errors), ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($message): ?>
                        <div class="alert alert-success">
                            <div class="alert-content">
                                <div class="alert-title">Update</div>
                                <div class="alert-message"><?php echo $message; ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($devToken): ?>
                        <div class="alert alert-info">
                            <div class="alert-content">
                                <div class="alert-title">Dev Mode Token</div>
                                <div class="alert-message">
                                    <code style="display:block;margin-top:0.25rem;"><?php echo htmlspecialchars($devToken, ENT_QUOTES, 'UTF-8'); ?></code>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="tc-prelogin-meta" style="margin-top: 1.25rem;">
                            <a href="/login.php" class="tc-btn tc-btn-primary" style="min-width: 150px;">Sign in</a>
                            <a href="/dashboard.php" class="tc-btn tc-btn-secondary" style="min-width: 150px;">Back to dashboard</a>
                        </div>
                    <?php endif; ?>

                    <?php if ($currentUser && (int)($currentUser['email_verified'] ?? 0) !== 1): ?>
                        <div class="tc-prelogin-divider"></div>
                        <p class="tc-text-muted" style="margin-bottom: 1rem;">
                            Need a new link? Resend it to <strong><?php echo htmlspecialchars($currentUser['email'], ENT_QUOTES, 'UTF-8'); ?></strong>.
                        </p>
                        <form method="post">
                            <input type="hidden" name="action" value="resend">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                            <button type="submit" class="tc-btn tc-btn-primary tc-btn-block">Resend verification email</button>
                        </form>
                    <?php elseif (!$tokenParam): ?>
                        <p class="tc-text-muted" style="margin-top: 1.5rem;">
                            Already have an account? Sign in to request a new verification link.
                        </p>
                    <?php endif; ?>
                </section>
            </div>
        </main>

        <footer>
            Trench City - Enter the underground empire.
        </footer>

<?php require_once __DIR__ . '/../includes/prelogin-footer.php'; ?>

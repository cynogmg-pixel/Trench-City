<?php
declare(strict_types=1);
require_once '/var/www/trench_city/core/bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();
global $db;

$errors = [];
$submitted = ($_SERVER['REQUEST_METHOD'] === 'POST');

if (!$db instanceof TCDB) {
    $errors[] = 'Service unavailable. Please try again shortly.';
}

if ($submitted) {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errors[] = 'Invalid session. Please refresh and try again.';
    }

    $identifier = trim($_POST['email'] ?? '');
    $password   = $_POST['password'] ?? '';
    $ip         = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    // Rate limit failed logins only when Redis is available
    if (function_exists('rate_limit') && function_exists('redis') && ($redis = @redis())) {
        $limitKey = 'login:' . md5($identifier . '|' . $ip);
        $rateOk = rate_limit($limitKey, 5, 300);
        if ($rateOk === false) {
            $errors[] = 'Too many attempts. Please wait a moment and try again.';
        }
    }

    if (empty($errors)) {
        $user = $db->fetchOne(
            "SELECT * FROM users WHERE username = :ident1 OR email = :ident2 LIMIT 1",
            ['ident1' => $identifier, 'ident2' => $identifier]
        );

        if (!$user) {
            tc_log("[AUTH] Failed login (unknown user) from {$ip}", 'warn');
            $errors[] = 'Invalid credentials.';
        } elseif ($user['status'] !== 'active') {
            $errors[] = 'Account is not active.';
        } elseif (!password_verify($password, $user['password_hash'])) {
            tc_log("[AUTH] Failed login (bad password) user_id={$user['id']} ip={$ip}", 'warn');
            $errors[] = 'Invalid credentials.';
        } else {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int)$user['id'];

            $db->execute(
                "UPDATE users SET last_login_at = NOW(), last_ip = :ip WHERE id = :id",
                ['ip' => $ip, 'id' => $user['id']]
            );

            $requiresVerification = tc_email_verification_required();
            $emailVerified = (int)($user['email_verified'] ?? 0) === 1;

            if ($requiresVerification && !$emailVerified) {
                $_SESSION['email_verified'] = 0;
                tc_log("[AUTH] Login pending verification user_id={$user['id']} ip={$ip}", 'info');
                header('Location: /verify-email.php');
                exit;
            }

            tc_log("[AUTH] Login success user_id={$user['id']} ip={$ip}", 'info');
            header('Location: /dashboard.php');
            exit;
        }
    }
}

$tc_page_title = 'Sign in | Trench City';
require_once '/var/www/trench_city/includes/prelogin-header.php';
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
                <a class="tc-btn tc-btn-primary" href="/register.php">Create account</a>
            </div>
        </nav>

        <main class="tc-prelogin-main">
            <div class="tc-prelogin-grid tc-prelogin-grid--auth">
                <section class="tc-card hero">
                    <span class="eyebrow">Access your workspace</span>
                    <h1>Welcome back</h1>
                    <p>Sign in to manage your SFT Official data. This page sits in the public root and keeps everything else out of reach.</p>
                    <div class="pill-list">
                        <span class="pill">Email + password</span>
                        <span class="pill">Session ready</span>
                        <span class="pill">PHP-FPM friendly</span>
                    </div>
                </section>

                <section class="tc-card auth-card">
                    <h2>Sign in</h2>
                    <p>Use your credentials to continue.</p>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <div class="alert-content">
                                <div class="alert-title">Heads up</div>
                                <div class="alert-message"><?php echo htmlspecialchars(implode(' ', $errors), ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="/login.php" autocomplete="on">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <div class="form-group">
                            <label class="form-label" for="email">Email or Username</label>
                            <input class="form-control" type="text" id="email" name="email" required placeholder="you@example.com or trench_player" autocomplete="username" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" type="password" id="password" name="password" required placeholder="Your password" autocomplete="current-password" />
                        </div>
                        <div class="supporting">
                            <span>Need an account? <a href="/register.php">Register</a></span>
                            <a href="/">Back home</a>
                        </div>
                        <button class="tc-btn tc-btn-primary tc-btn-block" type="submit">Continue</button>
                    </form>
                </section>
            </div>
        </main>

        <footer>
            Trench City - secure entry point for SFT Official.
        </footer>
<?php require_once '/var/www/trench_city/includes/prelogin-footer.php'; ?>

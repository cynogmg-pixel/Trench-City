<?php
declare(strict_types=1);
require_once '/var/www/trench_city/core/bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();
global $db;

$errors = [];
$success = '';
$submitted = ($_SERVER['REQUEST_METHOD'] === 'POST');
$verificationRequired = tc_email_verification_required();

if (!$db instanceof TCDB) {
    $errors[] = 'Service unavailable. Please try again shortly.';
}

if ($submitted) {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errors[] = 'Invalid session. Please refresh and try again.';
    }

    $username = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';
    $ip       = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    if ($username === '' || strlen($username) < 3 || strlen($username) > 32 || !preg_match('/^[A-Za-z0-9_]+$/', $username)) {
        $errors[] = 'Username must be 3-32 chars, alphanumeric/underscore only.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $existing = $db->fetchOne(
            "SELECT id FROM users WHERE username = :u OR email = :e LIMIT 1",
            ['u' => $username, 'e' => $email]
        );
        if ($existing) {
            $errors[] = 'Username or email already in use.';
        }
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $emailVerified = $verificationRequired ? 0 : 1;
        $verifiedAt = $verificationRequired ? null : date('Y-m-d H:i:s');

        try {
            $db->beginTransaction();

            $db->execute(
                "INSERT INTO users (username, email, password_hash, email_verified, email_verification_token,
                                    email_verification_sent_at, email_verified_at, xp, level, cash, bank_balance, status, created_at, last_ip)
                 VALUES (:u, :e, :p, :verified, NULL, NULL, :verified_at, 0, 1, 5000.00, 0.00, 'active', NOW(), :ip)",
                [
                    'u' => $username,
                    'e' => $email,
                    'p' => $hash,
                    'verified' => $emailVerified,
                    'verified_at' => $verifiedAt,
                    'ip' => $ip
                ]
            );
            $userId = (int)$db->lastInsertId();

            $db->execute(
                "INSERT INTO player_stats (user_id, strength, speed, defense, dexterity, created_at)
                 VALUES (:id, 10, 10, 10, 10, NOW())",
                ['id' => $userId]
            );

            $db->execute(
                "INSERT INTO player_bars (user_id, energy_current, energy_max, nerve_current, nerve_max,
                          happy_current, happy_max, life_current, life_max, last_regen_at, created_at)
                 VALUES (:id, 100, 100, 15, 15, 100, 100, 100, 100, NOW(), NOW())",
                ['id' => $userId]
            );

            $db->execute(
                "INSERT INTO player_settings (user_id, show_online_status, dark_mode, created_at)
                 VALUES (:id, 1, 1, NOW())",
                ['id' => $userId]
            );

            $db->commit();

            tc_log("[AUTH] Registration success user_id={$userId} ip={$ip}", 'info');

            if ($verificationRequired) {
                $token = tc_issue_email_verification_token($userId, $email);
                if ($token) {
                    $sent = tc_send_email_verification_token($userId, $email, $token);
                    if ($sent) {
                        $success = "Account created! Please verify {$email} before playing.";
                    } else {
                        $success = "Account created! Verification email could not be delivered, but a developer token has been logged.";
                    }
                } else {
                    $errors[] = 'Unable to generate verification token. Please contact support.';
                    tc_log("[AUTH] Verification token generation failed user_id={$userId}", 'error');
                }
            } else {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $userId;
                header('Location: /dashboard.php');
                exit;
            }
        } catch (Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            $errors[] = 'Registration failed. Please try again.';
            tc_log("[AUTH] Registration exception ip={$ip} reason=" . $e->getMessage(), 'error');
        }
    } else {
        tc_log("[AUTH] Registration failed ip={$ip} reason=" . implode('; ', $errors), 'warn');
    }
}

$tc_page_title = 'Create account | Trench City';
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
                <a class="tc-btn tc-btn-primary" href="/login.php">Sign in</a>
            </div>
        </nav>

        <main class="tc-prelogin-main">
            <div class="tc-prelogin-grid tc-prelogin-grid--auth">
                <section class="tc-card hero">
                    <span class="eyebrow">Join the Underground</span>
                    <h1>Create your account</h1>
                    <p>Enter the dark luxury world of Trench City. Build your empire, train your stats, and dominate the criminal underworld of London.</p>
                    <div class="pill-list">
                        <span class="pill">Start with GBP 5,000</span>
                        <span class="pill">Free to play</span>
                        <span class="pill">London MMO</span>
                        <?php if ($verificationRequired): ?>
                        <span class="pill">Email verification required</span>
                        <?php endif; ?>
                    </div>
                </section>

                <section class="tc-card auth-card">
                    <h2>Register</h2>
                    <p>Fill in your details to request access.</p>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <div class="alert-content">
                                <div class="alert-title">We need a fix</div>
                                <div class="alert-message"><?php echo htmlspecialchars(implode(' ', $errors), ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <div class="alert-content">
                                <div class="alert-title">Success</div>
                                <div class="alert-message"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="/register.php" autocomplete="on">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <div class="form-group">
                            <label class="form-label" for="name">Username</label>
                            <input
                                class="form-control"
                                type="text"
                                id="name"
                                name="name"
                                required
                                placeholder="trench_player"
                                minlength="3"
                                maxlength="32"
                                pattern="[A-Za-z0-9_]+"
                                title="Alphanumeric and underscore only"
                                value="<?php echo htmlspecialchars($username ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                            />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input
                                class="form-control"
                                type="email"
                                id="email"
                                name="email"
                                required
                                placeholder="you@example.com"
                                value="<?php echo htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                            />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <input
                                class="form-control"
                                type="password"
                                id="password"
                                name="password"
                                required
                                placeholder="At least 8 characters"
                                minlength="8"
                            />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="confirm">Confirm password</label>
                            <input
                                class="form-control"
                                type="password"
                                id="confirm"
                                name="confirm"
                                required
                                placeholder="Repeat password"
                                minlength="8"
                            />
                        </div>
                        <div class="supporting">
                            <span>Already registered? <a href="/login.php">Sign in</a></span>
                            <a href="/">Back home</a>
                        </div>
                        <button class="tc-btn tc-btn-primary tc-btn-block" type="submit">Create account</button>
                    </form>
                </section>
            </div>
        </main>

        <footer>
            Trench City - Enter the underground empire.
        </footer>
<?php require_once '/var/www/trench_city/includes/prelogin-footer.php'; ?>

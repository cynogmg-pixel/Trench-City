<?php
declare(strict_types=1);
require_once __DIR__ . '/../core/bootstrap.php';
require_once __DIR__ . '/../core/Email.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect logged-in users waiting for verification to verify-email.php
if (!empty($_SESSION['user_id'])) {
    $userId = (int)$_SESSION['user_id'];
    $db = getDB();
    $user = $db->fetchOne("SELECT email_verified FROM users WHERE id = :id LIMIT 1", ['id' => $userId]);
    if ($user && (int)($user['email_verified'] ?? 0) !== 1) {
        header('Location: /verify-email.php');
        exit;
    }
    // If already verified, redirect to dashboard
    header('Location: /dashboard.php');
    exit;
}

if (function_exists('tc_is_ops_flag_enabled') && tc_is_ops_flag_enabled('lock_registrations')) {
    if (function_exists('tc_render_prelogin_notice')) {
        tc_render_prelogin_notice('Registrations Locked', 'New registrations are temporarily disabled. Please check back soon.', '/');
    }
}

$errors = [];
$success = '';
$submitted = ($_SERVER['REQUEST_METHOD'] === 'POST');

$db = getDB();

// Get email and reCAPTCHA configuration
$emailConfig = [];
$configRows = $db->fetchAll("
    SELECT config_key, config_value
    FROM email_config
    WHERE config_key IN ('verification_required', 'recaptcha_enabled', 'recaptcha_site_key', 'recaptcha_secret_key')
");
foreach ($configRows as $row) {
    $emailConfig[$row['config_key']] = $row['config_value'];
}

$verificationRequired = tc_email_verification_required();
$recaptchaEnabled = ($emailConfig['recaptcha_enabled'] ?? 'false') === 'true';
$recaptchaSiteKey = $emailConfig['recaptcha_site_key'] ?? '';
$recaptchaSecretKey = $emailConfig['recaptcha_secret_key'] ?? '';

if ($submitted) {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errors[] = 'Invalid session. Please refresh and try again.';
    }

    // Validate reCAPTCHA if enabled
    if ($recaptchaEnabled && !empty($recaptchaSecretKey)) {
        $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

        if (empty($recaptchaResponse)) {
            $errors[] = 'Please complete the reCAPTCHA verification.';
        } else {
            // Verify with Google
            $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';
            $response = file_get_contents($verifyURL . '?' . http_build_query([
                'secret' => $recaptchaSecretKey,
                'response' => $recaptchaResponse,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
            ]));

            $responseData = json_decode($response, true);

            if (!$responseData['success']) {
                $errors[] = 'reCAPTCHA verification failed. Please try again.';
            }
        }
    }

    $username = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';
    $ip       = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    // Validation
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

    // Check if user exists
    if (empty($errors)) {
        $existing = $db->fetchOne(
            "SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1",
            ['username' => $username, 'email' => $email]
        );

        if ($existing) {
            $errors[] = 'Username or email already in use.';
        }
    }

    // Create account
    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $emailVerified = $verificationRequired ? 0 : 1;
        $verifiedAt = $verificationRequired ? null : date('Y-m-d H:i:s');

        try {
            $db->beginTransaction();

            $db->execute(
                "INSERT INTO users (username, email, password_hash, email_verified, email_verification_token,
                                    email_verification_sent_at, email_verified_at, xp, level, cash, bank_balance, status, created_at, last_ip)
                 VALUES (:username, :email, :password_hash, :verified, NULL, NULL, :verified_at, 0, 1, 5000.00, 0.00, 'active', NOW(), :ip)",
                [
                    'username' => $username,
                    'email' => $email,
                    'password_hash' => $hash,
                    'verified' => $emailVerified,
                    'verified_at' => $verifiedAt,
                    'ip' => $ip
                ]
            );

            $userId = (int)$db->lastInsertId();

            $db->execute(
                "INSERT IGNORE INTO player_stats (user_id, strength, speed, defense, dexterity, created_at)
                 VALUES (:id, 10, 10, 10, 10, NOW())",
                ['id' => $userId]
            );

            $db->execute(
                "INSERT IGNORE INTO player_bars (user_id, energy_current, energy_max, nerve_current, nerve_max,
                                          happy_current, happy_max, life_current, life_max, last_regen_at, created_at)
                 VALUES (:id, 100, 100, 15, 15, 100, 100, 100, 100, NOW(), NOW())",
                ['id' => $userId]
            );

            $db->execute(
                "INSERT IGNORE INTO player_settings (user_id, show_online_status, dark_mode, created_at)
                 VALUES (:id, 1, 1, NOW())",
                ['id' => $userId]
            );

            $db->commit();

            tc_log("[AUTH] Registration success user_id={$userId} ip={$ip} verification_required=" . ($verificationRequired ? 'yes' : 'no'), 'info');

            if ($verificationRequired) {
                $token = tc_issue_email_verification_token($userId, $email);
                if ($token) {
                    $sent = tc_send_email_verification_token($userId, $email, $token);
                    if ($sent) {
                        // Redirect to verification page
                        header('Location: http://217.160.147.25/verify-email.php');
                        exit;
                    } else {
                        $success = "Account created, but we could not deliver the verification email. Please check your spam folder or request a new verification email.";
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
            if (defined('DEBUG') && DEBUG) {
                $errors[] = 'Debug: ' . $e->getMessage();
            }
            tc_log("[AUTH] Registration failed: " . $e->getMessage(), 'error');
            if (function_exists('tc_log_safe_write') && defined('LOG_ERROR_FILE')) {
                tc_log_safe_write(LOG_ERROR_FILE, "[AUTH][REGISTER_NEW] {$e->getMessage()}\n{$e->getTraceAsString()}\n");
            }
        }
    }

    if (!empty($errors)) {
        tc_log("[AUTH] Registration failed ip={$ip} reason=" . implode('; ', $errors), 'warn');
    }
}

$tc_page_title = 'Create account | Trench City';
require_once __DIR__ . '/../includes/tc_header.php';
tcRenderPageStart(['mode' => 'prelogin']);
?>

<?php if ($recaptchaEnabled && !empty($recaptchaSiteKey)): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>

<?php
tcRenderHeader([
    'mode' => 'prelogin',
    'actions' => [
        ['label' => 'Home', 'href' => '/', 'class' => 'tc-btn tc-btn-secondary'],
        ['label' => 'Sign in', 'href' => '/login.php', 'class' => 'tc-btn tc-btn-primary'],
    ],
]);
?>


<main class="tc-prelogin-main">
    <div class="tc-prelogin-grid tc-prelogin-grid--auth">
        <section class="tc-card hero" style="grid-column: 1 / -1; padding: 18px 26px; text-align: center !important;">
            <h3 style="color: #D4AF37; margin: 0 0 0.65rem 0; font-size: 0.95rem; text-align: center;">Starting Package:</h3>
            <div class="pill-list" style="margin-bottom: 0.65rem; justify-content: center;">
                <span class="pill">&pound;5,000 to get you moving from day one</span>
                <span class="pill">Free to play &mdash; you can compete without spending</span>
                <span class="pill">London MMO world &mdash; built around progression, strategy, and long-term domination</span>
                <?php if ($verificationRequired): ?>
                <span class="pill">Email verification required &mdash; keeps your account secure, stops fake sign-ups, and protects the city economy</span>
                <?php endif; ?>
            </div>

            <p style="margin: 0; font-size: 0.9rem; line-height: 1.5; text-align: center; width: 100%; display: block; text-align: center !important;">
                If you're ready to step in, lock it in and create your account.
            </p>
            <strong style="color: #D4AF37; display: block; text-align: center; margin-top: 0.35rem;">
                Trench City's waiting &mdash; and it won't wait forever.
            </strong>
        </section>
        <section class="tc-card hero">
            <span class="eyebrow">Join the Underground</span>
            <h1>Create your account</h1>

            <p style="font-size: 1.1rem; line-height: 1.7; margin-bottom: 1.5rem;">
                Welcome to Trench City &mdash; a dark luxury London MMO where the streets shine gold at night and bite back in the morning.
                This is a city of big talk and bigger consequences. Everyone wants to rise, but only the smart ones last.
            </p>

            <p style="font-size: 1.05rem; line-height: 1.7; margin-bottom: 1.5rem;">
                You're starting at the bottom, same as everyone. What happens next is on you.
            </p>

            <h3 style="color: #D4AF37; margin-top: 1.5rem; margin-bottom: 0.75rem; font-size: 1.1rem;">Build your character from scratch:</h3>
            <ul style="line-height: 1.8; margin-bottom: 1.5rem; padding-left: 1.25rem;">
                <li>Stack your cash and learn how money moves in the city</li>
                <li>Train your stats and turn yourself from fresh into serious</li>
                <li>Pick your lanes &mdash; grind steady, take risks, or play both sides</li>
                <li>Make a name through consistency, reputation, and timing</li>
                <li>Grow your empire step by step until you're not just surviving London&hellip; you're running it</li>
            </ul>

            <p style="line-height: 1.7; margin-bottom: 0;">
                Trench City isn't about "one big win." It's about pressure, patience, and knowing when to move quiet and when to move loud.
                One good decision builds momentum. One bad decision can set you back.
            </p>
        </section>

        <section class="tc-card auth-card">
            <h2>Register</h2>
            <p>Fill in your details to <?php echo $verificationRequired ? 'request access' : 'create your account'; ?>.</p>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <div class="alert-content">
                        <div class="alert-title">Success</div>
                        <div class="alert-message"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <div class="alert-content">
                        <div class="alert-title">We need a fix</div>
                        <div class="alert-message"><?php echo htmlspecialchars(implode(' ', $errors), ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (empty($success)): ?>
            <form method="post" action="/register_new.php" autocomplete="on">
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
                        value="<?php echo htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                    />
                    <small>3-32 characters, letters, numbers, and underscore only</small>
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
                        value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                    />
                    <?php if ($verificationRequired): ?>
                    <small class="text-gold">You will need to verify this email before you can play.</small>
                    <?php endif; ?>
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
                    <small>Minimum 8 characters</small>
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

                <?php if ($recaptchaEnabled && !empty($recaptchaSiteKey)): ?>
                <div style="margin: 20px 0;">
                    <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($recaptchaSiteKey, ENT_QUOTES, 'UTF-8'); ?>"></div>
                </div>
                <?php endif; ?>

                <div class="supporting">
                    <span>Already registered? <a href="/login.php">Sign in</a></span>
                    <a href="/">Back home</a>
                </div>

                <button class="tc-btn tc-btn-primary tc-btn-block" type="submit">
                    <?php echo $verificationRequired ? 'Create account & send verification' : 'Create account'; ?>
                </button>
            </form>
            <?php else: ?>
                <div style="text-align: center; margin-top: 30px;">
                    <a href="/login.php" class="tc-btn tc-btn-primary">Go to Login</a>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>


<?php require_once __DIR__ . '/../includes/prelogin-footer.php'; ?>

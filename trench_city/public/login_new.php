<?php
declare(strict_types=1);
require_once __DIR__ . '/../core/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$db = getDB();
$errors = [];
$submitted = ($_SERVER['REQUEST_METHOD'] === 'POST');

// Check if email verification is required
$configRow = $db->fetchOne("SELECT config_value FROM email_config WHERE config_key = :key", [
    'key' => 'verification_required'
]);
$verificationRequired = ($configRow['config_value'] ?? 'false') === 'true';

if ($submitted) {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errors[] = 'Invalid session. Please refresh and try again.';
    }

    $identifier = trim($_POST['email'] ?? '');
    $password   = $_POST['password'] ?? '';
    $ip         = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    // Rate limit failed logins
    if (function_exists('rate_limit') && function_exists('redis') && ($redis = @redis())) {
        $limitKey = 'login:' . md5($identifier . '|' . $ip);
        $rateOk = rate_limit($limitKey, 5, 300);
        if ($rateOk === false) {
            $errors[] = 'Too many attempts. Please wait 5 minutes and try again.';
        }
    }

    if (empty($errors)) {
        $user = $db->fetchOne("
            SELECT id, username, email, password_hash, status, email_verified
            FROM users
            WHERE username = :ident1 OR email = :ident2
            LIMIT 1
        ", ['ident1' => $identifier, 'ident2' => $identifier]);

        if (!$user) {
            tc_log("[AUTH] Failed login (unknown user) from {$ip}", 'warn');
            $errors[] = 'Invalid credentials.';
        } elseif ($user['status'] !== 'active') {
            $errors[] = 'Account is not active.';
        } elseif (!password_verify($password, $user['password_hash'])) {
            tc_log("[AUTH] Failed login (bad password) user_id={$user['id']} ip={$ip}", 'warn');
            $errors[] = 'Invalid credentials.';
        } elseif ($verificationRequired && !$user['email_verified']) {
            $errors[] = 'Please verify your email address before logging in. Check your inbox for the verification link.';
            tc_log("[AUTH] Login blocked (unverified email) user_id={$user['id']} ip={$ip}", 'warn');
        } else {
            // Login successful
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int)$user['id'];

            $db->execute("UPDATE users SET last_login_at = NOW(), last_ip = :ip WHERE id = :id", [
                'ip' => $ip,
                'id' => $user['id']
            ]);

            tc_log("[AUTH] Login success user_id={$user['id']} ip={$ip}", 'info');
            header('Location: /dashboard.php');
            exit;
        }
    }
}

$tc_page_title = 'Sign in | Trench City';
require_once __DIR__ . '/../includes/tc_header.php';
tcRenderPageStart(['mode' => 'prelogin']);
?>

        <?php
        tcRenderHeader([
            'mode' => 'prelogin',
            'actions' => [
                ['label' => 'Home', 'href' => '/', 'class' => 'tc-btn tc-btn-secondary'],
                ['label' => 'Create account', 'href' => '/register_new.php', 'class' => 'tc-btn tc-btn-primary'],
            ],
        ]);
        ?>


<main class="tc-prelogin-main">
    <div class="tc-prelogin-grid tc-prelogin-grid--auth">
        <section class="tc-card hero">
            <span class="eyebrow">Access your empire</span>
            <h1>Welcome back</h1>
            <p>Sign in to manage your criminal empire in the dark streets of London.</p>
            <div class="pill-list">
                <span class="pill">Secure login</span>
                <span class="pill">Session protected</span>
                <?php if ($verificationRequired): ?>
                <span class="pill">Email verified accounts</span>
                <?php endif; ?>
            </div>
        </section>

        <section class="tc-card auth-card">
            <h2>Sign in</h2>
            <p>Use your credentials to continue.</p>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <div class="alert-content">
                        <div class="alert-title">Heads up</div>
                        <div class="alert-message"><?= htmlspecialchars(implode(' ', $errors), ENT_QUOTES, 'UTF-8') ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <form method="post" action="/login_new.php" autocomplete="on">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>" />

                <div class="form-group">
                    <label class="form-label" for="email">Email or Username</label>
                    <input
                        class="form-control"
                        type="text"
                        id="email"
                        name="email"
                        required
                        placeholder="your@email.com or username"
                        autocomplete="username"
                        value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
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
                        placeholder="Your password"
                        autocomplete="current-password"
                    />
                </div>

                <div class="supporting">
                    <span>New to Trench City? <a href="/register_new.php">Create account</a></span>
                    <a href="/">Back home</a>
                </div>

                <button class="tc-btn tc-btn-primary tc-btn-block" type="submit">Sign in</button>
            </form>
        </section>
    </div>
</main>


<?php require_once __DIR__ . '/../includes/prelogin-footer.php'; ?>

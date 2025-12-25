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
require_once '/var/www/trench_city/includes/tc_header.php';
tcRenderPageStart(['mode' => 'prelogin']);
?>
        <?php
        tcRenderHeader([
            'mode' => 'prelogin',
            'brand_group' => true,
            'actions' => [
                ['label' => 'Home', 'href' => '/', 'class' => 'tc-btn tc-btn-secondary'],
                ['label' => 'Create account', 'href' => '/register.php', 'class' => 'tc-btn tc-btn-primary'],
            ],
        ]);
        ?>


        <main class="tc-prelogin-main">
            <div class="tc-prelogin-grid tc-prelogin-grid--auth">
                <section class="tc-card hero">
                    <span class="eyebrow">Welcome to Trench City</span>
                    <h1>London&rsquo;s darkest playground &mdash; where legends get made.</h1>
                    <p>
                        The city never sleeps. Every move matters: train your stats, build your rep, stack your empire, and take territory block by block. One good decision can change everything. One mistake can cost you everything.
                    </p>
                    <p>
                        Sign in to return to your life in the trenches &mdash; your progress, your crew, your hustle, and the streets you&rsquo;ve carved your name into. This is the gate to the underworld&hellip; and it only opens for the real ones.
                    </p>
                    <div class="pill-list">
                        <span class="pill">Train your stats</span>
                        <span class="pill">Build your rep</span>
                        <span class="pill">Claim territory</span>
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

<?php require_once '/var/www/trench_city/includes/prelogin-footer.php'; ?>

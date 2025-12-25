<?php
declare(strict_types=1);
require_once '/var/www/trench_city/core/bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$token = $_POST['csrf_token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($token)) {
        tc_log("[AUTH] Logout CSRF failed ip={$ip}", 'warn');
        header('Location: /login.php');
        exit;
    }

    $userId = $_SESSION['user_id'] ?? null;

    // Destroy session
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();

    if ($userId) {
        tc_log("[AUTH] Logout user_id={$userId} ip={$ip}", 'info');
    }

    header('Location: /login.php');
    exit;
}

// Fallback GET: render confirmation using the prelogin shell (no sidebar)
$tc_page_title = 'Logout - Trench City';
require_once __DIR__ . '/../includes/tc_header.php';

$logoutHead = <<<'HTML'
<style>
        .tc-prelogin nav.tc-prelogin-header {
            padding: 12px clamp(16px, 2vw, 28px);
            min-height: 64px;
        }

        .tc-prelogin .tc-prelogin-header .tc-brand-logo {
            width: 160px;
            max-height: 60px;
        }

        .tc-prelogin .tc-prelogin-header .tc-header-actions {
            gap: 0.5rem;
        }

        .tc-logout {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1.25rem 2.5rem;
        }

        .tc-logout-inner {
            text-align: center;
            max-width: 920px;
        }

        .tc-logout-title {
            color: var(--tc-text-primary);
            font-size: clamp(2rem, 4vw, 3rem);
            margin: 0.75rem 0 0.5rem;
            letter-spacing: var(--tc-tracking-tight);
        }

        .tc-logout-subtitle {
            color: var(--tc-text-secondary);
            font-size: 1.05rem;
            margin: 0 auto 1.25rem;
            max-width: 620px;
        }

        .tc-logout-actions {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }
    </style>
HTML;

tcRenderPageStart([
    'mode' => 'prelogin',
    'head_html' => $logoutHead,
    'header' => [
        'mode' => 'prelogin',
        'actions' => [
            ['label' => 'Back', 'href' => '/dashboard.php', 'class' => 'tc-btn tc-btn-secondary'],
            ['label' => 'Contact us', 'href' => 'mailto:admin@trenchmade.co.uk', 'class' => 'tc-btn tc-btn-primary'],
        ],
    ],
]);
?>
<main class="tc-logout">
            <div class="tc-logout-inner">
                <h1 class="tc-logout-title">Sign out</h1>
                <p class="tc-logout-subtitle">
                    Confirm to end your session and return to the login screen.
                </p>

                <form method="post" action="/logout.php" class="tc-logout-actions">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                    <button class="tc-btn tc-btn-primary" type="submit">Logout</button>
                    <a class="tc-btn tc-btn-secondary" href="/dashboard.php">Cancel</a>
                </form>

            </div>
        </main>
    <?php tcRenderPageEnd(['mode' => 'prelogin']); ?>

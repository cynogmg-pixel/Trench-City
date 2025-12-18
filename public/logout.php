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

// Fallback GET: render a small confirmation form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Logout | Trench City</title>
    <link rel="stylesheet" href="/assets/css/prelogin-header.css" />
</head>
<body>
    <div class="page" style="padding:40px; max-width:560px; margin:0 auto;">
        <section class="card auth-card">
            <h2>Sign out</h2>
            <p>Confirm to end your session.</p>
            <form method="post" action="/logout.php">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                <button class="btn btn-primary" type="submit">Logout</button>
                <a class="btn" href="/">Cancel</a>
            </form>
        </section>
    </div>
</body>
</html>

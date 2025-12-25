<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);

$dbStatus = 'Unavailable';
if (function_exists('tc_db_check')) {
    $dbStatus = tc_db_check() ? 'OK' : 'Unavailable';
} elseif ($db) {
    try {
        $row = $db->fetchOne('SELECT 1 AS ok');
        $dbStatus = ((int)($row['ok'] ?? 0) === 1) ? 'OK' : 'Unavailable';
    } catch (Throwable $e) {
        $dbStatus = 'Unavailable';
    }
}

$redisStatus = 'Not configured';
if (function_exists('tc_redis_check')) {
    $redisStatus = tc_redis_check() ? 'OK' : 'Unavailable';
}

$tc_page_title = 'Owner Panel - System';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">System Status</h1>
            <p class="content-description">Runtime health and service checks.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>

        <div class="grid grid-2">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Environment</h2>
                </div>
                <div class="card-body">
                    <div style="display: grid; gap: 0.75rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #9CA3AF;">PHP Version</span>
                            <span style="color: #F9FAFB; font-weight: 600;"><?php echo htmlspecialchars(phpversion(), ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #9CA3AF;">Server Time</span>
                            <span style="color: #F9FAFB; font-weight: 600;"><?php echo date('Y-m-d H:i:s'); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #9CA3AF;">App Env</span>
                            <span style="color: #F9FAFB; font-weight: 600;"><?php echo htmlspecialchars(defined('APP_ENV') ? APP_ENV : 'unknown', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Services</h2>
                </div>
                <div class="card-body">
                    <div style="display: grid; gap: 0.75rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #9CA3AF;">Database</span>
                            <span style="color: #F9FAFB; font-weight: 600;"><?php echo htmlspecialchars($dbStatus, ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #9CA3AF;">Redis</span>
                            <span style="color: #F9FAFB; font-weight: 600;"><?php echo htmlspecialchars($redisStatus, ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #9CA3AF;">Log Path</span>
                            <span style="color: #F9FAFB; font-weight: 600;"><?php echo htmlspecialchars(defined('LOG_PATH') ? LOG_PATH : 'unknown', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

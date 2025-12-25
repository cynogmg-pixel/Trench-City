<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

if (!function_exists('tc_admin_tail_file')) {
    function tc_admin_tail_file(string $path, int $lines = 200): array
    {
        if (!is_readable($path)) {
            return [];
        }

        $handle = fopen($path, 'rb');
        if (!$handle) {
            return [];
        }

        $buffer = '';
        $chunkSize = 4096;
        fseek($handle, 0, SEEK_END);
        $position = ftell($handle);

        while ($position > 0 && substr_count($buffer, "\n") <= $lines) {
            $readSize = ($position - $chunkSize) >= 0 ? $chunkSize : $position;
            $position -= $readSize;
            fseek($handle, $position);
            $buffer = fread($handle, $readSize) . $buffer;
        }

        fclose($handle);

        $buffer = trim($buffer);
        if ($buffer === '') {
            return [];
        }

        $allLines = explode("\n", $buffer);
        return array_slice($allLines, -$lines);
    }
}

if (!function_exists('tc_admin_pick_log_file')) {
    function tc_admin_pick_log_file(string $dir, array $patterns): string
    {
        $files = [];
        foreach ($patterns as $pattern) {
            $files = array_merge($files, glob(rtrim($dir, '/') . '/' . $pattern) ?: []);
        }
        if (!$files) {
            return '';
        }
        usort($files, function ($a, $b) {
            return filemtime($b) <=> filemtime($a);
        });
        return $files[0] ?? '';
    }
}

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);

$health = [
    'db' => null,
    'redis' => null,
    'maintenance' => null,
    'cache_dir' => null,
    'error_lines' => null,
];

if ($db) {
    try {
        $db->fetchOne('SELECT 1 AS ok');
        $health['db'] = true;
    } catch (Throwable $e) {
        $health['db'] = false;
    }
}

if (function_exists('tc_redis_check')) {
    $health['redis'] = tc_redis_check();
}

$health['maintenance'] = function_exists('tc_is_maintenance_enabled') ? tc_is_maintenance_enabled() : null;

$cacheDir = defined('STORAGE_PATH') ? STORAGE_PATH . '/cache' : __DIR__ . '/../../storage/cache';
if (is_dir($cacheDir)) {
    $health['cache_dir'] = count(glob($cacheDir . '/*'));
}

$logBase = defined('LOG_PATH') ? LOG_PATH : __DIR__ . '/../../storage/logs';
if (is_dir($logBase)) {
    $errorLogFile = tc_admin_pick_log_file($logBase, ['error-*.log', 'error.log', 'fatal-*.log']);
    if ($errorLogFile) {
        $health['error_lines'] = count(tc_admin_tail_file($errorLogFile, 200));
    }
}

$section_title = 'Live Ops Tools';
$section_description = 'Monitor live system health, errors, and maintenance states.';
$section_features = [
    'Maintenance mode scheduling and global status.',
    'Module health: DB, Redis, email, queues.',
    'Error viewer and slow query monitoring.',
];
$section_notes = [
    'Email and queue health require service-specific telemetry.',
];

$tc_page_title = 'Owner Panel - Live Ops';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Live Ops Tools</h1>
            <p class="content-description">Monitor system health and operational status.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>
        <?php include __DIR__ . '/../../includes/admin_section.php'; ?>

        <div class="grid grid-3" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">DB Status</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $health['db'] === null ? 'N/A' : ($health['db'] ? 'OK' : 'Down'); ?>
                    </div>
                    <div style="color: #9CA3AF;">Database connectivity</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Redis Status</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $health['redis'] === null ? 'N/A' : ($health['redis'] ? 'OK' : 'Down'); ?>
                    </div>
                    <div style="color: #9CA3AF;">Cache and rate limits</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Maintenance</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $health['maintenance'] === null ? 'N/A' : ($health['maintenance'] ? 'Enabled' : 'Disabled'); ?>
                    </div>
                    <div style="color: #9CA3AF;">Live site status</div>
                </div>
            </div>
        </div>

        <div class="grid grid-2" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Cache Entries</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $health['cache_dir'] !== null ? number_format($health['cache_dir']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Storage cache directory</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Error Lines (200)</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $health['error_lines'] !== null ? number_format($health['error_lines']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Latest error log sample</div>
                </div>
            </div>
        </div>

        <div class="tc-card" style="margin-top: 1.5rem;">
            <div style="padding: 1.5rem;">
                <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Live Ops Actions</h2>
                <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                    <a class="btn btn-primary" href="/admin/maintenance.php">Maintenance Controls</a>
                    <button class="btn btn-ghost" type="button" disabled>Schedule maintenance</button>
                    <button class="btn btn-ghost" type="button" disabled>Broadcast incident</button>
                </div>
                <div style="color: #9CA3AF; margin-top: 1rem;">Scheduling and broadcast hooks can be added to config tables.</div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

#!/usr/bin/php
<?php
/**
 * ======================================================
 *  TRENCH CITY MAINTENANCE SCRIPT (v1.0)
 *  Automated daily housekeeping & health telemetry
 *  Runs via cron: /etc/cron.daily/trenchcity-maintain
 * ======================================================
 */

require_once __DIR__ . '/bootstrap.php';

if (php_sapi_name() !== 'cli') {
    die("This script can only be executed via CLI.\n");
}

echo "==============================================\n";
echo "🧹  TRENCH CITY DAILY MAINTENANCE\n";
echo "==============================================\n\n";

// ------------------------------------------------------
// 1️⃣ Run Health Self-Test
// ------------------------------------------------------
$healthOutput = [];
$exitCode = 0;
exec('php ' . escapeshellarg(__DIR__ . '/selftest.php'), $healthOutput, $exitCode);

echo implode("\n", $healthOutput) . "\n\n";
tc_log('[MAINT] Selftest completed with exit code ' . $exitCode, 'info');

// ------------------------------------------------------
// 2️⃣ Cleanup Old Logs (default: 30 days retention)
// ------------------------------------------------------
$logDir = '/var/www/trench_city/storage/logs';
$daysToKeep = 30;
$deleted = 0;

if (is_dir($logDir)) {
    $files = glob("$logDir/*.log");
    foreach ($files as $file) {
        if (filemtime($file) < time() - ($daysToKeep * 86400)) {
            unlink($file);
            $deleted++;
        }
    }
}
tc_log("[MAINT] Log cleanup done, deleted {$deleted} old log(s)", 'info');
echo "🧾 Log cleanup: deleted {$deleted} old log(s)\n";

// ------------------------------------------------------
// 3️⃣ Fix Permissions
// ------------------------------------------------------
exec('chown -R www-data:www-data ' . escapeshellarg($logDir));
exec('chmod -R 750 ' . escapeshellarg($logDir));
echo "🔒 Permissions fixed for log directory\n";
tc_log('[MAINT] Permissions fixed for log directory', 'info');

// ------------------------------------------------------
// 4️⃣ Telemetry Heartbeat
// ------------------------------------------------------
if (function_exists('redis') && ($r = redis())) {
    try {
        $r->xAdd('tc:maintenance', '*', [
            'timestamp' => date('Y-m-d H:i:s'),
            'env' => APP_ENV,
            'deleted_logs' => $deleted,
            'selftest_exit' => $exitCode,
        ]);
        echo "📡 Telemetry heartbeat sent to Redis (tc:maintenance)\n";
        tc_log('[MAINT] Telemetry heartbeat sent to Redis', 'info');
    } catch (Throwable $e) {
        tc_log('[MAINT] Telemetry send failed: ' . $e->getMessage(), 'error');
    }
} else {
    echo "📡 Telemetry: skipped (Redis unavailable)\n";
    tc_log('[MAINT] Telemetry skipped — Redis unavailable', 'warn');
}

// ------------------------------------------------------
// 5️⃣ Completion Summary
// ------------------------------------------------------
echo "\n==============================================\n";
echo "✅ Maintenance Complete (" . date('Y-m-d H:i:s') . ")\n";
echo "==============================================\n";
tc_log('[MAINT] Daily maintenance completed successfully', 'info');


<?php
/**
 * ======================================================
 *  TRENCH CITY SELF-TEST MODULE (v1.0)
 *  Automated Core Integrity Check
 *  Run manually or via cron to verify environment health
 * ======================================================
 */

require_once __DIR__ . '/bootstrap.php';

if (php_sapi_name() !== 'cli') {
    die("This tool is CLI-only.\n");
}

echo "==============================================\n";
echo "🧾  TRENCH CITY CORE SELF TEST\n";
echo "==============================================\n\n";

// ------------------------------------------------------
// 1️⃣ ENVIRONMENT
// ------------------------------------------------------
echo "🌍 Environment: " . APP_ENV . "\n";
echo "🔑 App Key: " . (defined('APP_KEY') ? "✅ Set" : "❌ Missing") . "\n";
echo "🕒 Timezone: " . date_default_timezone_get() . "\n\n";

// ------------------------------------------------------
// 2️⃣ DATABASE CHECK
// ------------------------------------------------------
$db_ok = function_exists('tc_db_check') && tc_db_check();
echo "🗄️  Database: " . ($db_ok ? "✅ Connected" : "❌ Failed") . "\n";

// ------------------------------------------------------
// 3️⃣ REDIS CHECK
// ------------------------------------------------------
$redis_ok = function_exists('tc_redis_check') && tc_redis_check();
echo "💾 Redis: " . ($redis_ok ? "✅ Connected" : "❌ Failed") . "\n";

// ------------------------------------------------------
// 4️⃣ LOGGING CHECK
// ------------------------------------------------------
$logFile = sprintf('%s/selftest-%s.log', LOG_PATH, date('Y-m-d'));
$log_ok = @file_put_contents($logFile, "[SELFTEST] Log write test\n", FILE_APPEND | LOCK_EX);
echo "🧾 Logs: " . ($log_ok ? "✅ Writable" : "❌ Permission denied") . "\n";

// ------------------------------------------------------
// 5️⃣ SECURITY CHECK
// ------------------------------------------------------
$hash = tc_hash('test');
$security_ok = tc_verify('test', $hash);
echo "⚔️  Security: " . ($security_ok ? "✅ OK" : "❌ Failed") . "\n";

// ------------------------------------------------------
// 6️⃣ ENV CONSISTENCY
// ------------------------------------------------------
$required = ['DB_HOST', 'DB_USER', 'REDIS_HOST'];
$missing = [];
foreach ($required as $key) {
    if (!defined($key)) $missing[] = $key;
}
echo "📦 Config: " . (empty($missing) ? "✅ All defined" : "❌ Missing: " . implode(', ', $missing)) . "\n";

// ------------------------------------------------------
// 7️⃣ TELEMETRY REPORT (Redis)
// ------------------------------------------------------
if ($redis_ok) {
    try {
        $r = redis();
        $r->xAdd('tc:health', '*', [
            'timestamp' => date('Y-m-d H:i:s'),
            'env' => APP_ENV,
            'db' => $db_ok ? 'ok' : 'fail',
            'redis' => $redis_ok ? 'ok' : 'fail',
            'logs' => $log_ok ? 'ok' : 'fail'
        ]);
        echo "📡 Telemetry: ✅ Sent to Redis (tc:health)\n";
    } catch (Throwable $e) {
        echo "📡 Telemetry: ⚠️ Failed (" . $e->getMessage() . ")\n";
    }
} else {
    echo "📡 Telemetry: ❌ Skipped (Redis unavailable)\n";
}

// ------------------------------------------------------
// 8️⃣ SUMMARY
// ------------------------------------------------------
$all_ok = $db_ok && $redis_ok && $log_ok && $security_ok && empty($missing);
echo "\n==============================================\n";
echo $all_ok
    ? "✅ ALL SYSTEMS OPERATIONAL — TRENCH CITY CORE HEALTHY\n"
    : "❌ CORE ISSUES DETECTED — CHECK LOGS\n";
echo "==============================================\n\n";

exit($all_ok ? 0 : 1);

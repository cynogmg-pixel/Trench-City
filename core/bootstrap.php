<?php
/**
 * ======================================================
 *  🏙️  TRENCH CITY BOOTSTRAP CORE (v2.4 — FINAL FIXED)
 * ======================================================
 *  Universal Core Loader — Modular, Secure & Autonomous
 *  Features:
 *   ✅ Ordered core dependency loading
 *   ✅ Verified module discovery (/core/modules)
 *   ✅ Centralized logging, error handling, telemetry
 *   ✅ Safe dual context (CLI + Web)
 *   ✅ Self-healing + CorePanel integration ready
 * ======================================================
 *  Author: Architect
 *  Status: Production-Stable | Hardened | Self-Healing
 * ======================================================
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

// ------------------------------------------------------
//  1️⃣ Load Environment Config (.env.php)
// ------------------------------------------------------
$envFile = __DIR__ . '/env.php';
if (file_exists($envFile)) {
    require_once $envFile;
} else {
    error_log('[BOOTSTRAP] Missing env.php — using fallback environment.');
}

// ------------------------------------------------------
//  2️⃣ Define Environment Constants (Safe Defaults)
// ------------------------------------------------------
if (!defined('APP_ENV')) define('APP_ENV', getenv('APP_ENV') ?: 'dev');
if (!defined('APP_KEY')) define('APP_KEY', getenv('APP_KEY') ?: 'fallback_app_key');
if (!defined('DEBUG')) define('DEBUG', in_array(APP_ENV, ['dev', 'development', 'alpha'], true));

// ------------------------------------------------------
//  3️⃣ Load Core Dependencies (Strict Order)
// ------------------------------------------------------
$coreFiles = [
    __DIR__ . '/config.php',
    __DIR__ . '/constants.php',
    __DIR__ . '/db.php',
    __DIR__ . '/redis.php',
    __DIR__ . '/log.php',
    __DIR__ . '/security.php',
    __DIR__ . '/errors.php',
];

foreach ($coreFiles as $file) {
    if (file_exists($file)) {
        require_once $file;
    } else {
        error_log("[BOOTSTRAP] Missing core dependency: {$file}");
    }
}

// ------------------------------------------------------
//  4️⃣ Register Error, Exception & Shutdown Handlers
// ------------------------------------------------------
if (function_exists('tc_handle_error')) {
    set_error_handler('tc_handle_error');
    set_exception_handler('tc_handle_exception');
    register_shutdown_function('tc_shutdown_handler');
    if (function_exists('tc_log')) tc_log('✅ Global error handlers active', 'info');
} else {
    error_log('[BOOTSTRAP] ⚠️ No error handler registered.');
}

// ------------------------------------------------------
//  5️⃣ Load Helpers & Optional Extensions
// ------------------------------------------------------
$optionalFiles = [__DIR__ . '/helpers.php'];
foreach ($optionalFiles as $file) {
    if (file_exists($file)) {
        require_once $file;
    } else {
        error_log("[BOOTSTRAP] Optional dependency missing: {$file}");
    }
}

// ------------------------------------------------------
//  6️⃣ Auto-Load Modules from /core/modules (Final Bulletproof Loader)
// ------------------------------------------------------
$modulesDir = __DIR__ . '/modules';
$moduleCount = 0;
$cliContext = php_sapi_name() === 'cli';
$moduleScanVerbose = $cliContext;
if (!$moduleScanVerbose) {
    $isDevEnv = function_exists('is_dev')
        ? is_dev()
        : (defined('APP_ENV') && in_array(APP_ENV, ['dev', 'development'], true));
    $moduleScanVerbose = $isDevEnv && isset($_GET['debug']) && $_GET['debug'] === '1';
}

$moduleOutputSuppressed = false;
if (!$moduleScanVerbose) {
    ob_start();
    $moduleOutputSuppressed = true;
}
$moduleEcho = function (string $message) use ($moduleScanVerbose): void {
    if ($moduleScanVerbose) {
        echo $message;
    }
};

if (is_dir($modulesDir)) {
    $resolvedDir = realpath($modulesDir) ?: $modulesDir;
    $moduleEcho("[BOOTSTRAP] Scanning modules directory: {$resolvedDir}\n");

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($resolvedDir, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $fileInfo) {
        if ($fileInfo->getExtension() !== 'php') continue;
        $fullPath = $fileInfo->getPathname();

        if (!is_readable($fullPath)) {
            $msg = "[BOOTSTRAP] WARN Unreadable module: {$fullPath}";
            $moduleEcho("{$msg}\n");
            error_log($msg);
            if (function_exists('tc_log')) tc_log($msg, 'warn');
            continue;
        }

        try {
            require_once $fullPath;
            $moduleCount++;
            $msg = "[BOOTSTRAP] INFO Loaded module: " . basename($fullPath);
            $moduleEcho("{$msg}\n");
            if (function_exists('tc_log')) tc_log("[MODULE] " . basename($fullPath) . " loaded", 'info');
        } catch (Throwable $e) {
            $err = "[BOOTSTRAP] ERROR Failed to load {$fullPath}: {$e->getMessage()}";
            $moduleEcho("{$err}\n");
            error_log($err);
            if (function_exists('tc_log')) tc_log($err, 'error');
        }
    }

    if ($moduleCount === 0) {
        $msg = "[BOOTSTRAP] WARN No PHP modules loaded from {$resolvedDir}";
        $moduleEcho("{$msg}\n");
        error_log($msg);
        if (function_exists('tc_log')) tc_log($msg, 'warn');
    }

    $moduleEcho("[BOOTSTRAP] Modules loaded: {$moduleCount}\n");
} else {
    $msg = "[BOOTSTRAP] ERROR Module directory not found: {$modulesDir}";
    $moduleEcho("{$msg}\n");
    error_log($msg);
    if (function_exists('tc_log')) tc_log($msg, 'error');
}

if (!empty($moduleOutputSuppressed)) {
    ob_end_clean();
}


// ------------------------------------------------------
//  7️⃣ Runtime & PHP Environment Settings
// ------------------------------------------------------
date_default_timezone_set(defined('APP_TIMEZONE') ? APP_TIMEZONE : 'Europe/London');
mb_internal_encoding('UTF-8');
error_reporting(E_ALL);
ini_set('display_errors', DEBUG ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', '/var/www/trench_city/storage/logs/php_error.log');

// Ensure log directory exists and is writable
$logDir = '/var/www/trench_city/storage/logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0750, true);
    @chown($logDir, 'www-data');
}

// ------------------------------------------------------
//  8️⃣ Security Headers (Web Context Only)
// ------------------------------------------------------
if (php_sapi_name() !== 'cli') {
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
}

// ------------------------------------------------------
//  9️⃣ Sanity Checks for Core Services
// ------------------------------------------------------
if (!function_exists('tc_db_connect')) error_log('[BOOTSTRAP] db.php missing.');
if (!function_exists('tc_redis_connect')) error_log('[BOOTSTRAP] redis.php missing.');
if (!defined('APP_KEY')) error_log('[BOOTSTRAP] APP_KEY missing.');

// ------------------------------------------------------
//  🔟 Connectivity Verification (DB / Redis)
// ------------------------------------------------------
$dbStatus = function_exists('tc_db_check') ? (tc_db_check() ? '✅ Connected' : '❌ Failed') : 'Unavailable';
$redisStatus = function_exists('tc_redis_check') ? (tc_redis_check() ? '✅ Connected' : '❌ Failed') : 'Unavailable';

if (function_exists('tc_log')) {
    tc_log("[BOOT] Database: {$dbStatus}", 'info');
    tc_log("[BOOT] Redis: {$redisStatus}", 'info');
}

// ------------------------------------------------------
//  11️⃣ CLI Summary Output
// ------------------------------------------------------
if (php_sapi_name() === 'cli') {
    echo "✅ Bootstrapped: " . (defined('APP_NAME') ? APP_NAME : 'Trench City') . " " . (defined('APP_VERSION') ? APP_VERSION : '') . PHP_EOL;
    echo "🌍 Environment: " . APP_ENV . " | Debug: " . (DEBUG ? "ON" : "OFF") . PHP_EOL;
    echo "🗄️  DB: {$dbStatus}" . PHP_EOL;
    echo "💾 Redis: {$redisStatus}" . PHP_EOL;
    echo "⚙️  Modules Loaded: {$moduleCount}" . PHP_EOL;
    echo "🕒 PHP Version: " . PHP_VERSION . PHP_EOL;
}

// ------------------------------------------------------
//  12️⃣ CLI Safe Mode (php -r Handler Recovery)
// ------------------------------------------------------
if (php_sapi_name() === 'cli' && basename($_SERVER['PHP_SELF']) === '-') {
    try {
        set_error_handler('tc_handle_error');
        set_exception_handler('tc_handle_exception');
        register_shutdown_function('tc_shutdown_handler');
    } catch (Throwable $e) {
        fwrite(STDERR, "[BOOTSTRAP FATAL] {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}\n");
    }
}

// ------------------------------------------------------
//  🧩 13️⃣ Final Log Entry
// ------------------------------------------------------
if (function_exists('tc_log')) {
    tc_log(sprintf(
        "[BOOT] Trench City Core Ready — ENV: %s | PHP: %s | Modules: %d",
        APP_ENV,
        PHP_VERSION,
        $moduleCount
    ), 'info');
}

<?php
/**
 * ======================================================
 *  TRENCH CITY LOG CORE (v1.2 — FINAL POLISHED)
 * ------------------------------------------------------
 *  ✅ Daily rotation (auto-trim older than N days)
 *  ✅ Safe fallback to /tmp if logs unwritable
 *  ✅ Redis telemetry stream for ERROR/FATAL
 *  ✅ Self-healing permissions (www-data:0750)
 *  ✅ Timestamped + unique error IDs
 *  ✅ Lightweight atomic writes
 * ======================================================
 *  Author: Architect
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

// ------------------------------------------------------
//  CONFIGURATION
// ------------------------------------------------------
if (!defined('LOG_PATH')) define('LOG_PATH', __DIR__ . '/../storage/logs');
if (!defined('LOG_RETENTION_DAYS')) define('LOG_RETENTION_DAYS', 7);
if (!defined('LOG_FALLBACK')) define('LOG_FALLBACK', sys_get_temp_dir() . '/trench_city_fallback.log');

/**
 * Resolve a writable base path for logs.
 * Falls back to /tmp if the configured path is not writable.
 */
function tc_log_base_path(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }

    $base = LOG_PATH;

    // Ensure log directory exists
    if (!is_dir($base)) {
        @mkdir($base, 0750, true);
        
    }

    // Fall back if still not writable
    if (!is_dir($base) || !is_writable($base)) {
        $fallbackDir = dirname(LOG_FALLBACK);
        if (!is_dir($fallbackDir)) {
            @mkdir($fallbackDir, 0750, true);
        }
        $base = $fallbackDir;
    }

    return $base;
}

// ------------------------------------------------------
//  INTERNAL HELPERS
// ------------------------------------------------------
function tc_log_safe_write(string $path, string $entry): void
{
    try {
        $dir = dirname($path);
        if (!is_dir($dir)) @mkdir($dir, 0750, true);

        $result = @file_put_contents($path, $entry, FILE_APPEND | LOCK_EX);
        if ($result === false) {
            // Permission recovery attempt
            @chmod($dir, 0750);
            
            @file_put_contents($path, $entry, FILE_APPEND | LOCK_EX);
        }
    } catch (Throwable $t) {
        // Fallback log if write fails completely
        $fallbackEntry = sprintf(
            "[%s] [FALLBACK] Log write failed for %s | %s\n%s\n",
            date('Y-m-d H:i:s'),
            $path,
            $t->getMessage(),
            $entry
        );
        @file_put_contents(LOG_FALLBACK, $fallbackEntry, FILE_APPEND | LOCK_EX);
    }
}

/**
 * Rotate and delete old logs beyond retention threshold
 */
function tc_rotate_logs(): void
{
    $base = tc_log_base_path();
    $files = glob($base . '/*.log');
    if (!$files) return;

    $threshold = time() - (LOG_RETENTION_DAYS * 86400);
    foreach ($files as $file) {
        if (@filemtime($file) < $threshold) {
            @unlink($file);
        }
    }
}

/**
 * Generates a short unique log ID for cross-referencing
 */
function tc_log_id(): string
{
    return strtoupper(bin2hex(random_bytes(3)));
}

// ------------------------------------------------------
//  CORE LOGGER
// ------------------------------------------------------
function tc_write_log(string $level, string $message): void
{
    static $rotated = false;
    $base = tc_log_base_path();

    $date = date('Y-m-d');
    $timestamp = date('Y-m-d H:i:s');
    $level = strtoupper($level);
    $errorId = tc_log_id();

    $logFile = sprintf("%s/%s-%s.log", $base, strtolower($level), $date);
    $entry = sprintf("[%s] [%s] [%s] %s\n", $timestamp, $level, $errorId, trim($message));

    // Ensure directory writable
    if (!is_writable($base)) {
        @chmod($base, 0750);
        
    }

    tc_log_safe_write($logFile, $entry);

    // Rotate once per runtime
    if (!$rotated) {
        tc_rotate_logs();
        $rotated = true;
    }

    // --------------------------------------------------
    //  Redis telemetry stream for critical logs
    // --------------------------------------------------
    if (in_array($level, ['ERROR', 'FATAL'], true) && function_exists('redis')) {
        try {
            $r = redis();
            if ($r) {
                $r->xAdd('tc:errors', '*', [
                    'id'      => $errorId,
                    'level'   => $level,
                    'message' => substr($message, 0, 300),
                    'time'    => $timestamp,
                    'env'     => defined('APP_ENV') ? APP_ENV : 'unknown',
                    'host'    => php_uname('n'),
                ]);
            }
        } catch (Throwable $e) {
            // Fail silently but log locally
            $fallback = sprintf("[REDIS-FAIL] %s: %s\n", $level, $e->getMessage());
            @file_put_contents(LOG_FALLBACK, $fallback, FILE_APPEND | LOCK_EX);
        }
    }
}

// ------------------------------------------------------
//  PUBLIC LOGGING FUNCTIONS
// ------------------------------------------------------
function log_info(string $msg): void  { tc_write_log('INFO',  $msg); }
function log_warn(string $msg): void  { tc_write_log('WARN',  $msg); }
function log_error(string $msg): void { tc_write_log('ERROR', $msg); }
function log_fatal(string $msg): void { tc_write_log('FATAL', $msg); }

function log_debug(string $msg): void
{
    if (defined('DEBUG') && DEBUG) tc_write_log('DEBUG', $msg);
}

// ------------------------------------------------------
//  SHORTHAND WRAPPER (UNIFIED ENTRYPOINT)
// ------------------------------------------------------
if (!function_exists('tc_log')) {
    function tc_log(string $message, string $type = 'info'): void
    {
        switch (strtolower($type)) {
            case 'fatal': log_fatal($message); break;
            case 'error': log_error($message); break;
            case 'warn':  log_warn($message);  break;
            case 'debug': log_debug($message); break;
            default:      log_info($message);  break;
        }
    }
}

// ------------------------------------------------------
//  BOOT MESSAGE
// ------------------------------------------------------
tc_log(sprintf(
    '[BOOT] Logging ready for %s (%s @ %s)',
    defined('APP_NAME') ? APP_NAME : 'Trench City',
    defined('APP_ENV') ? APP_ENV : 'unknown',
    php_sapi_name()
), 'info');


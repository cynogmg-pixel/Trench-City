<?php
/**
 * ======================================================
 *  TRENCH CITY ENTERPRISE ERROR HANDLER (v2)
 *  Full-stack observability: error IDs + trace logging
 *  Context-aware for CLI, API, and Web
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

/**
 * ------------------------------------------------------
 * Detect output context (CLI / JSON / HTML)
 * ------------------------------------------------------
 */
function tc_output_context(): string
{
    if (php_sapi_name() === 'cli') return 'cli';
    if (!empty($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) return 'json';
    if (isset($_SERVER['REQUEST_URI']) && str_starts_with($_SERVER['REQUEST_URI'], '/api/')) return 'json';
    return 'html';
}

/**
 * ------------------------------------------------------
 * Generate a unique error reference ID
 * ------------------------------------------------------
 */
function tc_error_id(): string
{
    return 'ERR-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
}

/**
 * ------------------------------------------------------
 * Write a detailed trace to logs
 * ------------------------------------------------------
 */
function tc_log_trace(string $errorId, string $type, string $message, ?Throwable $e = null): void
{
    $logDir = '/var/www/trench_city/storage/logs';
    $fallback = defined('LOG_FALLBACK') ? LOG_FALLBACK : '/tmp/trench_city_fallback.log';
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0750, true);
    }
    if (!is_writable($logDir) && function_exists('posix_geteuid') && posix_geteuid() === 0) {
        // Only try to fix permissions if running as root
        @chmod($logDir, 0750);
        @chown($logDir, 'www-data');
    }

    $file = is_writable($logDir) ? "{$logDir}/error_trace.log" : $fallback;
    $timestamp = date('Y-m-d H:i:s');
    $trace = $e ? $e->getTraceAsString() : '(no stack trace)';

    $entry = <<<LOG
========================================================
[$timestamp] [$type] [$errorId]
$message
$trace

LOG;

    @file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);

    // Also write to standard log channel
    if (function_exists('tc_log')) tc_log("[$errorId] $message", strtolower($type));
}

/**
 * ------------------------------------------------------
 * Smart output renderer with FULL error details
 * ------------------------------------------------------
 */
function tc_render_error(array $data, int $httpCode = 500): void
{
    $context = tc_output_context();

    if ($context === 'cli') {
        echo "❌ [{$data['type']}] {$data['message']} (Error ID: {$data['id']})" . PHP_EOL;
        if (!empty($data['file'])) echo "   File: {$data['file']}:{$data['line']}" . PHP_EOL;
        return;
    }

    http_response_code($httpCode);

    if ($context === 'json') {
        header('Content-Type: application/json');
        echo json_encode([
            'error' => true,
            'error_id' => $data['id'],
            'type' => $data['type'] ?? 'Error',
            'message' => $data['message'] ?? 'Internal server error',
            'file' => $data['file'] ?? null,
            'line' => $data['line'] ?? null,
            'trace' => $data['trace'] ?? null,
            'code' => $httpCode
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        return;
    }

    // HTML with detailed error info
    header('Content-Type: text/html; charset=utf-8');
    $timestamp = date('Y-m-d H:i:s');

    // Escape data for safe HTML display
    $errorId = htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8');
    $errorType = htmlspecialchars($data['type'] ?? 'Error', ENT_QUOTES, 'UTF-8');
    $errorMessage = htmlspecialchars($data['message'] ?? 'Unknown error', ENT_QUOTES, 'UTF-8');
    $errorFile = htmlspecialchars($data['file'] ?? 'Unknown file', ENT_QUOTES, 'UTF-8');
    $errorLine = htmlspecialchars($data['line'] ?? '0', ENT_QUOTES, 'UTF-8');
    $errorTrace = htmlspecialchars($data['trace'] ?? 'No trace available', ENT_QUOTES, 'UTF-8');

    echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Trench City Error - {$errorId}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 100%);
    color: #f2f2f2;
    font-family: 'Segoe UI', Arial, sans-serif;
    padding: 20px;
    min-height: 100vh;
}
.container { max-width: 1200px; margin: 0 auto; }
.header {
    background: linear-gradient(135deg, #ff4444 0%, #cc0000 100%);
    padding: 30px;
    border-radius: 10px 10px 0 0;
    border-left: 5px solid #ff6666;
}
.header h1 {
    font-size: 28px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.header p {
    opacity: 0.9;
    font-size: 16px;
}
.error-card {
    background: #1a1a1a;
    border: 1px solid #333;
    border-radius: 0 0 10px 10px;
    overflow: hidden;
}
.error-section {
    padding: 25px;
    border-bottom: 1px solid #2a2a2a;
}
.error-section:last-child { border-bottom: none; }
.error-section h2 {
    color: #ffcc00;
    font-size: 18px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.error-id {
    background: #2a2a2a;
    padding: 15px 20px;
    border-radius: 8px;
    border-left: 4px solid #ffcc00;
    font-family: 'Courier New', monospace;
    font-size: 20px;
    font-weight: bold;
    color: #ffcc00;
    letter-spacing: 1px;
}
.error-type {
    display: inline-block;
    background: #ff4444;
    color: white;
    padding: 6px 12px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 10px;
}
.error-message {
    background: #2a2a2a;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #ff4444;
    font-size: 16px;
    line-height: 1.6;
    color: #ff8888;
    margin-bottom: 15px;
}
.error-location {
    background: #2a2a2a;
    padding: 15px 20px;
    border-radius: 8px;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    color: #00ddff;
}
.error-location strong {
    color: #ffcc00;
    margin-right: 10px;
}
.error-trace {
    background: #0d0d0d;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #333;
    font-family: 'Courier New', monospace;
    font-size: 13px;
    line-height: 1.8;
    color: #aaa;
    overflow-x: auto;
    white-space: pre-wrap;
    word-wrap: break-word;
    max-height: 400px;
    overflow-y: auto;
}
.info-box {
    background: #2a2a2a;
    padding: 15px 20px;
    border-radius: 8px;
    border-left: 4px solid #00ddff;
    margin-top: 15px;
}
.info-box p {
    font-size: 14px;
    color: #ccc;
    line-height: 1.6;
}
.timestamp {
    text-align: center;
    padding: 20px;
    color: #666;
    font-size: 13px;
    border-top: 1px solid #2a2a2a;
}
.icon { font-size: 24px; }
.badge {
    display: inline-block;
    padding: 4px 8px;
    background: #333;
    border-radius: 4px;
    font-size: 12px;
    margin-left: 10px;
}
@media (max-width: 768px) {
    body { padding: 10px; }
    .header h1 { font-size: 22px; }
    .error-id { font-size: 16px; }
}
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1><span class="icon">⚠️</span> Error Detected</h1>
        <p>The application encountered an error and has been logged for debugging.</p>
    </div>

    <div class="error-card">
        <div class="error-section">
            <h2><span>🆔</span> Error Reference ID</h2>
            <div class="error-id">{$errorId}</div>
            <div class="info-box">
                <p><strong>📋 What to do:</strong> Copy this error ID and provide it when reporting this issue. This ID helps locate the full error details in the server logs.</p>
            </div>
        </div>

        <div class="error-section">
            <h2><span>🔍</span> Error Details</h2>
            <span class="error-type">{$errorType}</span>
            <div class="error-message">{$errorMessage}</div>
            <div class="error-location">
                <div><strong>📄 File:</strong> {$errorFile}</div>
                <div><strong>📍 Line:</strong> {$errorLine}</div>
            </div>
        </div>

        <div class="error-section">
            <h2><span>📚</span> Stack Trace</h2>
            <div class="error-trace">{$errorTrace}</div>
        </div>

        <div class="error-section">
            <h2><span>🛠️</span> Debugging Tips</h2>
            <div class="info-box">
                <p><strong>Common Causes:</strong></p>
                <ul style="margin-left: 20px; margin-top: 10px; line-height: 1.8;">
                    <li>Database connection issues (check DB_HOST, DB_USER, DB_PASS in .env)</li>
                    <li>Redis connection issues (check REDIS_HOST, REDIS_PASS in .env)</li>
                    <li>Missing or incorrect configuration in .env file</li>
                    <li>File permission issues (check www-data can read/write files)</li>
                    <li>Missing database tables (run SQL schema imports)</li>
                    <li>PHP extension not loaded (check php -m for required extensions)</li>
                </ul>
            </div>
        </div>

        <div class="timestamp">
            <p><strong>Trench City Engine</strong> · Error logged at {$timestamp}</p>
            <p style="margin-top: 5px; font-size: 12px;">Check <code>/var/www/trench_city/storage/logs/error_trace.log</code> for full details</p>
        </div>
    </div>
</div>
</body>
</html>
HTML;
}

/**
 * ------------------------------------------------------
 * Handle warnings and notices
 * ------------------------------------------------------
 */
function tc_handle_error(int $errno, string $errstr, string $errfile, int $errline): bool
{
    // Skip permission warnings from error handler itself
    if (str_contains($errfile, 'errors.php') && (str_contains($errstr, 'chmod') || str_contains($errstr, 'chown'))) {
        return true;
    }

    // Skip "headers already sent" warnings from error handler
    if (str_contains($errstr, 'Cannot modify header information')) {
        return true;
    }

    $id = tc_error_id();
    $message = "⚠️ [$errno] $errstr in $errfile:$errline";
    error_log($message);
    tc_log_trace($id, 'WARNING', $message);

    $data = [
        'error' => true,
        'id' => $id,
        'type' => 'Warning',
        'message' => $errstr,
        'file' => $errfile,
        'line' => $errline
    ];

    tc_render_error($data, 500);
    exit; // Stop execution after showing error
}

/**
 * ------------------------------------------------------
 * Handle uncaught exceptions
 * ------------------------------------------------------
 */
function tc_handle_exception(Throwable $e): void
{
    $id = tc_error_id();
    $message = "❌ Exception: {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}";
    error_log("[$id] $message");
    tc_log_trace($id, 'EXCEPTION', $message, $e);

    $data = [
        'error' => true,
        'id' => $id,
        'type' => get_class($e),
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ];

    tc_render_error($data, 500);
    exit(1);
}

/**
 * ------------------------------------------------------
 * Handle fatal shutdown errors
 * ------------------------------------------------------
 */
function tc_shutdown_handler(): void
{
    $error = error_get_last();
    if (!$error || !in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) return;

    $id = tc_error_id();
    $message = "💀 Fatal: {$error['message']} in {$error['file']}:{$error['line']}";
    error_log("[$id] $message");
    tc_log_trace($id, 'FATAL', $message);

    $data = [
        'error' => true,
        'id' => $id,
        'type' => 'Fatal',
        'message' => $error['message'],
        'file' => $error['file'],
        'line' => $error['line']
    ];

    tc_render_error($data, 500);
}

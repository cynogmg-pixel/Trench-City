<?php
/**
 * ======================================================
 *  TRENCH CITY CONSTANTS CORE (v1.3 FINAL)
 *  Safe global constants, environment-aware.
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

/**
 * ------------------------------------------
 *  ENVIRONMENT CONTEXT (Loaded via env.php)
 * ------------------------------------------
 */

// The env() helper is defined in env.php to avoid duplication.
// Ensure APP_ENV + DEBUG are defined even if env.php failed.
if (!defined('APP_ENV')) {
    define('APP_ENV', getenv('APP_ENV') ?: 'dev');
}

if (!defined('DEBUG')) {
    define('DEBUG', in_array(APP_ENV, ['dev', 'development', 'alpha'], true));
}

/**
 * ------------------------------------------
 *  APP METADATA
 * ------------------------------------------
 */
if (!defined('APP_NAME')) define('APP_NAME', getenv('APP_NAME') ?: 'Trench City');
if (!defined('APP_VERSION')) define('APP_VERSION', getenv('APP_VERSION') ?: '1.0.0');
if (!defined('APP_BUILD')) define('APP_BUILD', date('Ymd'));
if (!defined('APP_KEY')) define('APP_KEY', getenv('APP_KEY') ?: bin2hex(random_bytes(16)));

/**
 * ------------------------------------------
 *  PATH CONSTANTS
 * ------------------------------------------
 */
if (!defined('BASE_PATH')) define('BASE_PATH', dirname(__DIR__, 1));
if (!defined('CORE_PATH')) define('CORE_PATH', BASE_PATH . '/core');
if (!defined('PUBLIC_PATH')) define('PUBLIC_PATH', BASE_PATH . '/public');
if (!defined('STORAGE_PATH')) define('STORAGE_PATH', BASE_PATH . '/storage');
if (!defined('LOG_PATH')) define('LOG_PATH', STORAGE_PATH . '/logs');

/**
 * ------------------------------------------
 *  DATABASE CONFIGURATION
 * ------------------------------------------
 */
if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
if (!defined('DB_PORT')) define('DB_PORT', getenv('DB_PORT') ?: 3306);
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'trench_city');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'trench');
if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') ?: 'password');

/**
 * ------------------------------------------
 *  REDIS CONFIGURATION
 * ------------------------------------------
 */
if (!defined('REDIS_HOST')) define('REDIS_HOST', getenv('REDIS_HOST') ?: '127.0.0.1');
if (!defined('REDIS_PORT')) define('REDIS_PORT', getenv('REDIS_PORT') ?: 6379);
if (!defined('REDIS_PASS')) define('REDIS_PASS', getenv('REDIS_PASS') ?: null);

/**
 * ------------------------------------------
 *  SECURITY + TOKENS
 * ------------------------------------------
 */
if (!defined('CSRF_TTL')) define('CSRF_TTL', 300);
if (!defined('NONCE_TTL')) define('NONCE_TTL', 300);
if (!defined('CUSTOM_TOKEN')) define('CUSTOM_TOKEN', getenv('CUSTOM_TOKEN') ?: 'ALPHA-CORE-1234');

/**
 * ------------------------------------------
 *  SYSTEM / MISC SETTINGS
 * ------------------------------------------
 */
if (!defined('APP_TIMEZONE')) define('APP_TIMEZONE', getenv('APP_TIMEZONE') ?: 'Europe/London');
if (!defined('MAX_UPLOAD_SIZE')) define('MAX_UPLOAD_SIZE', getenv('MAX_UPLOAD_SIZE') ?: 10485760); // 10MB
if (!defined('DEFAULT_LANGUAGE')) define('DEFAULT_LANGUAGE', getenv('DEFAULT_LANGUAGE') ?: 'en');

/**
 * ------------------------------------------
 *  DEBUG / STATUS (CLI Only)
 * ------------------------------------------
 */
if (php_sapi_name() === 'cli') {
    echo "✅ Loaded constants: " . APP_NAME . " " . APP_VERSION . " (" . APP_BUILD . ")\n";
    echo "🌍 Environment: " . APP_ENV . " | Debug: " . (DEBUG ? "ON" : "OFF") . "\n";
}

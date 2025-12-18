<?php
/**
 * ======================================================
 *  TRENCH CITY CONFIGURATION CORE (FINAL)
 *  Environment-Aware Application Configuration
 *  Loads from .env → Defaults → Constants
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) {
    define('TRENCH_CITY', true);
}

/**
 * Ensure environment is loaded first
 */
if (function_exists('load_env')) {
    load_env();
}

/**
 * Safe constant define helper
 */
if (!function_exists('tc_define')) {
    function tc_define(string $key, $value): void {
        if (!defined($key)) define($key, $value);
    }
}

/**
 * ======================================================
 *  APP CONFIGURATION
 * ======================================================
 */
tc_define('APP_NAME',      env('APP_NAME', 'Trench City'));
tc_define('APP_ENV',       env('APP_ENV', 'dev'));
tc_define('APP_KEY',       env('APP_KEY', bin2hex(random_bytes(16))));
tc_define('APP_URL',       env('APP_URL', 'http://localhost'));
tc_define('APP_TIMEZONE',  env('APP_TIMEZONE', 'Europe/London'));
tc_define('DEBUG',         filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN));

tc_define('APP_VERSION',   '1.0.0');
tc_define('APP_BUILD',     date('Ymd'));

/**
 * ======================================================
 *  PATHS
 * ======================================================
 */
tc_define('TC_BASE_PATH',  env('BASE_PATH', '/var/www/trench_city'));
tc_define('CORE_PATH',     env('CORE_PATH', TC_BASE_PATH . '/core'));
tc_define('PUBLIC_PATH',   env('PUBLIC_PATH', TC_BASE_PATH . '/public'));
tc_define('INCLUDE_PATH',  env('INCLUDE_PATH', TC_BASE_PATH . '/includes'));
tc_define('LOG_PATH',      env('LOG_PATH', TC_BASE_PATH . '/storage/logs'));

/**
 * ======================================================
 *  DATABASE CONFIGURATION
 * ======================================================
 */
tc_define('DB_HOST',       env('DB_HOST', '10.7.230.13'));
tc_define('DB_PORT',       env('DB_PORT', 3306));
tc_define('DB_NAME',       env('DB_NAME', 'trench_city'));
tc_define('DB_USER',       env('DB_USER', 'trench'));
tc_define('DB_PASS',       env('DB_PASS', 'Rianna2602'));

/**
 * ======================================================
 *  REDIS CONFIGURATION
 * ======================================================
 */
tc_define('REDIS_HOST',    env('REDIS_HOST', '10.7.236.11'));
tc_define('REDIS_PORT',    env('REDIS_PORT', 6379));
tc_define('REDIS_PASS',    env('REDIS_PASS', 'Rianna2602'));

/**
 * ======================================================
 *  LOGGING CONFIGURATION
 * ======================================================
 */
tc_define('LOG_INFO_FILE',  LOG_PATH . '/info.log');
tc_define('LOG_ERROR_FILE', LOG_PATH . '/error.log');

/**
 * ======================================================
 *  SECURITY SETTINGS
 * ======================================================
 */
tc_define('SECURE_HEADERS', true);
tc_define('ALLOW_DEBUG_OUTPUT', APP_ENV === 'dev' || APP_ENV === 'development');

/**
 * ======================================================
 *  FINALIZATION
 * ======================================================
 */
date_default_timezone_set(APP_TIMEZONE);
mb_internal_encoding('UTF-8');
error_reporting(DEBUG ? E_ALL : E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', DEBUG ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', LOG_ERROR_FILE);

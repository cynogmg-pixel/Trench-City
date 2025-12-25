<?php
/**
 * ======================================================
 *  TRENCH CITY SESSION SECURITY
 *  Secure Session Configuration & Management
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) {
    define('TRENCH_CITY', true);
}

/**
 * Initialize secure session configuration
 * MUST be called before session_start()
 */
function tc_init_session_config(): void
{
    // Prevent session fixation attacks
    ini_set('session.use_strict_mode', '1');

    // Use only cookies for session ID (not URL parameters)
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_trans_sid', '0');

    // HttpOnly flag prevents JavaScript access to session cookie
    ini_set('session.cookie_httponly', '1');

    // Secure flag ensures cookies only sent over HTTPS
    // Note: Set to '1' in production with HTTPS
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
            || (!empty($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);

    ini_set('session.cookie_secure', $isHttps ? '1' : '0');

    // SameSite cookie attribute prevents CSRF attacks
    ini_set('session.cookie_samesite', 'Lax');

    // Session cookie path - scope to application
    ini_set('session.cookie_path', '/');

    // Session cookie domain - don't set to share across subdomains
    // Leave empty to restrict to current domain only
    ini_set('session.cookie_domain', '');

    // Session lifetime
    ini_set('session.gc_maxlifetime', '86400'); // 24 hours
    ini_set('session.cookie_lifetime', '0'); // Cookie expires when browser closes

    // Session name (change from default PHPSESSID)
    ini_set('session.name', 'TC_SESSION');

    // Strong session ID generation
    ini_set('session.sid_length', '48');
    ini_set('session.sid_bits_per_character', '6');

    // Use file-based sessions (safer and more reliable than Redis for sessions)
    $sessionPath = defined('SESSION_PATH') ? SESSION_PATH : '/var/www/trench_city/storage/sessions';

    if (!is_dir($sessionPath)) {
        @mkdir($sessionPath, 0750, true);
        @chown($sessionPath, 'www-data');
    }

    ini_set('session.save_handler', 'files');
    ini_set('session.save_path', $sessionPath);

    if (function_exists('tc_log')) {
        tc_log('[SESSION] Configuration initialized', 'info');
    }
}

/**
 * Start a secure session with all protections enabled
 */
function tc_session_start(): bool
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return true;
    }

    // Initialize session config if not already done
    tc_init_session_config();

    // Start the session
    if (!session_start()) {
        if (function_exists('tc_log')) {
            tc_log('[SESSION] Failed to start session', 'error');
        }
        return false;
    }

    // Session fixation protection - regenerate ID on first use
    if (!isset($_SESSION['_session_initialized'])) {
        session_regenerate_id(true);
        $_SESSION['_session_initialized'] = true;
        $_SESSION['_session_created_at'] = time();
    }

    // Session hijacking protection - check user agent and IP consistency
    $currentFingerprint = md5(
        ($_SERVER['HTTP_USER_AGENT'] ?? '') .
        ($_SERVER['REMOTE_ADDR'] ?? '')
    );

    if (!isset($_SESSION['_session_fingerprint'])) {
        $_SESSION['_session_fingerprint'] = $currentFingerprint;
    } elseif ($_SESSION['_session_fingerprint'] !== $currentFingerprint) {
        // Possible session hijacking detected
        if (function_exists('tc_log')) {
            tc_log('[SESSION] Fingerprint mismatch - possible hijacking attempt', 'warn');
        }
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['_session_initialized'] = true;
        $_SESSION['_session_created_at'] = time();
        $_SESSION['_session_fingerprint'] = $currentFingerprint;
    }

    // Session timeout - regenerate ID periodically (every 30 minutes)
    if (isset($_SESSION['_session_last_regeneration'])) {
        if (time() - $_SESSION['_session_last_regeneration'] > 1800) {
            session_regenerate_id(true);
            $_SESSION['_session_last_regeneration'] = time();
        }
    } else {
        $_SESSION['_session_last_regeneration'] = time();
    }

    return true;
}

/**
 * Destroy session completely
 */
function tc_session_destroy(): bool
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        $_SESSION = [];

        // Delete session cookie
        if (isset($_COOKIE[session_name()])) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        return session_destroy();
    }

    return true;
}

// Initialize session configuration on module load (web context only)
if (php_sapi_name() !== 'cli') {
    tc_init_session_config();
}

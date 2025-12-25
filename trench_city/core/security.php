<?php
/**
 * ======================================================
 *  TRENCH CITY SECURITY CORE
 *  CSRF, Request Signing, and Input Hardening
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) {
    define('TRENCH_CITY', true);
}

/**
 * Generate a CSRF token and store it in session
 */
function csrf_token(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/**
 * Validate a CSRF token against the session
 */
function csrf_check(string $token): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Generate a secure nonce (time-sensitive)
 */
function nonce_generate(int $ttl = 300): string
{
    $timestamp = time();
    $secret = env('APP_KEY', 'fallback_key');
    $hash = hash_hmac('sha256', $timestamp, $secret);
    return base64_encode(json_encode(['ts' => $timestamp, 'h' => $hash]));
}

/**
 * Verify a nonce within a given TTL
 */
function nonce_verify(string $nonce, int $ttl = 300): bool
{
    $data = json_decode(base64_decode($nonce), true);
    if (!is_array($data) || empty($data['ts']) || empty($data['h'])) {
        return false;
    }

    $secret = env('APP_KEY', 'fallback_key');
    $expected = hash_hmac('sha256', $data['ts'], $secret);

    if (!hash_equals($expected, $data['h'])) {
        return false;
    }

    return (time() - (int)$data['ts']) <= $ttl;
}

/**
 * Securely sign any payload using HMAC
 */
function sign_request(array $data): string
{
    $secret = env('APP_KEY', 'fallback_key');
    $payload = json_encode($data, JSON_UNESCAPED_SLASHES);
    $signature = hash_hmac('sha256', $payload, $secret);
    return base64_encode($payload . '::' . $signature);
}

/**
 * Verify signed payload integrity
 */
function verify_request(string $signed): ?array
{
    $secret = env('APP_KEY', 'fallback_key');
    $decoded = base64_decode($signed);
    if (!$decoded) return null;

    [$payload, $signature] = explode('::', $decoded, 2) + [null, null];
    if (!$payload || !$signature) return null;

    $expected = hash_hmac('sha256', $payload, $secret);
    if (!hash_equals($expected, $signature)) return null;

    return json_decode($payload, true);
}

/**
 * Harden all global input arrays
 */
function sanitize_globals(): void
{
    foreach (['_GET', '_POST', '_COOKIE', '_REQUEST'] as $global) {
        if (!isset($GLOBALS[$global]) || !is_array($GLOBALS[$global])) {
            continue;
        }

        foreach ($GLOBALS[$global] as $key => $val) {
            if (is_string($val)) {
                $GLOBALS[$global][$key] = trim(strip_tags($val));
            }
        }
    }
}

// Automatically sanitize on load
sanitize_globals();

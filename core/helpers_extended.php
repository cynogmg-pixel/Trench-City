<?php
/**
 * ======================================================
 *  TRENCH CITY EXTENDED HELPERS
 *  Cached data, runtime stats, lightweight tools
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) {
    require_once __DIR__ . '/bootstrap.php';
}

/**
 * ---------------------------
 *  REDIS CACHING HELPERS
 * ---------------------------
 */
function cache_set(string $key, $value, int $ttl = 300): bool {
    $r = redis();
    return $r ? $r->setex('cache:' . $key, $ttl, serialize($value)) : false;
}

function cache_get(string $key) {
    $r = redis();
    if (!$r) return null;
    $data = $r->get('cache:' . $key);
    return $data ? unserialize($data) : null;
}

function cache_delete(string $key): bool {
    $r = redis();
    return $r ? (bool)$r->del('cache:' . $key) : false;
}

/**
 * ---------------------------
 *  SYSTEM / RUNTIME HELPERS
 * ---------------------------
 */
function system_info(): array {
    return [
        'env'       => APP_ENV,
        'php'       => PHP_VERSION,
        'memory'    => round(memory_get_usage(true) / 1048576, 2) . ' MB',
        'uptime'    => @shell_exec('uptime -p') ?: 'unknown',
        'load'      => sys_getloadavg(),
        'time'      => now(),
    ];
}

/**
 * ---------------------------
 *  TOKEN / SESSION HELPERS
 * ---------------------------
 */
function generate_token(int $length = 32): string {
    return bin2hex(random_bytes($length / 2));
}

function verify_token(string $token, string $expected): bool {
    return hash_equals($expected, $token);
}

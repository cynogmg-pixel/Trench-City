<?php
/**
 * ======================================================
 *  TRENCH CITY REDIS CORE
 *  Secure Redis Connector with Auto-Reconnect
 *  Author: Architect
 *  Committed-by: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) {
    define('TRENCH_CITY', true);
}

require_once __DIR__ . '/config.php';

/**
 * Create and return a persistent Redis connection.
 *
 * @return Redis|null
 */
function tc_redis_connect(): ?Redis
{
    static $redis = null;
    if ($redis instanceof Redis) {
        return $redis;
    }

    $redis = new Redis();

    try {
        $connected = @$redis->connect(REDIS_HOST, REDIS_PORT, 1.5);
        if (!$connected) {
            throw new Exception("Redis connection to " . REDIS_HOST . ":" . REDIS_PORT . " failed.");
        }

        // --- AUTHENTICATION FIX ---
        $redisPass = getenv('REDIS_PASS') ?: (defined('REDIS_PASS') ? REDIS_PASS : null);
        if (!empty($redisPass)) {
            if (!$redis->auth($redisPass)) {
                throw new Exception("Redis authentication failed.");
            }
        }

        // --- Validate connection ---
        $pong = $redis->ping();
        if (!in_array($pong, ['+PONG', true, 1], true)) {
            throw new Exception("Redis ping failed (got: " . var_export($pong, true) . ").");
        }

        // --- Set options ---
        $redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
        $redis->setOption(Redis::OPT_PREFIX, 'tc:');
        $redis->setOption(Redis::OPT_READ_TIMEOUT, 1.5);

    } catch (Exception $e) {
        error_log("❌ Redis connection error: " . $e->getMessage(), 3, '/var/www/trench_city/storage/logs/redis_error.log');

        if (defined('DEBUG') && DEBUG) {
            echo "<strong>Redis error:</strong> " . htmlspecialchars($e->getMessage());
        }

        $redis = null;
    }

    return $redis;
}

/**
 * Global helper for Redis
 *
 * @return Redis|null
 */
function redis(): ?Redis
{
    return tc_redis_connect();
}

/**
 * Health check for diagnostics
 *
 * @return bool
 */
function tc_redis_check(): bool
{
    try {
        $r = redis();
        if (!$r) return false;
        $pong = $r->ping();
        return in_array($pong, ['+PONG', true, 1], true);
    } catch (Exception $e) {
        error_log("Redis health check failed: " . $e->getMessage(), 3, '/var/www/trench_city/storage/logs/redis_error.log');
        return false;
    }
}

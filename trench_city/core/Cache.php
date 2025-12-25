<?php
/**
 * ======================================================
 *  TRENCH CITY MODULE: CACHE (v1.0 — Finalized)
 * ======================================================
 *  Hybrid caching engine for Redis + File system.
 *  Features:
 *   ✅ Redis primary cache with file fallback
 *   ✅ Namespaced cache keys (env-aware)
 *   ✅ JSON-safe serialization
 *   ✅ CLI-safe cache control commands
 *   ✅ CorePanel integration ready
 * ======================================================
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

class TCCache
{
    /** @var string */
    private static string $prefix = 'tc:cache:';

    /** @var string */
    private static string $path = '/var/www/trench_city/storage/cache';

    /** @var bool */
    private static bool $useRedis = false;

    /**
     * Initialize cache system
     */
    public static function init(): void
    {
        if (function_exists('tc_redis_connect')) {
            $r = tc_redis_connect();
            if ($r) {
                self::$useRedis = true;
                tc_log('[CACHE] Using Redis backend', 'info');
            }
        }

        if (!is_dir(self::$path)) {
            mkdir(self::$path, 0750, true);
            @chown(self::$path, 'www-data');
        }

        tc_log('[CACHE] Cache system initialized', 'info');
    }

    /**
     * Build key (namespaced)
     */
    private static function key(string $key): string
    {
        $env = defined('APP_ENV') ? APP_ENV : 'dev';
        return self::$prefix . $env . ':' . md5($key);
    }

    /**
     * Set cache value
     */
    public static function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        $key = self::key($key);
        $data = json_encode($value);

        if (self::$useRedis) {
            try {
                $r = tc_redis_connect();
                $r->setex($key, $ttl, $data);
                return true;
            } catch (Throwable $e) {
                tc_log("[CACHE] Redis set failed: {$e->getMessage()}", 'warn');
            }
        }

        // Fallback to file
        $file = self::$path . '/' . md5($key) . '.cache';
        return (bool) file_put_contents($file, json_encode(['expires' => time() + $ttl, 'data' => $data]));
    }

    /**
     * Get cache value
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $key = self::key($key);

        if (self::$useRedis) {
            try {
                $r = tc_redis_connect();
                $val = $r->get($key);
                if ($val !== false) return json_decode($val, true);
            } catch (Throwable $e) {
                tc_log("[CACHE] Redis get failed: {$e->getMessage()}", 'warn');
            }
        }

        // Fallback to file
        $file = self::$path . '/' . md5($key) . '.cache';
        if (!file_exists($file)) return $default;

        $content = json_decode(file_get_contents($file), true);
        if (!$content || ($content['expires'] ?? 0) < time()) {
            @unlink($file);
            return $default;
        }

        return json_decode($content['data'], true);
    }

    /**
     * Delete a cache key
     */
    public static function forget(string $key): bool
    {
        $key = self::key($key);

        if (self::$useRedis) {
            try {
                $r = tc_redis_connect();
                return (bool) $r->del($key);
            } catch (Throwable $e) {
                tc_log("[CACHE] Redis delete failed: {$e->getMessage()}", 'warn');
            }
        }

        $file = self::$path . '/' . md5($key) . '.cache';
        return @unlink($file);
    }

    /**
     * Flush entire cache namespace
     */
    public static function flush(): bool
    {
        $env = defined('APP_ENV') ? APP_ENV : 'dev';
        $prefix = self::$prefix . $env . ':';

        if (self::$useRedis) {
            try {
                $r = tc_redis_connect();
                $keys = $r->keys($prefix . '*');
                foreach ($keys as $k) {
                    $r->del($k);
                }
                tc_log('[CACHE] Redis cache flushed', 'info');
                return true;
            } catch (Throwable $e) {
                tc_log("[CACHE] Redis flush failed: {$e->getMessage()}", 'warn');
            }
        }

        $files = glob(self::$path . '/*.cache');
        foreach ($files as $file) {
            @unlink($file);
        }

        tc_log('[CACHE] File cache flushed', 'info');
        return true;
    }
}

/**
 * ------------------------------------------------------
 *  GLOBAL SHORTCUTS
 * ------------------------------------------------------
 */
if (!function_exists('cache_set')) {
    function cache_set(string $k, mixed $v, int $ttl = 3600): bool { return TCCache::set($k, $v, $ttl); }
}
if (!function_exists('cache_get')) {
    function cache_get(string $k, mixed $d = null): mixed { return TCCache::get($k, $d); }
}
if (!function_exists('cache_forget')) {
    function cache_forget(string $k): bool { return TCCache::forget($k); }
}
if (!function_exists('cache_flush')) {
    function cache_flush(): bool { return TCCache::flush(); }
}

/**
 * ------------------------------------------------------
 *  CLI SUPPORT COMMANDS
 * ------------------------------------------------------
 */
if (php_sapi_name() === 'cli' && isset($argv[1])) {
    $cmd = $argv[1];
    switch ($cmd) {
        case 'cache:get':
            echo json_encode(cache_get($argv[2] ?? ''), JSON_PRETTY_PRINT) . PHP_EOL;
            exit;
        case 'cache:set':
            cache_set($argv[2] ?? '', $argv[3] ?? '', 3600);
            echo "✅ Cache set for {$argv[2]}\n";
            exit;
        case 'cache:clear':
        case 'cache:flush':
            cache_flush();
            echo "🧹 Cache flushed\n";
            exit;
    }
}

/**
 * ------------------------------------------------------
 *  BOOT MESSAGE
 * ------------------------------------------------------
 */
TCCache::init();
tc_log('[MODULE] Cache engine initialized — Redis + File hybrid', 'info');

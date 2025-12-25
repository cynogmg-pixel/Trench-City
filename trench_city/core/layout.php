<?php
/**
 * ======================================================
 *  TRENCH CITY MODULE: INSPECTOR (v1.1 — Runtime Telemetry)
 * ======================================================
 *  System diagnostics and performance telemetry engine.
 * ======================================================
 *  Features:
 *   ✅ CPU, Memory, Disk, and Uptime metrics
 *   ✅ Redis & DB connectivity + latency check
 *   ✅ Module, Cache, Event, and Task stats
 *   ✅ JSON output for CorePanel integration
 *   ✅ CLI support: inspect:core, inspect:db, inspect:tasks, inspect:all
 * ======================================================
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

class TCInspector
{
    public static function core(): array
    {
        return [
            'app' => [
                'name'    => defined('APP_NAME') ? APP_NAME : 'Trench City',
                'version' => defined('APP_VERSION') ? APP_VERSION : 'unknown',
                'env'     => defined('APP_ENV') ? APP_ENV : 'dev',
                'php'     => PHP_VERSION,
                'debug'   => defined('DEBUG') && DEBUG,
            ],
            'system' => [
                'os'       => php_uname('s') . ' ' . php_uname('r'),
                'hostname' => php_uname('n'),
                'memory'   => self::getMemoryUsage(),
                'cpu_load' => self::getCpuLoad(),
                'disk'     => self::getDiskUsage(),
                'uptime'   => self::getUptime(),
            ],
            'modules'   => self::getModules(),
            'timestamp' => date('c'),
        ];
    }

    public static function db(): array
    {
        $dbOk = function_exists('tc_db_check') ? tc_db_check() : false;
        $redisOk = function_exists('tc_redis_check') ? tc_redis_check() : false;
        $redisLatency = null;

        if ($redisOk && function_exists('tc_redis_connect')) {
            try {
                $r = tc_redis_connect();
                $start = microtime(true);
                $r->ping();
                $redisLatency = round((microtime(true) - $start) * 1000, 2);
            } catch (Throwable $e) {
                $redisLatency = 'error';
            }
        }

        return [
            'db' => [
                'connected' => $dbOk,
                'driver' => defined('DB_DRIVER') ? DB_DRIVER : 'unknown',
            ],
            'redis' => [
                'connected' => $redisOk,
                'host' => defined('REDIS_HOST') ? REDIS_HOST : 'unknown',
                'port' => defined('REDIS_PORT') ? REDIS_PORT : 'unknown',
                'latency_ms' => $redisLatency,
            ]
        ];
    }

    public static function tasks(): array
    {
        $stats = [
            'queued' => 0,
            'running' => 0,
            'completed' => 0,
            'events' => [],
        ];

        if (function_exists('task_stats')) {
            $stats = array_merge($stats, task_stats());
        }

        if (class_exists('TCEvent')) {
            if (method_exists('TCEvent', 'registry')) {
                $stats['events'] = TCEvent::registry();
            }
        }

        return $stats;
    }

    public static function all(): array
    {
        return [
            'core'  => self::core(),
            'db'    => self::db(),
            'tasks' => self::tasks(),
        ];
    }

    // ------------------------------------------------------
    // 🔧 Helpers
    // ------------------------------------------------------
    private static function getMemoryUsage(): array
    {
        return [
            'used_mb' => round(memory_get_usage(true) / 1048576, 2),
            'peak_mb' => round(memory_get_peak_usage(true) / 1048576, 2),
        ];
    }

    private static function getCpuLoad(): string
    {
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return implode(', ', array_map(fn($v) => round($v, 2), $load));
        }
        return 'N/A';
    }

    private static function getDiskUsage(): array
    {
        $total = @disk_total_space('/');
        $free  = @disk_free_space('/');
        if ($total === false || $free === false) return ['used_percent' => 'N/A'];
        return [
            'used_percent' => round(($total - $free) / $total * 100, 2),
            'free_gb'      => round($free / 1073741824, 2),
            'total_gb'     => round($total / 1073741824, 2),
        ];
    }

    private static function getUptime(): string
    {
        if (PHP_OS_FAMILY === 'Linux' && file_exists('/proc/uptime')) {
            $uptime = (float) explode(' ', trim(file_get_contents('/proc/uptime')))[0];
            $hours = floor($uptime / 3600);
            $mins = floor(($uptime / 60) % 60);
            return "{$hours}h {$mins}m";
        }
        return 'N/A';
    }

    private static function getModules(): array
    {
        $modules = glob(__DIR__ . '/*.php') ?: [];
        return array_map('basename', $modules);
    }
}

// ------------------------------------------------------
// 🌐 Global Shortcuts (Syntax-Safe)
// ------------------------------------------------------
if (!function_exists('inspect_core')) {
    function inspect_core(): array { return TCInspector::core(); }
}
if (!function_exists('inspect_db')) {
    function inspect_db(): array { return TCInspector::db(); }
}
if (!function_exists('inspect_tasks')) {
    function inspect_tasks(): array { return TCInspector::tasks(); }
}
if (!function_exists('inspect_all')) {
    function inspect_all(): array { return TCInspector::all(); }
}

// ------------------------------------------------------
// 🧠 CLI Commands
// ------------------------------------------------------
if (php_sapi_name() === 'cli' && isset($argv[1])) {
    $cmd = $argv[1];
    switch ($cmd) {
        case 'inspect:core':
            echo json_encode(inspect_core(), JSON_PRETTY_PRINT) . PHP_EOL;
            exit;
        case 'inspect:db':
            echo json_encode(inspect_db(), JSON_PRETTY_PRINT) . PHP_EOL;
            exit;
        case 'inspect:tasks':
            echo json_encode(inspect_tasks(), JSON_PRETTY_PRINT) . PHP_EOL;
            exit;
        case 'inspect:all':
            echo json_encode(inspect_all(), JSON_PRETTY_PRINT) . PHP_EOL;
            exit;
    }
}

// ------------------------------------------------------
// 🚀 Boot Log
// ------------------------------------------------------
tc_log('[MODULE] Inspector initialized — Runtime telemetry active', 'info');


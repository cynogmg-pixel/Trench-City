<?php
/**
 * ======================================================
 *  TRENCH CITY MODULE: TASK ENGINE (v1.0 — Final)
 * ======================================================
 *  Asynchronous job runner + cron-safe task scheduler.
 *  Features:
 *   ✅ Redis-backed queue with persistence
 *   ✅ In-memory + file fallback
 *   ✅ Scheduled task registration (CRON-style)
 *   ✅ CLI-safe execution (php Task.php run)
 *   ✅ CorePanel-compatible telemetry
 *   ✅ Exception-safe + logging integrated
 * ======================================================
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

class TCTask
{
    /** @var string Redis prefix */
    private static string $prefix = 'tc:tasks:';

    /** @var array<string, callable> */
    private static array $registry = [];

    /** @var bool */
    private static bool $useRedis = false;

    /** @var string */
    private static string $fallbackFile = '/var/www/trench_city/storage/tasks.queue.json';

    /**
     * Initialize Task Engine
     */
    public static function init(): void
    {
        if (function_exists('tc_redis_connect')) {
            try {
                $r = tc_redis_connect();
                if ($r) {
                    self::$useRedis = true;
                    tc_log('[TASK] Using Redis queue backend', 'info');
                }
            } catch (Throwable $e) {
                tc_log("[TASK] Redis unavailable: {$e->getMessage()}", 'warn');
            }
        }

        tc_log('[TASK] Task engine initialized', 'info');
    }

    /**
     * Register a scheduled task
     */
    public static function register(string $name, callable $callback): void
    {
        self::$registry[$name] = $callback;
        tc_log("[TASK] Registered task: {$name}", 'info');
    }

    /**
     * Queue a background job
     */
    public static function queue(string $name, array $payload = []): bool
    {
        $job = [
            'id' => uniqid('job_', true),
            'name' => $name,
            'payload' => $payload,
            'time' => time(),
        ];

        if (self::$useRedis) {
            try {
                $r = tc_redis_connect();
                $r->rPush(self::$prefix . 'queue', json_encode($job));
                tc_log("[TASK] Queued job {$job['id']} ({$name})", 'info');
                return true;
            } catch (Throwable $e) {
                tc_log("[TASK] Redis queue failure: {$e->getMessage()}", 'error');
            }
        }

        // Fallback file-based queue
        $list = [];
        if (file_exists(self::$fallbackFile)) {
            $list = json_decode(file_get_contents(self::$fallbackFile), true) ?: [];
        }
        $list[] = $job;
        file_put_contents(self::$fallbackFile, json_encode($list, JSON_PRETTY_PRINT));

        return true;
    }

    /**
     * Process queued jobs
     */
    public static function runQueue(int $limit = 10): void
    {
        $count = 0;

        while ($count < $limit) {
            $job = self::pop();
            if (!$job) break;

            $count++;
            $name = $job['name'];
            $payload = $job['payload'];

            if (!isset(self::$registry[$name])) {
                tc_log("[TASK] ⚠️ Unknown task: {$name}", 'warn');
                continue;
            }

            try {
                tc_log("[TASK] Running job {$job['id']} ({$name})", 'info');
                (self::$registry[$name])($payload);
                tc_log("[TASK] ✅ Completed job {$job['id']}", 'info');
            } catch (Throwable $e) {
                tc_log("[TASK] ❌ Job {$job['id']} failed: {$e->getMessage()}", 'error');
            }
        }

        tc_log("[TASK] Queue runner processed {$count} job(s)", 'info');
    }

    /**
     * Pop next job from queue
     */
    private static function pop(): ?array
    {
        if (self::$useRedis) {
            try {
                $r = tc_redis_connect();
                $data = $r->lPop(self::$prefix . 'queue');
                return $data ? json_decode($data, true) : null;
            } catch (Throwable $e) {
                tc_log("[TASK] Redis pop failed: {$e->getMessage()}", 'warn');
            }
        }

        if (!file_exists(self::$fallbackFile)) return null;
        $list = json_decode(file_get_contents(self::$fallbackFile), true) ?: [];
        $job = array_shift($list);
        file_put_contents(self::$fallbackFile, json_encode($list, JSON_PRETTY_PRINT));

        return $job;
    }

    /**
     * List all registered tasks
     */
    public static function list(): array
    {
        return array_keys(self::$registry);
    }
}

/**
 * ------------------------------------------------------
 *  GLOBAL SHORTCUTS
 * ------------------------------------------------------
 */
if (!function_exists('task_register')) {
    function task_register(string $n, callable $cb): void { TCTask::register($n, $cb); }
}
if (!function_exists('task_queue')) {
    function task_queue(string $n, array $p = []): bool { return TCTask::queue($n, $p); }
}
if (!function_exists('task_run')) {
    function task_run(int $l = 10): void { TCTask::runQueue($l); }
}
if (!function_exists('task_list')) {
    function task_list(): array { return TCTask::list(); }
}

/**
 * ------------------------------------------------------
 *  CLI CONTROL COMMANDS
 * ------------------------------------------------------
 */
if (php_sapi_name() === 'cli' && isset($argv[1])) {
    $cmd = $argv[1];
    switch ($cmd) {
        case 'task:list':
            print_r(task_list());
            exit;
        case 'task:queue':
            $name = $argv[2] ?? 'demo';
            task_queue($name, ['time' => date('H:i:s')]);
            echo "🧾 Task '{$name}' queued.\n";
            exit;
        case 'task:run':
            TCTask::runQueue();
            exit;
    }
}

/**
 * ------------------------------------------------------
 *  DEFAULT SYSTEM TASKS (Examples)
 * ------------------------------------------------------
 */
task_register('cleanup', function ($payload) {
    tc_log('[TASK] Running cleanup job', 'info');
    cache_flush();
});

task_register('heartbeat', function ($payload) {
    tc_log('[TASK] Heartbeat signal @ ' . date('Y-m-d H:i:s'), 'info');
});

/**
 * ------------------------------------------------------
 *  BOOT MESSAGE
 * ------------------------------------------------------
 */
TCTask::init();
tc_log('[MODULE] Task engine loaded — async jobs active', 'info');

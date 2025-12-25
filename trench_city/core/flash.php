<?php
/**
 * ======================================================
 *  TRENCH CITY MODULE: EVENT ENGINE (v1.1 — Fixed)
 * ======================================================
 *  Reactive Event Dispatcher + Pub/Sub Bridge.
 *  Features:
 *   ✅ In-memory + Redis Pub/Sub hybrid
 *   ✅ Async-safe event dispatching
 *   ✅ Dynamic listener registration
 *   ✅ Cross-module signal routing (Router, Task, Auth)
 *   ✅ CLI/Web unified
 *   ✅ CorePanel ready for live telemetry
 * ======================================================
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

class TCEvent
{
    /** @var array<string, callable[]> */
    private static array $listeners = [];

    /** @var bool */
    private static bool $redisEnabled = false;

    /** @var string */
    private static string $redisChannel = 'trenchcity:events';

    /**
     * Initialize the event system
     */
    public static function init(): void
    {
        if (function_exists('tc_redis_connect')) {
            try {
                $r = tc_redis_connect();
                if ($r) {
                    self::$redisEnabled = true;
                    tc_log('[EVENT] Redis Pub/Sub active', 'info');
                }
            } catch (Throwable $e) {
                tc_log("[EVENT] Redis not available: {$e->getMessage()}", 'warn');
            }
        }

        tc_log('[EVENT] Engine initialized', 'info');
    }

    /**
     * Register an event listener
     */
    public static function on(string $event, callable $callback): void
    {
        if (!isset(self::$listeners[$event])) {
            self::$listeners[$event] = [];
        }
        self::$listeners[$event][] = $callback;
        tc_log("[EVENT] Listener attached for {$event}", 'info');
    }

    /**
     * Dispatch an event (sync + async)
     */
    public static function emit(string $event, array $payload = []): void
    {
        tc_log("[EVENT] Dispatching: {$event}", 'info');

        // Local dispatch
        if (isset(self::$listeners[$event])) {
            foreach (self::$listeners[$event] as $callback) {
                try {
                    $callback($payload);
                } catch (Throwable $e) {
                    tc_log("[EVENT] Listener for {$event} failed: {$e->getMessage()}", 'error');
                }
            }
        }

        // Redis Pub/Sub
        if (self::$redisEnabled) {
            try {
                $r = tc_redis_connect();
                $msg = json_encode(['event' => $event, 'payload' => $payload, 'time' => time()]);
                $r->publish(self::$redisChannel, $msg);
            } catch (Throwable $e) {
                tc_log("[EVENT] Redis publish failed: {$e->getMessage()}", 'warn');
            }
        }
    }

    /**
     * Listen for incoming Redis events (blocking)
     */
    public static function listen(): void
    {
        if (!self::$redisEnabled) {
            echo "⚠️  Redis not enabled for event listening.\n";
            return;
        }

        $r = tc_redis_connect();
        $r->subscribe([self::$redisChannel], function ($redis, $chan, $msg) {
            $data = json_decode($msg, true);
            if (!$data) return;

            $event = $data['event'];
            $payload = $data['payload'];
            tc_log("[EVENT] Received: {$event}", 'info');

            if (isset(self::$listeners[$event])) {
                foreach (self::$listeners[$event] as $cb) {
                    try {
                        $cb($payload);
                    } catch (Throwable $e) {
                        tc_log("[EVENT] Redis listener error: {$e->getMessage()}", 'error');
                    }
                }
            }
        });
    }

    /**
     * Broadcast (with optional async task)
     */
    public static function broadcast(string $event, array $payload = [], bool $async = false): void
    {
        if ($async && function_exists('task_queue')) {
            task_queue('event_broadcast', ['event' => $event, 'payload' => $payload]);
            tc_log("[EVENT] Queued async broadcast: {$event}", 'info');
            return;
        }

        self::emit($event, $payload);
    }

    /**
     * List all registered event listeners
     */
    public static function registry(): array
    {
        return array_keys(self::$listeners);
    }
}

/**
 * ------------------------------------------------------
 *  GLOBAL SHORTCUTS (Fixed syntax)
 * ------------------------------------------------------
 */
if (!function_exists('event_on')) {
    function event_on(string $e, callable $cb): void {
        TCEvent::on($e, $cb);
    }
}

if (!function_exists('event_emit')) {
    function event_emit(string $e, array $p = []): void {
        TCEvent::emit($e, $p);
    }
}

if (!function_exists('event_broadcast')) {
    function event_broadcast(string $e, array $p = [], bool $a = false): void {
        TCEvent::broadcast($e, $p, $a);
    }
}

if (!function_exists('event_list')) {
    function event_list(): array {
        return TCEvent::registry();
    }
}

/**
 * ------------------------------------------------------
 *  CLI COMMANDS
 * ------------------------------------------------------
 */
if (php_sapi_name() === 'cli' && isset($argv[1])) {
    $cmd = $argv[1];
    switch ($cmd) {
        case 'event:list':
            print_r(event_list());
            exit;
        case 'event:emit':
            $name = $argv[2] ?? 'demo';
            event_emit($name, ['time' => date('H:i:s')]);
            echo "✅ Event '{$name}' emitted.\n";
            exit;
        case 'event:listen':
            echo "📡 Listening for events on Redis...\n";
            TCEvent::listen();
            exit;
    }
}

/**
 * ------------------------------------------------------
 *  DEFAULT EVENT HOOKS
 * ------------------------------------------------------
 */
event_on('player.join', function ($payload) {
    tc_log("[EVENT] Player joined: {$payload['username']}", 'info');
    if (function_exists('task_queue')) {
        task_queue('welcome', ['user' => $payload['username']]);
    }
});

event_on('world.tick', function ($payload) {
    tc_log('[EVENT] World tick event received.', 'info');
});

/**
 * ------------------------------------------------------
 *  BOOT MESSAGE
 * ------------------------------------------------------
 */
TCEvent::init();
tc_log('[MODULE] Event engine initialized — live signal bus active', 'info');


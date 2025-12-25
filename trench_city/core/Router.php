<?php
/**
 * ======================================================
 *  TRENCH CITY MODULE: ROUTER (v1.3 — Final Stable)
 * ======================================================
 *  Universal routing system for both Web & CLI.
 *  Features:
 *   ✅ HTTP + CLI route dispatch
 *   ✅ Middleware support (global + path-based)
 *   ✅ Secure API handling via CUSTOM_TOKEN
 *   ✅ Auto JSON response for APIs
 *   ✅ Integrated logging + exception protection
 *   ✅ CorePanel integration ready
 * ======================================================
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

class TCRouter
{
    /** @var array<string, callable> */
    private static array $routes = [];

    /** @var array<string, callable> */
    private static array $middlewares = [];

    /** Register a GET route (Web + CLI safe) */
    public static function get(string $path, callable $handler): void
    {
        $path = '/' . trim($path, '/');
        self::$routes["GET $path"] = $handler;
        self::$routes["CLI $path"] = $handler; // Dual registration
    }

    /** Register a POST route */
    public static function post(string $path, callable $handler): void
    {
        $path = '/' . trim($path, '/');
        self::$routes["POST $path"] = $handler;
    }

    /** Register a CLI-only route */
    public static function cli(string $path, callable $handler): void
    {
        $path = '/' . trim($path, '/');
        self::$routes["CLI $path"] = $handler;
    }

    /** Register middleware */
    public static function use(string $path, callable $callback): void
    {
        self::$middlewares[$path] = $callback;
    }

    /** Dispatch current request */
    public static function dispatch(): void
    {
        $isCLI = php_sapi_name() === 'cli';
        $method = $isCLI ? 'CLI' : strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $uri = $isCLI
            ? ($_SERVER['argv'][1] ?? '/')
            : strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
        $uri = '/' . trim($uri, '/');

        // Middleware
        foreach (self::$middlewares as $path => $callback) {
            if (str_starts_with($uri, $path)) {
                try {
                    $callback();
                } catch (Throwable $e) {
                    tc_log("[ROUTER] Middleware error: {$e->getMessage()}", 'error');
                }
            }
        }

        $key = "$method $uri";
        if (isset(self::$routes[$key])) {
            try {
                $handler = self::$routes[$key];
                $result = $handler();

                if ($isCLI) {
                    echo is_string($result)
                        ? $result . PHP_EOL
                        : json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'data' => $result], JSON_PRETTY_PRINT);
                }
                return;
            } catch (Throwable $e) {
                self::respondError($e);
            }
        } else {
            self::respond404($method, $uri);
        }
    }

    /** 404 handler */
    private static function respond404(string $method, string $uri): void
    {
        $msg = "[ROUTER] No route for $method $uri";
        tc_log($msg, 'warn');

        if (php_sapi_name() === 'cli') {
            echo "❌ 404 — No route for $method $uri\n";
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Route not found', 'method' => $method, 'uri' => $uri], JSON_PRETTY_PRINT);
        }
    }

    /** Exception handler */
    private static function respondError(Throwable $e): void
    {
        $msg = "[ROUTER] Exception: {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}";
        tc_log($msg, 'error');

        if (php_sapi_name() === 'cli') {
            echo "❌ Exception: {$e->getMessage()} ({$e->getFile()}:{$e->getLine()})\n";
        } else {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => $e->getMessage(),
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
            ], JSON_PRETTY_PRINT);
        }
    }

    /** Secure API Gateway (requires CUSTOM_TOKEN) */
    public static function secure(callable $callback): void
    {
        $token = $_GET['token'] ?? ($_SERVER['HTTP_X_TRENCH_TOKEN'] ?? '');
        $expected = defined('CUSTOM_TOKEN') ? CUSTOM_TOKEN : null;

        if ($token !== $expected) {
            tc_log('[ROUTER] Unauthorized API access attempt', 'warn');
            if (php_sapi_name() === 'cli') {
                echo "❌ Forbidden — Invalid token\n";
            } else {
                http_response_code(403);
                echo json_encode(['error' => 'Forbidden'], JSON_PRETTY_PRINT);
            }
            exit(1);
        }

        $callback();
    }
}

/**
 * ------------------------------------------------------
 *  GLOBAL SHORTCUTS (Fixed syntax for PHP 8+)
 * ------------------------------------------------------
 */
if (!function_exists('route_get')) {
    function route_get(string $p, callable $h): void { TCRouter::get($p, $h); }
}
if (!function_exists('route_post')) {
    function route_post(string $p, callable $h): void { TCRouter::post($p, $h); }
}
if (!function_exists('route_cli')) {
    function route_cli(string $p, callable $h): void { TCRouter::cli($p, $h); }
}
if (!function_exists('route_use')) {
    function route_use(string $p, callable $h): void { TCRouter::use($p, $h); }
}
if (!function_exists('route_secure')) {
    function route_secure(callable $h): void { TCRouter::secure($h); }
}
if (!function_exists('route_dispatch')) {
    function route_dispatch(): void { TCRouter::dispatch(); }
}

/**
 * ------------------------------------------------------
 *  BOOT MESSAGE
 * ------------------------------------------------------
 */
if (function_exists('tc_log')) {
    tc_log('[MODULE] Router initialized — HTTP/CLI unified', 'info');
}

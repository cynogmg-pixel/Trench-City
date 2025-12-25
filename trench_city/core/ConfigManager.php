<?php
/**
 * ======================================================
 *  TRENCH CITY MODULE: CONFIG MANAGER (v1.0.2 — Safe Include)
 * ======================================================
 *  Unified environment manager with support for both
 *  array-returning and function-based env.php formats.
 * ======================================================
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

// ------------------------------------------------------
// 🧩 Bootstrap Awareness (Safe Standalone Mode)
// ------------------------------------------------------
if (!function_exists('tc_log')) {
    $bootstrap = dirname(__DIR__) . '/bootstrap.php';
    if (file_exists($bootstrap)) {
        require_once $bootstrap;
    } else {
        function tc_log($msg, $level = 'info') {
            $stamp = date('Y-m-d H:i:s');
            echo "[$stamp][$level] $msg\n";
        }
    }
}

class TCConfigManager
{
    private static string $envFile = '/var/www/trench_city/core/env.php';
    private static array $envData = [];

    /**
     * Load or reload environment configuration (safe include).
     */
    public static function load(): array
    {
        if (!file_exists(self::$envFile)) {
            tc_log("[CONFIG] ⚠️ env.php missing — using empty config", 'warn');
            self::$envData = [];
            return self::$envData;
        }

        try {
            // --- Read env.php contents safely
            $content = @file_get_contents(self::$envFile);
            if (!$content) {
                tc_log("[CONFIG] ⚠️ Unable to read env.php", 'warn');
                self::$envData = [];
                return [];
            }

            // --- Attempt to extract config via regex (non-executing)
            if (preg_match_all('/define\s*\(\s*[\'"]([^\'"]+)[\'"]\s*,\s*[\'"]([^\'"]*)[\'"]\s*\)/', $content, $matches)) {
                foreach ($matches[1] as $i => $k) {
                    self::$envData[$k] = $matches[2][$i];
                }
            }

            // --- If file returns an array, safely include
            $tmp = @include self::$envFile;
            if (is_array($tmp)) {
                self::$envData = array_merge(self::$envData, $tmp);
            }

            tc_log("[CONFIG] Loaded environment safely", 'info');
        } catch (Throwable $e) {
            tc_log("[CONFIG] ❌ Load error: {$e->getMessage()}", 'error');
            self::$envData = [];
        }

        return self::$envData;
    }

    /**
     * Save environment data back to env.php as array.
     */
    public static function save(array $data): bool
    {
        $export = var_export($data, true);
        $content = "<?php\nreturn {$export};\n";
        if (@file_put_contents(self::$envFile, $content) === false) {
            tc_log("[CONFIG] ❌ Failed to write env.php", 'error');
            return false;
        }
        @chown(self::$envFile, 'www-data');
        tc_log("[CONFIG] Saved environment file successfully", 'info');
        return true;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::$envData[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        self::$envData[$key] = $value;
        self::save(self::$envData);
    }

    public static function list(): array
    {
        return self::$envData;
    }

    public static function reload(): array
    {
        clearstatcache(true, self::$envFile);
        tc_log("[CONFIG] Reloading env.php ...", 'info');
        return self::load();
    }

    public static function json(): string
    {
        return json_encode(self::$envData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public static function watch(int $interval = 5): void
    {
        $lastModified = file_exists(self::$envFile) ? filemtime(self::$envFile) : 0;
        echo "👁️  Watching env.php for changes (every {$interval}s)...\n";

        while (true) {
            clearstatcache(true, self::$envFile);
            $current = file_exists(self::$envFile) ? filemtime(self::$envFile) : 0;

            if ($current !== $lastModified) {
                $lastModified = $current;
                tc_log("[CONFIG] env.php changed — auto-reloading", 'warn');
                self::reload();
            }

            sleep($interval);
        }
    }
}

// ------------------------------------------------------
// 🌐 Global Shortcuts
// ------------------------------------------------------
if (!function_exists('config_load'))  { function config_load(): array { return TCConfigManager::load(); } }
if (!function_exists('config_reload')) { function config_reload(): array { return TCConfigManager::reload(); } }
if (!function_exists('config_get'))   { function config_get(string $k, mixed $d=null): mixed { return TCConfigManager::get($k, $d); } }
if (!function_exists('config_set'))   { function config_set(string $k, mixed $v): void { TCConfigManager::set($k, $v); } }
if (!function_exists('config_list'))  { function config_list(): array { return TCConfigManager::list(); } }
if (!function_exists('config_json'))  { function config_json(): string { return TCConfigManager::json(); } }

// ------------------------------------------------------
// 🧠 CLI Support
// ------------------------------------------------------
if (php_sapi_name() === 'cli' && isset($argv[1])) {
    $cmd = $argv[1];
    TCConfigManager::load();

    switch ($cmd) {
        case 'reload':
            $data = TCConfigManager::reload();
            echo "✅ Reloaded environment.\n";
            print_r($data);
            break;

        case 'list':
            print_r(TCConfigManager::list());
            break;

        case 'get':
            $key = $argv[2] ?? '';
            echo $key ? (TCConfigManager::get($key) ?? "null") . PHP_EOL : "Usage: php ConfigManager.php get <key>\n";
            break;

        case 'set':
            $key = $argv[2] ?? '';
            $val = $argv[3] ?? '';
            if ($key === '') {
                echo "Usage: php ConfigManager.php set <key> <value>\n";
                break;
            }
            TCConfigManager::set($key, $val);
            echo "✅ Updated {$key} = {$val}\n";
            break;

        case 'watch':
            TCConfigManager::watch();
            break;

        default:
            echo "⚙️  Config Manager Commands:\n";
            echo "  php ConfigManager.php reload     # Reload env.php\n";
            echo "  php ConfigManager.php list       # List all keys\n";
            echo "  php ConfigManager.php get <key>  # Get a key\n";
            echo "  php ConfigManager.php set <k> <v># Set a key\n";
            echo "  php ConfigManager.php watch      # Watch for changes\n";
            break;
    }

    exit;
}

// ------------------------------------------------------
// 🚀 Boot Log
// ------------------------------------------------------
tc_log('[MODULE] ConfigManager initialized — Safe env.php parser ready', 'info');

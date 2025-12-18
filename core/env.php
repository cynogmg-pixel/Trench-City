<?php
/**
 * ======================================================
 *  TRENCH CITY ENVIRONMENT PARSER (v3.1)
 * ======================================================
 *  Loads /var/www/trench_city/.env into an associative array.
 *  Safe for repeated includes - guards against redeclaration.
 * ======================================================
 */

if (!function_exists('load_env')) {
    /**
     * Parse the .env file once and cache values.
     */
    function load_env(?string $path = null): array
    {
        static $cache = null;
        if ($cache !== null) {
            return $cache;
        }

        $envFile = $path
            ?: (getenv('ENV_PATH') ?: dirname(__DIR__) . '/.env');

        if (!file_exists($envFile)) {
            error_log("[ENV] Missing .env file at {$envFile}");
            $cache = [];
            return $cache;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $data = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#') continue;
            if (!str_contains($line, '=')) continue;

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value, " \t\n\r\"'");
            $data[$key] = $value;

            // Keep getenv() in sync for consumers that rely on it.
            putenv("{$key}={$value}");
        }

        $cache = $data;
        return $cache;
    }
}

if (!function_exists('env')) {
    /**
     * Retrieve env value with optional default and .env fallback.
     */
    function env(string $key, $default = null)
    {
        $loaded = load_env();
        if (array_key_exists($key, $loaded)) {
            return $loaded[$key];
        }

        $value = getenv($key);
        return $value !== false ? $value : $default;
    }
}

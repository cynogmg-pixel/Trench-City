<?php
/**
 * ======================================================
 *  TRENCH CITY MODULE: DOCS (v1.2 — Hardened & Bootstrap Safe)
 * ======================================================
 *  Parses PHPDoc comments and builds a unified JSON API
 *  reference for the CorePanel documentation viewer.
 *
 *  Features:
 *   ✅ Scans all PHP files in /core and /core/modules
 *   ✅ Extracts summary, @param, @return, @throws, @example
 *   ✅ Outputs structured JSON at /storage/docs/api.json
 *   ✅ CLI command: php Docs.php generate
 *   ✅ Function: generate_docs()
 *   ✅ Works standalone (auto-bootstrap if needed)
 * ======================================================
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

// ------------------------------------------------------
// 🧩 Ensure Core Context (Auto Bootstrap if needed)
// ------------------------------------------------------
if (!function_exists('tc_log')) {
    $bootstrap = dirname(__DIR__) . '/bootstrap.php';
    if (file_exists($bootstrap)) {
        require_once $bootstrap;
    } else {
        // Minimal fallback logger
        function tc_log($msg, $level = 'info') {
            $stamp = date('Y-m-d H:i:s');
            echo "[$stamp][$level] $msg\n";
        }
    }
}

class TCDocs
{
    private static string $outputPath = '/var/www/trench_city/storage/docs/api.json';
    private static array $docs = [];
    private static int $filesScanned = 0;

    /**
     * Generate documentation for all core and module files.
     */
    public static function generate(): array
    {
        self::$docs = [];
        self::$filesScanned = 0;

        $paths = [
            realpath(__DIR__ . '/..'),  // /core
            realpath(__DIR__),          // /core/modules
        ];

        foreach ($paths as $path) {
            if ($path && is_dir($path)) {
                $files = glob($path . '/*.php');
                foreach ($files as $file) {
                    self::parseFile($file);
                }
            }
        }

        self::saveJson();

        tc_log("[DOCS] Parsed " . self::$filesScanned . " files successfully", 'info');
        return self::$docs;
    }

    /**
     * Parse a single PHP file for PHPDoc comments.
     */
    private static function parseFile(string $file): void
    {
        $content = @file_get_contents($file);
        if (!$content) return;

        preg_match_all('/\/\*\*([\s\S]*?)\*\//', $content, $matches);
        if (empty($matches[1])) return;

        $docs = [];
        foreach ($matches[1] as $block) {
            $doc = self::parseDocBlock($block);
            if (!empty($doc)) $docs[] = $doc;
        }

        if (!empty($docs)) {
            self::$docs[basename($file)] = $docs;
        }

        self::$filesScanned++;
    }

    /**
     * Parse an individual docblock into structured data.
     */
    private static function parseDocBlock(string $block): array
    {
        $lines = array_map('trim', explode("\n", trim($block, "* \t\n\r")));
        $doc = ['summary' => '', 'params' => [], 'return' => '', 'throws' => '', 'example' => ''];

        foreach ($lines as $line) {
            if (preg_match('/^@param\s+([^\s]+)\s+\$([^\s]+)\s*(.*)$/', $line, $m)) {
                $doc['params'][] = [
                    'type' => $m[1],
                    'name' => $m[2],
                    'desc' => $m[3] ?? ''
                ];
            } elseif (preg_match('/^@return\s+([^\s]+)\s*(.*)$/', $line, $m)) {
                $doc['return'] = trim(($m[1] ?? '') . ' ' . ($m[2] ?? ''));
            } elseif (preg_match('/^@throws\s+(.*)$/', $line, $m)) {
                $doc['throws'] = trim($m[1]);
            } elseif (preg_match('/^@example\s+(.*)$/', $line, $m)) {
                $doc['example'] = trim($m[1]);
            } elseif (!str_starts_with($line, '@') && $line !== '') {
                $doc['summary'] .= ($doc['summary'] ? ' ' : '') . trim($line);
            }
        }

        return array_filter($doc);
    }

    /**
     * Save generated docs to JSON file.
     */
    private static function saveJson(): void
    {
        $dir = dirname(self::$outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0750, true);
            @chown($dir, 'www-data');
        }

        $json = json_encode(self::$docs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents(self::$outputPath, $json);

        tc_log('[DOCS] Generated API documentation → ' . self::$outputPath, 'info');
    }
}

// ------------------------------------------------------
// 🌐 Global Shortcut
// ------------------------------------------------------
if (!function_exists('generate_docs')) {
    function generate_docs(): array
    {
        return TCDocs::generate();
    }
}

// ------------------------------------------------------
// 🧠 CLI Mode
// ------------------------------------------------------
if (php_sapi_name() === 'cli' && isset($argv[1]) && $argv[1] === 'generate') {
    echo "📚 Generating API documentation..." . PHP_EOL;
    $data = TCDocs::generate();
    echo "✅ Docs generated successfully (" . count($data) . " files processed)" . PHP_EOL;
    echo "📦 Output: /var/www/trench_city/storage/docs/api.json" . PHP_EOL;
    exit;
}

// ------------------------------------------------------
// 🚀 Boot Log
// ------------------------------------------------------
tc_log('[MODULE] Docs initialized — PHPDoc parser active', 'info');

#!/usr/bin/php
<?php
/**
 * ======================================================
 *  TRENCH CITY CODE AUDITOR (v1.1 POLISHED)
 *  Secure static code scanner for Trench City Core.
 *  Detects syntax errors, dangerous patterns, and
 *  duplicate functions with whitelist & log support.
 * ======================================================
 *  Author: Architect
 *  Updated: 2025-12-08
 */

require_once __DIR__ . '/bootstrap.php';

if (php_sapi_name() !== 'cli') {
    die("This utility must be run via CLI.\n");
}

echo "==============================================\n";
echo "🔍  TRENCH CITY CODE AUDIT\n";
echo "==============================================\n";

$baseDir   = '/var/www/trench_city';
$scanDirs  = ["{$baseDir}/core", "{$baseDir}/public"];
$totalFiles = 0;
$issues = [];
$globalFuncIndex = [];

// ✅ Whitelist of trusted files allowed to use shell_exec, exec, etc.
$whitelist = [
    'core/audit.php',
    'core/security.php',
    'core/helpers_extended.php',
    'core/trenchcity-maintain.php'
];

// ⚠️ Dangerous patterns to scan for
$dangerPatterns = [
    '/\beval\s*\(/i'          => 'Use of eval() — security risk',
    '/\bshell_exec\s*\(/i'    => 'Use of shell_exec() — dangerous',
    '/\bexec\s*\(/i'          => 'Use of exec() — dangerous',
    '/\bsystem\s*\(/i'        => 'Use of system() — dangerous',
    '/\bpopen\s*\(/i'         => 'Use of popen() — dangerous',
    '/\bbase64_decode\s*\(/i' => 'Potential obfuscation',
    '/\binclude\s*\(\s*\$_/i' => 'Dynamic include() from user input',
];

// ------------------------------------------------------
// 1️⃣ Syntax & pattern check
// ------------------------------------------------------
foreach ($scanDirs as $dir) {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($files as $file) {
        if ($file->getExtension() !== 'php') continue;
        $totalFiles++;
        $path = $file->getPathname();
        $relative = str_replace($baseDir . '/', '', $path);

        // 🛑 Skip whitelisted internal files
        if (in_array($relative, $whitelist, true)) {
            continue;
        }

        $content = file_get_contents($path);

        // Syntax check via PHP lint
        $lint = shell_exec("php -l " . escapeshellarg($path) . " 2>&1");
        if (strpos($lint, 'No syntax errors detected') === false) {
            $issues[] = ['type' => 'syntax', 'file' => $path, 'message' => trim($lint)];
        }

        // Dangerous patterns
        foreach ($dangerPatterns as $pattern => $desc) {
            if (preg_match($pattern, $content)) {
                $issues[] = ['type' => 'security', 'file' => $path, 'message' => $desc];
            }
        }

        // Duplicate function detection
        preg_match_all('/function\s+([a-zA-Z0-9_]+)/', $content, $matches);
        foreach ($matches[1] as $func) {
            $globalFuncIndex[$func][] = $path;
        }
    }
}

// ------------------------------------------------------
// 2️⃣ Detect duplicate functions
// ------------------------------------------------------
if (!empty($globalFuncIndex)) {
    foreach ($globalFuncIndex as $func => $locations) {
        $unique = array_unique($locations);
        if (count($unique) > 1) {
            $issues[] = [
                'type' => 'duplicate',
                'file' => implode(', ', $unique),
                'message' => "Function '$func' redeclared"
            ];
        }
    }
}

// ------------------------------------------------------
// 3️⃣ Results Summary
// ------------------------------------------------------
if (empty($issues)) {
    echo "✅ No issues found across {$totalFiles} PHP files.\n";
    tc_log('[AUDIT] Scan clean — no issues found.', 'info');
} else {
    echo "⚠️ Found " . count($issues) . " issue(s) across {$totalFiles} PHP files:\n\n";
    foreach ($issues as $issue) {
        echo strtoupper($issue['type']) . ": {$issue['file']} → {$issue['message']}\n";
        tc_log("[AUDIT] {$issue['type']} in {$issue['file']} → {$issue['message']}", 'warn');
    }
    echo "\n🚨 Review the above issues in /storage/logs/audit.log.\n";
}

// ------------------------------------------------------
// 4️⃣ Summary + Telemetry
// ------------------------------------------------------
$summary = sprintf(
    "[AUDIT SUMMARY] %d file(s) scanned, %d issue(s) found.",
    $totalFiles,
    count($issues)
);
tc_log($summary, empty($issues) ? 'info' : 'warn');

try {
    if (function_exists('redis')) {
        $r = redis();
        if ($r) {
            $r->hMSet('tc:audit:last', [
                'timestamp' => date('Y-m-d H:i:s'),
                'issues'    => count($issues),
                'files'     => $totalFiles
            ]);
        }
    }
} catch (Throwable $t) {
    tc_log("[AUDIT] Redis telemetry failed: " . $t->getMessage(), 'warn');
}

echo "\n✅ Audit Complete (" . date('Y-m-d H:i:s') . ")\n";

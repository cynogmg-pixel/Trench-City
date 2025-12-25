<?php
/**
 * ================================================================
 * SYSTEM HEALTH CHECK
 * Trench City V2
 * ================================================================
 *
 * Usage: php /var/www/trench_city/scripts/health_check.php
 *
 * Checks:
 * - Database connectivity
 * - Required tables exist
 * - File permissions
 * - PHP extensions
 * - Configuration
 */

echo "\n";
echo "================================================================\n";
echo "TRENCH CITY V2 - SYSTEM HEALTH CHECK\n";
echo "================================================================\n\n";

$errors = [];
$warnings = [];
$success = [];

// ================================================================
// 1. PHP VERSION
// ================================================================
echo "[1/10] Checking PHP version... ";
$phpVersion = phpversion();
if (version_compare($phpVersion, '8.1.0', '>=')) {
    $success[] = "PHP version: {$phpVersion}";
    echo "✓\n";
} else {
    $errors[] = "PHP version {$phpVersion} is below minimum 8.1.0";
    echo "✗\n";
}

// ================================================================
// 2. PHP EXTENSIONS
// ================================================================
echo "[2/10] Checking PHP extensions... ";
$requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'json', 'session'];
$missingExtensions = [];

foreach ($requiredExtensions as $ext) {
    if (!extension_loaded($ext)) {
        $missingExtensions[] = $ext;
    }
}

if (empty($missingExtensions)) {
    $success[] = "All required PHP extensions loaded";
    echo "✓\n";
} else {
    $errors[] = "Missing PHP extensions: " . implode(', ', $missingExtensions);
    echo "✗\n";
}

// ================================================================
// 3. ENVIRONMENT FILE
// ================================================================
echo "[3/10] Checking .env file... ";
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    if (is_readable($envPath)) {
        $success[] = ".env file exists and is readable";
        echo "✓\n";
    } else {
        $errors[] = ".env file exists but is not readable";
        echo "✗\n";
    }
} else {
    $errors[] = ".env file not found";
    echo "✗\n";
}

// ================================================================
// 4. DATABASE CONNECTION
// ================================================================
echo "[4/10] Checking database connection... ";
try {
    require_once __DIR__ . '/../core/db.php';
    $db = getDB();
    $result = $db->fetchOne("SELECT 1");
    if ($result) {
        $success[] = "Database connection successful";
        echo "✓\n";
    }
} catch (Exception $e) {
    $errors[] = "Database connection failed: " . $e->getMessage();
    echo "✗\n";
    $db = null;
}

// ================================================================
// 5. DATABASE TABLES
// ================================================================
echo "[5/10] Checking database tables... ";
if ($db) {
    $requiredTables = [
        'users', 'player_stats', 'player_bars', 'player_settings',
        'gyms', 'gym_unlocks', 'training_logs',
        'crimes', 'crime_logs',
        'combat_logs', 'combat_config',
        'bank_transactions', 'bank_config',
        'mail_messages', 'mail_config'
    ];

    $rows = $db->fetchAll("SHOW TABLES");
    $existingTables = array_map(function ($row) {
        return array_values($row)[0] ?? null;
    }, $rows);
    $existingTables = array_filter($existingTables);

    $missingTables = array_diff($requiredTables, $existingTables);

    if (empty($missingTables)) {
        $success[] = "All required database tables exist (" . count($requiredTables) . " tables)";
        echo "✓\n";
    } else {
        $errors[] = "Missing database tables: " . implode(', ', $missingTables);
        echo "✗\n";
    }
} else {
    $warnings[] = "Skipping table check (no database connection)";
    echo "⚠\n";
}

// ================================================================
// 6. FILE PERMISSIONS
// ================================================================
echo "[6/10] Checking file permissions... ";
$writablePaths = [
    __DIR__ . '/../storage/logs',
];

$permissionIssues = [];
foreach ($writablePaths as $path) {
    if (!is_writable($path)) {
        $permissionIssues[] = $path;
    }
}

if (empty($permissionIssues)) {
    $success[] = "All required directories are writable";
    echo "✓\n";
} else {
    $errors[] = "Not writable: " . implode(', ', $permissionIssues);
    echo "✗\n";
}

// ================================================================
// 7. CORE FILES
// ================================================================
echo "[7/10] Checking core files... ";
$coreFiles = [
    __DIR__ . '/../core/bootstrap.php',
    __DIR__ . '/../core/db.php',
    __DIR__ . '/../core/helpers.php',
    __DIR__ . '/../core/Auth.php',
];

$missingFiles = [];
foreach ($coreFiles as $file) {
    if (!file_exists($file)) {
        $missingFiles[] = basename($file);
    }
}

if (empty($missingFiles)) {
    $success[] = "All core files present";
    echo "✓\n";
} else {
    $errors[] = "Missing core files: " . implode(', ', $missingFiles);
    echo "✗\n";
}

// ================================================================
// 8. MODULE FILES
// ================================================================
echo "[8/10] Checking module files... ";
$moduleFiles = [
    __DIR__ . '/../modules/gym/gym_shell.php',
    __DIR__ . '/../modules/crimes/crimes_shell.php',
    __DIR__ . '/../modules/combat/combat_shell.php',
    __DIR__ . '/../modules/bank/bank_shell.php',
    __DIR__ . '/../modules/mail/mail_shell.php',
];

$missingModules = [];
foreach ($moduleFiles as $file) {
    if (!file_exists($file)) {
        $missingModules[] = basename(dirname($file));
    }
}

if (empty($missingModules)) {
    $success[] = "All module files present (5 modules)";
    echo "✓\n";
} else {
    $errors[] = "Missing modules: " . implode(', ', $missingModules);
    echo "✗\n";
}

// ================================================================
// 9. PUBLIC ENTRY POINTS
// ================================================================
echo "[9/10] Checking public entry points... ";
$publicFiles = [
    __DIR__ . '/../public/index.php',
    __DIR__ . '/../public/register.php',
    __DIR__ . '/../public/login.php',
    __DIR__ . '/../public/dashboard.php',
    __DIR__ . '/../public/gym.php',
    __DIR__ . '/../public/crimes.php',
    __DIR__ . '/../public/combat.php',
    __DIR__ . '/../public/bank.php',
    __DIR__ . '/../public/mail.php',
    __DIR__ . '/../public/leaderboards.php',
    __DIR__ . '/../public/profile.php',
];

$missingPublic = [];
foreach ($publicFiles as $file) {
    if (!file_exists($file)) {
        $missingPublic[] = basename($file);
    }
}

if (empty($missingPublic)) {
    $success[] = "All public entry points present (" . count($publicFiles) . " files)";
    echo "✓\n";
} else {
    $errors[] = "Missing public files: " . implode(', ', $missingPublic);
    echo "✗\n";
}

// ================================================================
// 10. SYSTEM STATISTICS
// ================================================================
echo "[10/10] Gathering system statistics... ";
if ($db) {
    try {
        $stats = [];

        $stats = [];
        $row = $db->fetchOne("SELECT COUNT(*) as total FROM users WHERE status = 'active'");
        $stats['active_users'] = (int)($row['total'] ?? 0);

        $row = $db->fetchOne("SELECT COUNT(*) as total FROM combat_logs");
        $stats['total_fights'] = (int)($row['total'] ?? 0);

        $row = $db->fetchOne("SELECT COUNT(*) as total FROM crime_logs");
        $stats['total_crimes'] = (int)($row['total'] ?? 0);

        $row = $db->fetchOne("SELECT COUNT(*) as total FROM training_logs");
        $stats['total_training'] = (int)($row['total'] ?? 0);

        $row = $db->fetchOne("SELECT COUNT(*) as total FROM mail_messages WHERE is_deleted_by_sender = 0 OR is_deleted_by_recipient = 0");
        $stats['total_messages'] = (int)($row['total'] ?? 0);

        $success[] = "System statistics gathered";
        echo "✓\n";
    } catch (Exception $e) {
        $warnings[] = "Could not gather statistics: " . $e->getMessage();
        echo "⚠\n";
    }
} else {
    $warnings[] = "Skipping statistics (no database connection)";
    echo "⚠\n";
}

// ================================================================
// RESULTS
// ================================================================
echo "\n";
echo "================================================================\n";
echo "HEALTH CHECK RESULTS\n";
echo "================================================================\n\n";

if (!empty($success)) {
    echo "✓ SUCCESS (" . count($success) . "):\n";
    foreach ($success as $msg) {
        echo "  • {$msg}\n";
    }
    echo "\n";
}

if (!empty($warnings)) {
    echo "⚠ WARNINGS (" . count($warnings) . "):\n";
    foreach ($warnings as $msg) {
        echo "  • {$msg}\n";
    }
    echo "\n";
}

if (!empty($errors)) {
    echo "✗ ERRORS (" . count($errors) . "):\n";
    foreach ($errors as $msg) {
        echo "  • {$msg}\n";
    }
    echo "\n";
}

// ================================================================
// SYSTEM STATISTICS
// ================================================================
if (isset($stats)) {
    echo "================================================================\n";
    echo "SYSTEM STATISTICS\n";
    echo "================================================================\n\n";
    echo "Active Players:    " . number_format($stats['active_users']) . "\n";
    echo "Total Fights:      " . number_format($stats['total_fights']) . "\n";
    echo "Total Crimes:      " . number_format($stats['total_crimes']) . "\n";
    echo "Training Sessions: " . number_format($stats['total_training']) . "\n";
    echo "Mail Messages:     " . number_format($stats['total_messages']) . "\n";
    echo "\n";
}

// ================================================================
// FINAL STATUS
// ================================================================
echo "================================================================\n";
if (empty($errors)) {
    echo "STATUS: ✓ ALL SYSTEMS OPERATIONAL\n";
    echo "================================================================\n\n";
    exit(0);
} else {
    echo "STATUS: ✗ ISSUES DETECTED - PLEASE FIX ERRORS ABOVE\n";
    echo "================================================================\n\n";
    exit(1);
}


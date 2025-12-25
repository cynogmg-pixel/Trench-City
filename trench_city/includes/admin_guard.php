<?php
if (!defined('TRENCH_CITY')) {
    define('TRENCH_CITY', true);
}

if (!function_exists('tc_admin_user_columns')) {
    function tc_admin_user_columns($db): array
    {
        static $columns = null;
        if ($columns !== null) {
            return $columns;
        }

        $columns = [];
        if (!$db) {
            return $columns;
        }

        try {
            $rows = $db->fetchAll("SHOW COLUMNS FROM users");
        } catch (Throwable $e) {
            return $columns;
        }

        foreach ($rows as $row) {
            if (!empty($row['Field'])) {
                $columns[] = $row['Field'];
            }
        }

        return $columns;
    }
}

if (!function_exists('tc_admin_user_has_column')) {
    function tc_admin_user_has_column($db, string $column): bool
    {
        $columns = tc_admin_user_columns($db);
        return in_array($column, $columns, true);
    }
}

if (!function_exists('tc_admin_list_tables')) {
    function tc_admin_list_tables($db): array
    {
        static $tables = null;
        if ($tables !== null) {
            return $tables;
        }

        $tables = [];
        if (!$db) {
            return $tables;
        }

        try {
            $rows = $db->fetchAll("SHOW TABLES");
        } catch (Throwable $e) {
            return $tables;
        }

        foreach ($rows as $row) {
            $values = array_values($row);
            if (!empty($values[0])) {
                $tables[] = $values[0];
            }
        }

        return $tables;
    }
}

if (!function_exists('tc_admin_table_exists')) {
    function tc_admin_table_exists($db, string $table): bool
    {
        return in_array($table, tc_admin_list_tables($db), true);
    }
}

if (!function_exists('tc_admin_table_columns')) {
    function tc_admin_table_columns($db, string $table): array
    {
        static $cache = [];
        if (isset($cache[$table])) {
            return $cache[$table];
        }

        $cache[$table] = [];
        if (!$db || !tc_admin_table_exists($db, $table)) {
            return $cache[$table];
        }

        try {
            $rows = $db->fetchAll("SHOW COLUMNS FROM `{$table}`");
        } catch (Throwable $e) {
            return $cache[$table];
        }

        foreach ($rows as $row) {
            if (!empty($row['Field'])) {
                $cache[$table][] = $row['Field'];
            }
        }

        return $cache[$table];
    }
}

if (!function_exists('tc_admin_table_has_column')) {
    function tc_admin_table_has_column($db, string $table, string $column): bool
    {
        return in_array($column, tc_admin_table_columns($db, $table), true);
    }
}

$adminDebug = isset($_GET['admin_debug']) && $_GET['admin_debug'] === '1';
$adminPassword = 'William0304!';
$adminSessionKey = 'owner_panel_unlocked';

if (!function_exists('tc_admin_debug_exit')) {
    function tc_admin_debug_exit(array $data, int $code = 403): void
    {
        http_response_code($code);
        echo "<div style='font-family: Arial, sans-serif; padding: 20px; color: #111;'>\n";
        echo "<h2>Admin Guard Debug</h2>\n";
        foreach ($data as $label => $value) {
            $safeLabel = htmlspecialchars((string)$label, ENT_QUOTES, 'UTF-8');
            $safeValue = htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
            echo "<p><strong>{$safeLabel}:</strong> {$safeValue}</p>\n";
        }
        echo "</div>\n";
        exit;
    }
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userId = null;
if (function_exists('currentUserId')) {
    $userId = currentUserId();
} else {
    $userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
}

$db = null;
if (function_exists('getDB')) {
    $db = getDB();
}
if (!$db && isset($GLOBALS['db'])) {
    $db = $GLOBALS['db'];
}

$admin_user = null;
$adminEmailRaw = '';
if ($db && $userId) {
    $columns = tc_admin_user_columns($db);
    $fields = ['id', 'email'];

    if (in_array('email_verified', $columns, true)) {
        $fields[] = 'email_verified';
    }

    $roleColumns = ['is_admin', 'admin', 'role', 'user_role', 'user_type'];
    foreach ($roleColumns as $column) {
        if (in_array($column, $columns, true)) {
            $fields[] = $column;
        }
    }

    $select = implode(', ', $fields);

    try {
        $admin_user = $db->fetchOne(
            "SELECT {$select} FROM users WHERE id = :id LIMIT 1",
            ['id' => (int)$userId]
        );
    } catch (Throwable $e) {
        $admin_user = null;
    }
}

$ownerEmail = 'admin@trenchmade.co.uk';
$adminEmailRaw = is_array($admin_user) ? (string)($admin_user['email'] ?? '') : '';
$adminEmail = strtolower(trim($adminEmailRaw));
$passwordAllowed = isset($_SESSION[$adminSessionKey]) && $_SESSION[$adminSessionKey] === true;

if (!$passwordAllowed) {
    $passwordError = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['owner_password'])) {
        if (!csrf_check($_POST['csrf_token'] ?? '')) {
            $passwordError = 'Invalid security token.';
        } elseif (!hash_equals($adminPassword, (string)($_POST['owner_password'] ?? ''))) {
            $passwordError = 'Incorrect password.';
        } else {
            $_SESSION[$adminSessionKey] = true;
            $passwordAllowed = true;
        }
    }

    if ($passwordAllowed) {
        return;
    }

    if ($adminDebug) {
        tc_admin_debug_exit([
            'Reason' => 'Password required',
            'User ID' => $userId ?: 'guest',
            'Email from DB' => $adminEmailRaw !== '' ? $adminEmailRaw : 'missing',
            'Expected owner email' => $ownerEmail,
        ]);
    }
    $safeError = htmlspecialchars($passwordError, ENT_QUOTES, 'UTF-8');
    echo "<!doctype html>\n";
    echo "<html lang='en'>\n";
    echo "<head>\n";
    echo "<meta charset='UTF-8'>\n";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
    echo "<title>Owner Panel Access</title>\n";
    echo "<link rel='stylesheet' href='/assets/css/global.css'>\n";
    echo "</head>\n";
    echo "<body class='tc-app'>\n";
    echo "<div class='tc-app-shell' style='min-height: 100vh; display: flex; align-items: center; justify-content: center;'>\n";
    echo "<div class='tc-card' style='max-width: 420px; width: 100%; padding: 2rem;'>\n";
    echo "<h1 class='tc-page-title' style='margin-top: 0;'>Owner Panel</h1>\n";
    echo "<p style='color: #9CA3AF; margin-bottom: 1.5rem;'>Enter the owner password to continue.</p>\n";
    if ($safeError !== '') {
        echo "<div class='alert alert-warning' style='margin-bottom: 1rem;'>\n";
        echo "<div class='alert-content'><div class='alert-message'>{$safeError}</div></div>\n";
        echo "</div>\n";
    }
    echo "<form method='post' action=''>\n";
    echo "<input type='hidden' name='csrf_token' value='" . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . "'>\n";
    echo "<label style='display: grid; gap: 0.5rem;'>\n";
    echo "<span style='color: #9CA3AF;'>Owner Password</span>\n";
    echo "<input type='password' name='owner_password' required style='padding: 0.75rem 1rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB; font-size: 0.95rem;'>\n";
    echo "</label>\n";
    echo "<button class='btn btn-primary' type='submit' style='margin-top: 1rem;'>Unlock</button>\n";
    echo "</form>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "</body>\n";
    echo "</html>\n";
    exit;
}

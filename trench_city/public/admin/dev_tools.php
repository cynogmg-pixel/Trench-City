
<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);
$messages = [];
$errors = [];

function tc_dev_tables($db): array
{
    if (!$db) {
        return [];
    }

    try {
        $rows = $db->fetchAll('SHOW TABLES');
    } catch (Throwable $e) {
        return [];
    }

    $tables = [];
    foreach ($rows as $row) {
        $values = array_values($row);
        if (!empty($values[0])) {
            $tables[] = $values[0];
        }
    }

    sort($tables);
    return $tables;
}

function tc_dev_table_exists(array $tables, string $table): bool
{
    return in_array($table, $tables, true);
}

function tc_dev_table_columns($db, string $table): array
{
    if (!$db) {
        return [];
    }

    try {
        $rows = $db->fetchAll("SHOW COLUMNS FROM `{$table}`");
    } catch (Throwable $e) {
        return [];
    }

    $columns = [];
    foreach ($rows as $row) {
        if (!empty($row['Field'])) {
            $columns[] = $row['Field'];
        }
    }

    return $columns;
}

function tc_dev_parse_schema_columns(array $paths): array
{
    $expected = [];

    foreach ($paths as $path) {
        if (!is_readable($path)) {
            continue;
        }

        $sql = file_get_contents($path);
        if ($sql === false) {
            continue;
        }

        if (preg_match_all('/CREATE TABLE IF NOT EXISTS\s+`?(\w+)`?\s*\((.*?)\)\s*ENGINE/si', $sql, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $table = $match[1];
                $body = $match[2];
                $lines = preg_split('/\r?\n/', $body);
                foreach ($lines as $line) {
                    $line = trim($line);
                    $line = rtrim($line, ',');
                    if ($line === '') {
                        continue;
                    }
                    if (preg_match('/^(PRIMARY|UNIQUE|KEY|CONSTRAINT|INDEX)/i', $line)) {
                        continue;
                    }
                    if (preg_match('/^`?(\w+)`?\s+/', $line, $colMatch)) {
                        $expected[$table][] = $colMatch[1];
                    }
                }
            }
        }

        if (preg_match_all('/ALTER TABLE\s+`?(\w+)`?\s+ADD COLUMN IF NOT EXISTS\s+`?(\w+)`?/i', $sql, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $table = $match[1];
                $column = $match[2];
                $expected[$table][] = $column;
            }
        }
    }

    foreach ($expected as $table => $columns) {
        $expected[$table] = array_values(array_unique($columns));
        sort($expected[$table]);
    }

    return $expected;
}
$tables = tc_dev_tables($db);

$customLinksFile = defined('STORAGE_PATH')
    ? STORAGE_PATH . '/custom_sidebar_links.json'
    : __DIR__ . '/../../storage/custom_sidebar_links.json';

$checklistFile = defined('STORAGE_PATH')
    ? STORAGE_PATH . '/feature_checklist.json'
    : __DIR__ . '/../../storage/feature_checklist.json';

$sqlWriteToken = $_SESSION['sql_write_token'] ?? null;
if (!$sqlWriteToken) {
    $sqlWriteToken = bin2hex(random_bytes(8));
    $_SESSION['sql_write_token'] = $sqlWriteToken;
}

$selectedTable = isset($_GET['table']) ? trim($_GET['table']) : '';
$tableColumns = [];
$tableRows = [];

if ($selectedTable !== '' && tc_dev_table_exists($tables, $selectedTable)) {
    $tableColumns = tc_dev_table_columns($db, $selectedTable);
    try {
        $tableRows = $db ? $db->fetchAll("SELECT * FROM `{$selectedTable}` LIMIT 25") : [];
    } catch (Throwable $e) {
        $tableRows = [];
    }
}

$action = $_POST['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token.';
    } else {
        if ($action === 'create_module') {
            $rawName = trim($_POST['module_name'] ?? '');
            $module = strtolower(preg_replace('/[^a-z0-9_]/', '', $rawName));
            $label = trim($_POST['module_label'] ?? '');
            $icon = trim($_POST['module_icon'] ?? '');

            if ($module === '') {
                $errors[] = 'Module name is required (letters, numbers, underscore).';
            } else {
                $label = $label !== '' ? $label : ucwords(str_replace('_', ' ', $module));
                $icon = $icon !== '' ? $icon : '/assets/imgs/icons_32/contracts.PNG';

                $publicFile = __DIR__ . '/../' . $module . '.php';
                $moduleDir = __DIR__ . '/../../modules/' . $module;
                $shellFile = $moduleDir . '/' . $module . '_shell.php';
                $navFile = $moduleDir . '/' . $module . '_nav.php';

                if (file_exists($publicFile) || file_exists($shellFile)) {
                    $errors[] = 'Module files already exist.';
                } else {
                    if (!is_dir($moduleDir)) {
                        @mkdir($moduleDir, 0750, true);
                    }

                    $publicContent = "<?php\n"
                        . "require_once __DIR__ . '/../core/bootstrap.php';\n"
                        . "requireLogin();\n\n"
                        . "require_once __DIR__ . '/../modules/{$module}/{$module}_shell.php';\n";

                    $shellContent = "<?php\n"
                        . "require_once __DIR__ . '/../../core/bootstrap.php';\n"
                        . "requireLogin();\n\n"
                        . "\$tc_page_title = '{$label} - Trench City';\n"
                        . "include __DIR__ . '/../../includes/tc_header.php';\n"
                        . "tcRenderPageStart(['mode' => 'postlogin']);\n"
                        . "include __DIR__ . '/{$module}_nav.php';\n"
                        . "?>\n\n"
                        . "<div class=\"main-content\">\n"
                        . "    <div class=\"content-wrapper\">\n"
                        . "        <div class=\"content-header\">\n"
                        . "            <h1 class=\"content-title\">{$label}</h1>\n"
                        . "            <p class=\"content-description\">Module shell generated.</p>\n"
                        . "        </div>\n\n"
                        . "        <?php if (!empty(\$module_nav) && is_array(\$module_nav)): ?>\n"
                        . "            <div class=\"tc-card\" style=\"margin: 1.5rem 0;\">\n"
                        . "                <div style=\"display: flex; flex-wrap: wrap; gap: 0.75rem;\">\n"
                        . "                    <?php foreach (\$module_nav as \$link): ?>\n"
                        . "                        <a class=\"btn btn-secondary btn-sm\" href=\"<?php echo htmlspecialchars(\$link['href'], ENT_QUOTES, 'UTF-8'); ?>\">\n"
                        . "                            <?php echo htmlspecialchars(\$link['label'], ENT_QUOTES, 'UTF-8'); ?>\n"
                        . "                        </a>\n"
                        . "                    <?php endforeach; ?>\n"
                        . "                </div>\n"
                        . "            </div>\n"
                        . "        <?php endif; ?>\n\n"
                        . "        <div class=\"tc-card\">\n"
                        . "            <div style=\"padding: 1.5rem;\">\n"
                        . "                <p style=\"color: #D1D5DB; margin: 0;\">Start building the module here.</p>\n"
                        . "            </div>\n"
                        . "        </div>\n"
                        . "    </div>\n"
                        . "</div>\n\n"
                        . "<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>\n";

                    $navContent = "<?php\n"
                        . "\$module_nav = [\n"
                        . "    ['label' => 'Overview', 'href' => '/{$module}.php', 'page' => '{$module}'],\n"
                        . "];\n"
                        . "?>\n";

                    $writeOk = @file_put_contents($publicFile, $publicContent) !== false;
                    $writeOk = $writeOk && (@file_put_contents($shellFile, $shellContent) !== false);
                    $writeOk = $writeOk && (@file_put_contents($navFile, $navContent) !== false);

                    if ($writeOk) {
                        $links = [];
                        if (is_readable($customLinksFile)) {
                            $data = json_decode(file_get_contents($customLinksFile), true);
                            if (is_array($data)) {
                                $links = $data;
                            }
                        }

                        $linkEntry = [
                            'label' => $label,
                            'href' => '/' . $module . '.php',
                            'page' => $module,
                            'icon' => $icon,
                        ];

                        $exists = false;
                        foreach ($links as $existing) {
                            if (is_array($existing) && ($existing['href'] ?? '') === $linkEntry['href']) {
                                $exists = true;
                                break;
                            }
                        }

                        if (!$exists) {
                            $links[] = $linkEntry;
                            @file_put_contents($customLinksFile, json_encode($links, JSON_PRETTY_PRINT));
                        }

                        $messages[] = 'Module shell created.';
                    } else {
                        $errors[] = 'Failed to write module files.';
                    }
                }
            }
        }
        if ($action === 'create_test_users') {
            if (!$db) {
                $errors[] = 'Database connection unavailable.';
            } else {
                $count = max(1, min(50, (int)($_POST['user_count'] ?? 1)));
                $baseName = strtolower(preg_replace('/[^a-z0-9_]/', '', trim($_POST['user_base'] ?? 'testuser')));
                $domain = trim($_POST['user_domain'] ?? 'example.com');
                $password = (string)($_POST['user_password'] ?? 'Test1234!');

                if ($baseName === '' || $domain === '') {
                    $errors[] = 'Provide a base username and email domain.';
                } else {
                    $userCols = tc_dev_table_columns($db, 'users');
                    if (!in_array('username', $userCols, true) || !in_array('email', $userCols, true) || !in_array('password_hash', $userCols, true)) {
                        $errors[] = 'Users table missing required columns.';
                    } else {
                        $created = 0;
                        for ($i = 1; $i <= $count; $i++) {
                            $username = $baseName . $i;
                            $email = $username . '@' . $domain;
                            $hash = function_exists('tc_hash') ? tc_hash($password) : password_hash($password, PASSWORD_BCRYPT);

                            $cols = ['username', 'email', 'password_hash'];
                            $params = [
                                'username' => $username,
                                'email' => $email,
                                'password_hash' => $hash,
                            ];

                            if (in_array('status', $userCols, true)) {
                                $cols[] = 'status';
                                $params['status'] = 'active';
                            }
                            if (in_array('xp', $userCols, true)) {
                                $cols[] = 'xp';
                                $params['xp'] = 0;
                            }
                            if (in_array('level', $userCols, true)) {
                                $cols[] = 'level';
                                $params['level'] = 1;
                            }
                            if (in_array('cash', $userCols, true)) {
                                $cols[] = 'cash';
                                $params['cash'] = 0;
                            }
                            if (in_array('bank_balance', $userCols, true)) {
                                $cols[] = 'bank_balance';
                                $params['bank_balance'] = 0;
                            }

                            $columnsSql = implode(', ', $cols);
                            $placeholders = ':' . implode(', :', $cols);

                            try {
                                $db->execute("INSERT INTO users ({$columnsSql}) VALUES ({$placeholders})", $params);
                                $created++;
                                $newId = method_exists($db, 'lastInsertId') ? (int)$db->lastInsertId() : null;

                                if ($newId) {
                                    if (tc_dev_table_exists($tables, 'player_stats')) {
                                        $db->execute("INSERT IGNORE INTO player_stats (user_id) VALUES (:user_id)", ['user_id' => $newId]);
                                    }
                                    if (tc_dev_table_exists($tables, 'player_bars')) {
                                        $db->execute("INSERT IGNORE INTO player_bars (user_id) VALUES (:user_id)", ['user_id' => $newId]);
                                    }
                                    if (tc_dev_table_exists($tables, 'player_settings')) {
                                        $db->execute("INSERT IGNORE INTO player_settings (user_id) VALUES (:user_id)", ['user_id' => $newId]);
                                    }
                                }
                            } catch (Throwable $e) {
                                continue;
                            }
                        }

                        $messages[] = "Created {$created} test users.";
                    }
                }
            }
        }

        if ($action === 'starter_pack') {
            if (!$db) {
                $errors[] = 'Database connection unavailable.';
            } else {
                $targetId = (int)($_POST['starter_user_id'] ?? 0);
                $cash = (int)($_POST['starter_cash'] ?? 10000);
                $bank = (int)($_POST['starter_bank'] ?? 5000);
                $xp = (int)($_POST['starter_xp'] ?? 1000);
                $itemsCount = max(0, (int)($_POST['starter_items'] ?? 3));

                if ($targetId <= 0) {
                    $errors[] = 'Enter a valid user id.';
                } else {
                    $userCols = tc_dev_table_columns($db, 'users');
                    $updates = [];
                    $params = ['id' => $targetId];
                    if (in_array('cash', $userCols, true)) {
                        $updates[] = 'cash = cash + :cash';
                        $params['cash'] = $cash;
                    }
                    if (in_array('bank_balance', $userCols, true)) {
                        $updates[] = 'bank_balance = bank_balance + :bank';
                        $params['bank'] = $bank;
                    }
                    if (in_array('xp', $userCols, true)) {
                        $updates[] = 'xp = xp + :xp';
                        $params['xp'] = $xp;
                    }
                    if (in_array('level', $userCols, true) && function_exists('calculateLevel') && in_array('xp', $userCols, true)) {
                        $userRow = $db->fetchOne("SELECT xp FROM users WHERE id = :id LIMIT 1", ['id' => $targetId]);
                        $newXp = (int)($userRow['xp'] ?? 0) + $xp;
                        $updates[] = 'level = :level';
                        $params['level'] = calculateLevel($newXp);
                    }

                    if ($updates) {
                        $db->execute("UPDATE users SET " . implode(', ', $updates) . " WHERE id = :id", $params);
                    }

                    if ($itemsCount > 0) {
                        if (tc_dev_table_exists($tables, 'items') && tc_dev_table_exists($tables, 'user_items')) {
                            $items = $db->fetchAll("SELECT id FROM items ORDER BY id ASC LIMIT {$itemsCount}");
                            foreach ($items as $item) {
                                $itemId = (int)($item['id'] ?? 0);
                                if ($itemId <= 0) continue;
                                $existing = $db->fetchOne("SELECT id, qty FROM user_items WHERE user_id = :uid AND item_id = :item LIMIT 1", [
                                    'uid' => $targetId,
                                    'item' => $itemId,
                                ]);
                                if ($existing) {
                                    $db->execute("UPDATE user_items SET qty = qty + 1 WHERE id = :id", ['id' => $existing['id']]);
                                } else {
                                    $db->execute("INSERT INTO user_items (user_id, item_id, qty) VALUES (:uid, :item, 1)", [
                                        'uid' => $targetId,
                                        'item' => $itemId,
                                    ]);
                                }
                            }
                        } elseif (tc_dev_table_exists($tables, 'market_items') && tc_dev_table_exists($tables, 'user_inventory')) {
                            $items = $db->fetchAll("SELECT id FROM market_items ORDER BY id ASC LIMIT {$itemsCount}");
                            foreach ($items as $item) {
                                $itemId = (int)($item['id'] ?? 0);
                                if ($itemId <= 0) continue;
                                $existing = $db->fetchOne("SELECT id, quantity FROM user_inventory WHERE user_id = :uid AND item_id = :item LIMIT 1", [
                                    'uid' => $targetId,
                                    'item' => $itemId,
                                ]);
                                if ($existing) {
                                    $db->execute("UPDATE user_inventory SET quantity = quantity + 1 WHERE id = :id", ['id' => $existing['id']]);
                                } else {
                                    $db->execute("INSERT INTO user_inventory (user_id, item_id, quantity) VALUES (:uid, :item, 1)", [
                                        'uid' => $targetId,
                                        'item' => $itemId,
                                    ]);
                                }
                            }
                        }
                    }

                    $messages[] = 'Starter pack applied.';
                }
            }
        }
        if ($action === 'spawn_item') {
            if (!$db) {
                $errors[] = 'Database connection unavailable.';
            } else {
                $targetId = (int)($_POST['spawn_user_id'] ?? 0);
                $itemId = (int)($_POST['spawn_item_id'] ?? 0);
                $qty = max(1, (int)($_POST['spawn_qty'] ?? 1));
                $source = $_POST['spawn_source'] ?? 'items';

                if ($targetId <= 0 || $itemId <= 0) {
                    $errors[] = 'Enter valid user and item ids.';
                } else {
                    if ($source === 'items' && tc_dev_table_exists($tables, 'items') && tc_dev_table_exists($tables, 'user_items')) {
                        $existing = $db->fetchOne("SELECT id, qty FROM user_items WHERE user_id = :uid AND item_id = :item LIMIT 1", [
                            'uid' => $targetId,
                            'item' => $itemId,
                        ]);
                        if ($existing) {
                            $db->execute("UPDATE user_items SET qty = qty + :qty WHERE id = :id", [
                                'qty' => $qty,
                                'id' => $existing['id'],
                            ]);
                        } else {
                            $db->execute("INSERT INTO user_items (user_id, item_id, qty) VALUES (:uid, :item, :qty)", [
                                'uid' => $targetId,
                                'item' => $itemId,
                                'qty' => $qty,
                            ]);
                        }
                        $messages[] = 'Item spawned.';
                    } elseif ($source === 'market' && tc_dev_table_exists($tables, 'market_items') && tc_dev_table_exists($tables, 'user_inventory')) {
                        $existing = $db->fetchOne("SELECT id, quantity FROM user_inventory WHERE user_id = :uid AND item_id = :item LIMIT 1", [
                            'uid' => $targetId,
                            'item' => $itemId,
                        ]);
                        if ($existing) {
                            $db->execute("UPDATE user_inventory SET quantity = quantity + :qty WHERE id = :id", [
                                'qty' => $qty,
                                'id' => $existing['id'],
                            ]);
                        } else {
                            $db->execute("INSERT INTO user_inventory (user_id, item_id, quantity) VALUES (:uid, :item, :qty)", [
                                'uid' => $targetId,
                                'item' => $itemId,
                                'qty' => $qty,
                            ]);
                        }
                        $messages[] = 'Item spawned.';
                    } else {
                        $errors[] = 'Item source tables not available.';
                    }
                }
            }
        }

        if ($action === 'fill_market') {
            if (!$db) {
                $errors[] = 'Database connection unavailable.';
            } else {
                if (tc_dev_table_exists($tables, 'market_items')) {
                    $db->execute("UPDATE market_items SET is_active = 1 WHERE is_active <> 1");
                    $db->execute("UPDATE market_items SET stock_quantity = 100 WHERE stock_quantity IS NOT NULL");
                    $messages[] = 'Market stock refilled.';
                } else {
                    $errors[] = 'market_items table not found.';
                }
            }
        }

        if ($action === 'sql_runner') {
            if (!$db) {
                $errors[] = 'Database connection unavailable.';
            } else {
                $sql = trim($_POST['sql_query'] ?? '');
                $mode = $_POST['sql_mode'] ?? 'read';
                $confirmToken = trim($_POST['sql_confirm_token'] ?? '');
                $confirmPhrase = trim($_POST['sql_confirm_phrase'] ?? '');

                if ($sql === '') {
                    $errors[] = 'SQL query is required.';
                } else {
                    $statements = array_values(array_filter(array_map('trim', explode(';', $sql))));
                    if (count($statements) > 1) {
                        $errors[] = 'Only one SQL statement is allowed.';
                    } else {
                        $sql = $statements[0];
                        $isRead = preg_match('/^(SELECT|SHOW|DESCRIBE|EXPLAIN)\b/i', $sql) === 1;

                        if ($mode === 'read') {
                            if (!$isRead) {
                                $errors[] = 'Read-only mode only allows SELECT/SHOW/DESCRIBE/EXPLAIN.';
                            } else {
                                if (preg_match('/^SELECT\b/i', $sql) && !preg_match('/\bLIMIT\b/i', $sql)) {
                                    $sql .= ' LIMIT 200';
                                }
                                try {
                                    $sqlResults = $db->fetchAll($sql);
                                    $messages[] = 'Query executed.';
                                } catch (Throwable $e) {
                                    $errors[] = 'Query failed.';
                                }
                            }
                        } else {
                            if ($confirmToken !== $sqlWriteToken || $confirmPhrase !== 'I UNDERSTAND') {
                                $errors[] = 'Write mode confirmation failed.';
                            } else {
                                try {
                                    $affected = $db->execute($sql);
                                    $messages[] = "Statement executed. Rows affected: {$affected}.";
                                } catch (Throwable $e) {
                                    $errors[] = 'Statement failed.';
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($action === 'save_checklist') {
            $featureNames = [
                'Authentication',
                'Dashboard',
                'Crimes',
                'Gym',
                'Combat',
                'Bank',
                'Market',
                'Mail',
                'Travel',
                'Vehicles',
                'Companies',
                'Properties',
                'Factions',
                'Admin Panel',
            ];

            $allowed = ['Shell', 'Backend', 'Polish'];
            $data = [];
            foreach ($featureNames as $feature) {
                $key = 'feature_' . strtolower(str_replace(' ', '_', $feature));
                $value = $_POST[$key] ?? 'Shell';
                if (!in_array($value, $allowed, true)) {
                    $value = 'Shell';
                }
                $data[$feature] = $value;
            }

            @file_put_contents($checklistFile, json_encode($data, JSON_PRETTY_PRINT));
            $messages[] = 'Checklist saved.';
        }
    }
}

$sqlResults = $sqlResults ?? [];

$featureNames = [
    'Authentication',
    'Dashboard',
    'Crimes',
    'Gym',
    'Combat',
    'Bank',
    'Market',
    'Mail',
    'Travel',
    'Vehicles',
    'Companies',
    'Properties',
    'Factions',
    'Admin Panel',
];

$checklistData = [];
if (is_readable($checklistFile)) {
    $saved = json_decode(file_get_contents($checklistFile), true);
    if (is_array($saved)) {
        $checklistData = $saved;
    }
}

$schemaPaths = [
    __DIR__ . '/../../core/init_schema_v0.sql',
    __DIR__ . '/../../core/email_verification_schema.sql',
    __DIR__ . '/../../core/market_schema.sql',
];
$expectedColumns = tc_dev_parse_schema_columns($schemaPaths);
$missingColumns = [];

foreach ($expectedColumns as $table => $expected) {
    if (!tc_dev_table_exists($tables, $table)) {
        $missingColumns[$table] = ['__table_missing__'];
        continue;
    }
    $current = tc_dev_table_columns($db, $table);
    $missing = array_values(array_diff($expected, $current));
    if ($missing) {
        $missingColumns[$table] = $missing;
    }
}

$itemsSamples = [];
if ($db && tc_dev_table_exists($tables, 'items')) {
    $itemsSamples = $db->fetchAll("SELECT id, name FROM items ORDER BY id ASC LIMIT 10");
}

$marketSamples = [];
if ($db && tc_dev_table_exists($tables, 'market_items')) {
    $marketSamples = $db->fetchAll("SELECT id, name FROM market_items ORDER BY id ASC LIMIT 10");
}

$tc_page_title = 'Owner Panel - Developer Tools';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Developer Tools</h1>
            <p class="content-description">Owner quality-of-life utilities for faster iteration.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>

        <?php if ($messages): ?>
            <div class="alert alert-success">
                <div class="alert-content">
                    <div class="alert-message"><?php echo htmlspecialchars(implode(' ', $messages), ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="alert alert-warning">
                <div class="alert-content">
                    <div class="alert-message"><?php echo htmlspecialchars(implode(' ', $errors), ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <div class="tc-card">
            <div style="padding: 1.5rem;">
                <h2 style="color: #D4AF37; margin-top: 0;">Create Module Shell</h2>
                <p style="color: #9CA3AF;">Generate a route, module shell, nav stub, and sidebar link.</p>
                <form method="post" action="/admin/dev_tools.php" style="display: grid; gap: 1rem; max-width: 560px;">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                    <input type="hidden" name="action" value="create_module" />
                    <label style="display: grid; gap: 0.5rem;">
                        <span style="color: #9CA3AF;">Module name (slug)</span>
                        <input type="text" name="module_name" placeholder="new_module" required style="padding: 0.7rem 0.9rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                    </label>
                    <label style="display: grid; gap: 0.5rem;">
                        <span style="color: #9CA3AF;">Sidebar label</span>
                        <input type="text" name="module_label" placeholder="New Module" style="padding: 0.7rem 0.9rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                    </label>
                    <label style="display: grid; gap: 0.5rem;">
                        <span style="color: #9CA3AF;">Sidebar icon path</span>
                        <input type="text" name="module_icon" placeholder="/assets/imgs/icons_32/contracts.PNG" style="padding: 0.7rem 0.9rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                    </label>
                    <button class="btn btn-primary" type="submit">Generate Module</button>
                </form>
            </div>
        </div>
        <div class="grid grid-2" style="margin-top: 2rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">DB Browser (Read-only)</h2>
                </div>
                <div class="card-body">
                    <form method="get" action="/admin/dev_tools.php" style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                        <select name="table" style="flex: 1; min-width: 200px; padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;">
                            <option value="">Select table</option>
                            <?php foreach ($tables as $table): ?>
                                <option value="<?php echo htmlspecialchars($table, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $table === $selectedTable ? 'selected' : ''; ?>><?php echo htmlspecialchars($table, ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-secondary" type="submit">View</button>
                    </form>

                    <?php if ($selectedTable && $tableColumns): ?>
                        <div style="margin-top: 1rem; color: #9CA3AF;">Columns: <?php echo htmlspecialchars(implode(', ', $tableColumns), ENT_QUOTES, 'UTF-8'); ?></div>
                        <?php if ($tableRows): ?>
                            <div style="margin-top: 1rem; max-height: 240px; overflow: auto;">
                                <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                                    <thead>
                                        <tr>
                                            <?php foreach (array_keys($tableRows[0]) as $col): ?>
                                                <th style="padding: 0.5rem; text-align: left; color: #9CA3AF; border-bottom: 1px solid #1F2937;"><?php echo htmlspecialchars($col, ENT_QUOTES, 'UTF-8'); ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($tableRows as $row): ?>
                                            <tr>
                                                <?php foreach ($row as $value): ?>
                                                    <td style="padding: 0.5rem; border-bottom: 1px solid #111827; color: #D1D5DB;">
                                                        <?php echo htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); ?>
                                                    </td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">SQL Runner</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="/admin/dev_tools.php" style="display: grid; gap: 0.75rem;">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="action" value="sql_runner" />
                        <textarea name="sql_query" rows="5" placeholder="SELECT * FROM users LIMIT 10" style="padding: 0.75rem 1rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;"><?php echo htmlspecialchars($_POST['sql_query'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                        <label style="color: #9CA3AF;">Mode</label>
                        <select name="sql_mode" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;">
                            <option value="read">Read-only</option>
                            <option value="write">Write (requires token)</option>
                        </select>
                        <div style="color: #9CA3AF; font-size: 0.9rem;">Write token: <strong><?php echo htmlspecialchars($sqlWriteToken, ENT_QUOTES, 'UTF-8'); ?></strong></div>
                        <input type="text" name="sql_confirm_token" placeholder="Type the write token" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <input type="text" name="sql_confirm_phrase" placeholder="Type I UNDERSTAND" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <button class="btn btn-primary" type="submit">Run SQL</button>
                    </form>

                    <?php if (!empty($sqlResults)): ?>
                        <div style="margin-top: 1rem; max-height: 200px; overflow: auto;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                                <thead>
                                    <tr>
                                        <?php foreach (array_keys($sqlResults[0]) as $col): ?>
                                            <th style="padding: 0.4rem; text-align: left; color: #9CA3AF; border-bottom: 1px solid #1F2937;"><?php echo htmlspecialchars($col, ENT_QUOTES, 'UTF-8'); ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sqlResults as $row): ?>
                                        <tr>
                                            <?php foreach ($row as $value): ?>
                                                <td style="padding: 0.4rem; border-bottom: 1px solid #111827; color: #D1D5DB;">
                                                    <?php echo htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="grid grid-2" style="margin-top: 2rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Seeder Tools</h2>
                </div>
                <div class="card-body" style="display: grid; gap: 1.5rem;">
                    <form method="post" action="/admin/dev_tools.php" style="display: grid; gap: 0.75rem;">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="action" value="create_test_users" />
                        <h3 style="margin: 0; color: #D4AF37;">Create Test Users</h3>
                        <input type="number" name="user_count" min="1" max="50" value="5" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <input type="text" name="user_base" placeholder="testuser" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <input type="text" name="user_domain" placeholder="example.com" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <input type="text" name="user_password" placeholder="Test1234!" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <button class="btn btn-secondary" type="submit">Create Users</button>
                    </form>

                    <form method="post" action="/admin/dev_tools.php" style="display: grid; gap: 0.75rem;">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="action" value="starter_pack" />
                        <h3 style="margin: 0; color: #D4AF37;">Starter Pack</h3>
                        <input type="number" name="starter_user_id" placeholder="User ID" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <input type="number" name="starter_cash" placeholder="Cash (default 10000)" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <input type="number" name="starter_bank" placeholder="Bank (default 5000)" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <input type="number" name="starter_xp" placeholder="XP (default 1000)" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <input type="number" name="starter_items" placeholder="Items count (default 3)" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <button class="btn btn-secondary" type="submit">Apply Pack</button>
                    </form>

                    <form method="post" action="/admin/dev_tools.php" style="display: grid; gap: 0.75rem;">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="action" value="spawn_item" />
                        <h3 style="margin: 0; color: #D4AF37;">Spawn Item</h3>
                        <select name="spawn_source" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;">
                            <option value="items">items/user_items</option>
                            <option value="market">market_items/user_inventory</option>
                        </select>
                        <input type="number" name="spawn_user_id" placeholder="User ID" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <input type="number" name="spawn_item_id" placeholder="Item ID" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <input type="number" name="spawn_qty" placeholder="Qty" value="1" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;" />
                        <button class="btn btn-secondary" type="submit">Spawn</button>
                        <?php if ($itemsSamples): ?>
                            <div style="color: #9CA3AF; font-size: 0.85rem;">Items sample: <?php echo htmlspecialchars(implode(', ', array_map(function ($item) {
                                return $item['id'] . ':' . $item['name'];
                            }, $itemsSamples)), ENT_QUOTES, 'UTF-8'); ?></div>
                        <?php endif; ?>
                        <?php if ($marketSamples): ?>
                            <div style="color: #9CA3AF; font-size: 0.85rem;">Market sample: <?php echo htmlspecialchars(implode(', ', array_map(function ($item) {
                                return $item['id'] . ':' . $item['name'];
                            }, $marketSamples)), ENT_QUOTES, 'UTF-8'); ?></div>
                        <?php endif; ?>
                    </form>

                    <form method="post" action="/admin/dev_tools.php">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="action" value="fill_market" />
                        <h3 style="margin: 0 0 0.75rem; color: #D4AF37;">Fill Markets</h3>
                        <button class="btn btn-secondary" type="submit">Refill Market Stock</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Migration Helper</h2>
                </div>
                <div class="card-body">
                    <p style="color: #9CA3AF; margin-top: 0;">Detect missing columns (no changes applied).</p>
                    <?php if (!$missingColumns): ?>
                        <div style="color: #D1D5DB;">No missing columns detected.</div>
                    <?php else: ?>
                        <div style="display: grid; gap: 0.75rem;">
                            <?php foreach ($missingColumns as $table => $missing): ?>
                                <div style="background: rgba(17, 24, 39, 0.75); border: 1px solid #1F2937; border-radius: 0.5rem; padding: 0.75rem;">
                                    <strong style="color: #F9FAFB;"><?php echo htmlspecialchars($table, ENT_QUOTES, 'UTF-8'); ?></strong>
                                    <?php if (in_array('__table_missing__', $missing, true)): ?>
                                        <div style="color: #FCA5A5;">Table missing</div>
                                    <?php else: ?>
                                        <div style="color: #FCA5A5;">Missing: <?php echo htmlspecialchars(implode(', ', $missing), ENT_QUOTES, 'UTF-8'); ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="tc-card" style="margin-top: 2rem;">
            <div style="padding: 1.5rem;">
                <h2 style="color: #D4AF37; margin-top: 0;">Feature Checklist Tracker</h2>
                <form method="post" action="/admin/dev_tools.php" style="display: grid; gap: 0.75rem;">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                    <input type="hidden" name="action" value="save_checklist" />
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="text-align: left; padding: 0.5rem; color: #9CA3AF;">Feature</th>
                                <th style="text-align: left; padding: 0.5rem; color: #9CA3AF;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($featureNames as $feature): ?>
                                <?php $key = 'feature_' . strtolower(str_replace(' ', '_', $feature)); ?>
                                <?php $current = $checklistData[$feature] ?? 'Shell'; ?>
                                <tr>
                                    <td style="padding: 0.5rem; color: #F9FAFB; border-bottom: 1px solid #1F2937;">
                                        <?php echo htmlspecialchars($feature, ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td style="padding: 0.5rem; border-bottom: 1px solid #1F2937;">
                                        <select name="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>" style="padding: 0.4rem 0.6rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;">
                                            <?php foreach (['Shell', 'Backend', 'Polish'] as $status): ?>
                                                <option value="<?php echo $status; ?>" <?php echo $current === $status ? 'selected' : ''; ?>><?php echo $status; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button class="btn btn-primary" type="submit">Save Checklist</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>





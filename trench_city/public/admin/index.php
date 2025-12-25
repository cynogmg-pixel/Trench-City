<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);
$columns = tc_admin_user_columns($db);

if (!function_exists('tc_admin_tail_file')) {
    function tc_admin_tail_file(string $path, int $lines = 120): array
    {
        if (!is_readable($path)) {
            return [];
        }

        $handle = fopen($path, 'rb');
        if (!$handle) {
            return [];
        }

        $buffer = '';
        $chunkSize = 4096;
        fseek($handle, 0, SEEK_END);
        $position = ftell($handle);

        while ($position > 0 && substr_count($buffer, "\n") <= $lines) {
            $readSize = ($position - $chunkSize) >= 0 ? $chunkSize : $position;
            $position -= $readSize;
            fseek($handle, $position);
            $buffer = fread($handle, $readSize) . $buffer;
        }

        fclose($handle);

        $buffer = trim($buffer);
        if ($buffer === '') {
            return [];
        }

        $allLines = explode("\n", $buffer);
        return array_slice($allLines, -$lines);
    }
}

if (!function_exists('tc_admin_pick_log_file')) {
    function tc_admin_pick_log_file(string $dir, array $patterns): string
    {
        $files = [];
        foreach ($patterns as $pattern) {
            $files = array_merge($files, glob(rtrim($dir, '/') . '/' . $pattern) ?: []);
        }
        if (!$files) {
            return '';
        }
        usort($files, function ($a, $b) {
            return filemtime($b) <=> filemtime($a);
        });
        return $files[0] ?? '';
    }
}

$formatCash = function ($value): string {
    $value = (float)$value;
    return function_exists('formatCash') ? formatCash($value) : number_format($value, 2);
};

$stats = [
    'total_users' => null,
    'active_users' => null,
    'verified_users' => null,
    'online_now' => null,
    'active_24h' => null,
    'active_7d' => null,
    'new_today' => null,
    'total_cash' => null,
    'total_bank' => null,
    'total_cash_all' => null,
    'total_items' => null,
    'crimes_completed' => null,
    'gyms_used' => null,
];

$alerts = [
    'flagged_accounts' => null,
    'chargebacks' => null,
    'exploit_triggers' => null,
    'error_spikes' => null,
    'email_failures' => null,
    'queue_backlog' => null,
];

$messages = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quick_action'])) {
    if (!csrf_check($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token.';
    } elseif (!$db) {
        $errors[] = 'Database connection unavailable.';
    } else {
        $action = $_POST['quick_action'];
        if ($action === 'set_status') {
            if (!in_array('status', $columns, true)) {
                $errors[] = 'Status column not available.';
            } else {
                $targetId = (int)($_POST['target_user_id'] ?? 0);
                $newStatus = (string)($_POST['new_status'] ?? '');
                if ($targetId <= 0 || !in_array($newStatus, ['active', 'banned', 'inactive'], true)) {
                    $errors[] = 'Invalid user or status.';
                } else {
                    try {
                        $db->execute(
                            "UPDATE users SET status = :status WHERE id = :id",
                            ['status' => $newStatus, 'id' => $targetId]
                        );
                        $messages[] = 'Account status updated.';
                        if (function_exists('logPlayerAction')) {
                            $adminActorId = isset($admin_user['id']) ? (int)$admin_user['id'] : $targetId;
                            logPlayerAction($adminActorId, 'admin_status_update', [
                                'target_user_id' => $targetId,
                                'status' => $newStatus,
                            ]);
                        }
                    } catch (Throwable $e) {
                        $errors[] = 'Failed to update status.';
                    }
                }
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['combo_action'])) {
    if (!csrf_check($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token.';
    } else {
        $comboMessage = trim((string)($_POST['combo_message'] ?? ''));
        $comboTitle = trim((string)($_POST['combo_title'] ?? ''));
        $comboType = trim((string)($_POST['combo_type'] ?? 'info'));
        $comboFlags = $_POST['combo_flags'] ?? [];
        if (!is_array($comboFlags)) {
            $comboFlags = [];
        }

        $catalog = function_exists('tc_ops_flag_catalog') ? tc_ops_flag_catalog() : [];
        $validFlags = [];
        foreach ($comboFlags as $flag) {
            $flag = (string)$flag;
            if ($flag !== '' && isset($catalog[$flag])) {
                $validFlags[] = $flag;
            }
        }

        if ($comboMessage === '' && !$validFlags) {
            $errors[] = 'Provide a message or select at least one flag.';
        } else {
            if ($comboMessage !== '' && function_exists('tc_set_global_announcement')) {
                $payload = [
                    'title' => $comboTitle,
                    'message' => $comboMessage,
                    'type' => in_array($comboType, ['info', 'warning', 'success'], true) ? $comboType : 'info',
                    'expires_at' => null,
                ];
                if (!tc_set_global_announcement($payload)) {
                    $errors[] = 'Failed to set announcement.';
                }
            }

            foreach ($validFlags as $flag) {
                if (!tc_set_ops_flag($flag, true)) {
                    $errors[] = 'Failed to enable flag: ' . $flag;
                }
            }

            if (!$errors) {
                $messages[] = 'Broadcast + lockdown combo applied.';
                if (function_exists('logPlayerAction')) {
                    $adminActorId = isset($admin_user['id']) ? (int)$admin_user['id'] : 0;
                    logPlayerAction($adminActorId, 'admin_combo_action', [
                        'announcement' => $comboMessage !== '',
                        'flags' => $validFlags,
                    ]);
                }
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['combo_clear_action'])) {
    if (!csrf_check($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token.';
    } else {
        $hadErrors = false;
        if (function_exists('tc_set_global_announcement')) {
            if (!tc_set_global_announcement(null)) {
                $errors[] = 'Failed to clear announcement.';
                $hadErrors = true;
            }
        }
        if (function_exists('tc_save_ops_flags')) {
            if (!tc_save_ops_flags([])) {
                $errors[] = 'Failed to clear ops flags.';
                $hadErrors = true;
            }
        }
        if (!$hadErrors) {
            $messages[] = 'All flags and announcements cleared.';
            if (function_exists('logPlayerAction')) {
                $adminActorId = isset($admin_user['id']) ? (int)$admin_user['id'] : 0;
                logPlayerAction($adminActorId, 'admin_combo_clear', [
                    'flags_cleared' => true,
                    'announcement_cleared' => true,
                ]);
            }
        }
    }
}

if ($db && tc_admin_table_exists($db, 'users')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users");
        $stats['total_users'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['total_users'] = null;
    }

    if (in_array('status', $columns, true)) {
        try {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE status = 'active'");
            $stats['active_users'] = (int)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $stats['active_users'] = null;
        }

        try {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE status IN ('banned','inactive')");
            $alerts['flagged_accounts'] = (int)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $alerts['flagged_accounts'] = null;
        }
    }

    if (in_array('email_verified', $columns, true)) {
        try {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE email_verified = 1");
            $stats['verified_users'] = (int)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $stats['verified_users'] = null;
        }
    }

    if (in_array('last_login_at', $columns, true)) {
        try {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE last_login_at >= (NOW() - INTERVAL 10 MINUTE)");
            $stats['online_now'] = (int)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $stats['online_now'] = null;
        }

        try {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE last_login_at >= (NOW() - INTERVAL 1 DAY)");
            $stats['active_24h'] = (int)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $stats['active_24h'] = null;
        }

        try {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE last_login_at >= (NOW() - INTERVAL 7 DAY)");
            $stats['active_7d'] = (int)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $stats['active_7d'] = null;
        }
    }

    if (in_array('created_at', $columns, true)) {
        try {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE created_at >= CURDATE()");
            $stats['new_today'] = (int)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $stats['new_today'] = null;
        }
    }

    if (in_array('cash', $columns, true)) {
        try {
            $row = $db->fetchOne("SELECT SUM(cash) AS total FROM users");
            $stats['total_cash'] = (float)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $stats['total_cash'] = null;
        }
    }

    if (in_array('bank_balance', $columns, true)) {
        try {
            $row = $db->fetchOne("SELECT SUM(bank_balance) AS total FROM users");
            $stats['total_bank'] = (float)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $stats['total_bank'] = null;
        }
    }

    if ($stats['total_cash'] !== null || $stats['total_bank'] !== null) {
        $stats['total_cash_all'] = (float)($stats['total_cash'] ?? 0) + (float)($stats['total_bank'] ?? 0);
    }
}

if ($db && tc_admin_table_exists($db, 'user_items')) {
    try {
        $row = $db->fetchOne("SELECT SUM(qty) AS total FROM user_items");
        $stats['total_items'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['total_items'] = null;
    }
} elseif ($db && tc_admin_table_exists($db, 'user_inventory')) {
    try {
        $row = $db->fetchOne("SELECT SUM(quantity) AS total FROM user_inventory");
        $stats['total_items'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['total_items'] = null;
    }
} elseif ($db && tc_admin_table_exists($db, 'items')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM items");
        $stats['total_items'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['total_items'] = null;
    }
}

if ($db && tc_admin_table_exists($db, 'crime_logs')) {
    try {
        if (tc_admin_table_has_column($db, 'crime_logs', 'success')) {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM crime_logs WHERE success = 1");
        } else {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM crime_logs");
        }
        $stats['crimes_completed'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['crimes_completed'] = null;
    }
}

if ($db && tc_admin_table_exists($db, 'training_logs')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM training_logs");
        $stats['gyms_used'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['gyms_used'] = null;
    }
}

$logBase = defined('LOG_PATH') ? LOG_PATH : __DIR__ . '/../../storage/logs';
$errorLogFile = '';
$infoLogFile = '';
$activityLines = [];

if (is_dir($logBase)) {
    $errorLogFile = tc_admin_pick_log_file($logBase, ['error-*.log', 'error.log', 'fatal-*.log']);
    $infoLogFile = tc_admin_pick_log_file($logBase, ['info-*.log', 'info.log']);
}

if ($errorLogFile) {
    $errorLines = tc_admin_tail_file($errorLogFile, 200);
    $alerts['error_spikes'] = count($errorLines);

    $emailFailures = 0;
    foreach ($errorLines as $line) {
        if (stripos($line, 'smtp') !== false || stripos($line, 'email') !== false) {
            $emailFailures++;
        }
    }
    $alerts['email_failures'] = $emailFailures;
}

if ($infoLogFile) {
    $infoLines = tc_admin_tail_file($infoLogFile, 240);
    foreach ($infoLines as $line) {
        if (stripos($line, '[PLAYER_ACTION]') !== false || stripos($line, '[AUTH]') !== false || stripos($line, 'register') !== false || stripos($line, 'transfer') !== false) {
            $activityLines[] = $line;
        }
    }
    if ($activityLines) {
        $activityLines = array_slice($activityLines, -12);
    } else {
        $activityLines = array_slice($infoLines, -12);
    }
}

$tc_page_title = 'Owner Panel - Trench City';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Owner Admin Panel</h1>
            <p class="content-description">Private control room for Trench City operations.</p>
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

        <div class="grid grid-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Online Now</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 2rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['online_now'] !== null ? number_format($stats['online_now']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Based on last login in 10m</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Active 24h</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 2rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['active_24h'] !== null ? number_format($stats['active_24h']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Logged in last day</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Active 7d</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 2rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['active_7d'] !== null ? number_format($stats['active_7d']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Logged in last week</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">New Today</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 2rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['new_today'] !== null ? number_format($stats['new_today']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Accounts created today</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Total Users</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 2rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['total_users'] !== null ? number_format($stats['total_users']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Registered accounts</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Verified Emails</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 2rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['verified_users'] !== null ? number_format($stats['verified_users']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Email verified</div>
                </div>
            </div>
        </div>

        <div class="grid grid-3" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Cash On Hand</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.85rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['total_cash'] !== null ? $formatCash($stats['total_cash']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Total wallet cash</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Total Bank</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.85rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['total_bank'] !== null ? $formatCash($stats['total_bank']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">All bank balances</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Total Cash</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.85rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['total_cash_all'] !== null ? $formatCash($stats['total_cash_all']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Cash in circulation</div>
                </div>
            </div>
        </div>

        <div class="grid grid-3" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Total Items</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.85rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['total_items'] !== null ? number_format($stats['total_items']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Inventory items</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Crimes Completed</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.85rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['crimes_completed'] !== null ? number_format($stats['crimes_completed']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Successful crime logs</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Gyms Used</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.85rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['gyms_used'] !== null ? number_format($stats['gyms_used']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Training sessions</div>
                </div>
            </div>
        </div>

        <div class="grid grid-2" style="margin-top: 2rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Alerts Panel</h2>
                </div>
                <div class="card-body">
                    <div style="display: grid; gap: 0.75rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #9CA3AF;">Flagged accounts</span>
                            <span style="color: #F9FAFB; font-weight: 600;">
                                <?php echo $alerts['flagged_accounts'] !== null ? number_format($alerts['flagged_accounts']) : 'N/A'; ?>
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #9CA3AF;">Chargebacks</span>
                            <span style="color: #F9FAFB; font-weight: 600;">N/A</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #9CA3AF;">Exploit triggers</span>
                            <span style="color: #F9FAFB; font-weight: 600;">N/A</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #9CA3AF;">Error spikes</span>
                            <span style="color: #F9FAFB; font-weight: 600;">
                                <?php echo $alerts['error_spikes'] !== null ? number_format($alerts['error_spikes']) : 'N/A'; ?>
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #9CA3AF;">Email failures</span>
                            <span style="color: #F9FAFB; font-weight: 600;">
                                <?php echo $alerts['email_failures'] !== null ? number_format($alerts['email_failures']) : 'N/A'; ?>
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #9CA3AF;">Queue backlog</span>
                            <span style="color: #F9FAFB; font-weight: 600;">N/A</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Quick Actions</h2>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                        <a class="btn btn-primary" href="/admin/maintenance.php">Maintenance Mode</a>
                        <a class="btn btn-secondary" href="/admin/users.php">User Search</a>
                        <a class="btn btn-secondary" href="/admin/content.php">Global Message</a>
                        <a class="btn btn-secondary" href="/admin/panic.php">Panic Switches</a>
                    </div>
                    <?php if (in_array('status', $columns, true)): ?>
                        <form method="post" action="/admin/index.php" style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1rem;">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                            <input type="hidden" name="quick_action" value="set_status" />
                            <input type="number" name="target_user_id" min="1" placeholder="User ID" style="padding: 0.6rem 0.8rem; background: #1F2937; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB; min-width: 140px;" />
                            <select name="new_status" style="padding: 0.6rem 0.8rem; background: #111827; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;">
                                <option value="active">Active</option>
                                <option value="banned">Banned</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <button class="btn btn-secondary" type="submit">Update Status</button>
                        </form>
                    <?php endif; ?>
                    <div style="color: #9CA3AF; margin-top: 1rem;">Grant points requires a points column before enabling.</div>
                </div>
            </div>
        </div>

        <div class="tc-card" style="margin-top: 1.5rem;">
            <div style="padding: 1.5rem;">
                <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Broadcast + Lockdown Combo</h2>
                <form method="post" action="/admin/index.php" style="display: grid; gap: 0.75rem;">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                    <input type="hidden" name="combo_action" value="apply" />
                    <label style="display: grid; gap: 0.35rem; color: #9CA3AF;">
                        <span>Broadcast Title (optional)</span>
                        <input type="text" name="combo_title" placeholder="System Notice" style="max-width: 360px; padding: 0.6rem 0.8rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;" />
                    </label>
                    <label style="display: grid; gap: 0.35rem; color: #9CA3AF;">
                        <span>Broadcast Message (optional)</span>
                        <textarea name="combo_message" rows="3" placeholder="Message shown at the top of all post-login pages." style="padding: 0.6rem 0.8rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;"></textarea>
                    </label>
                    <label style="display: grid; gap: 0.35rem; color: #9CA3AF; max-width: 220px;">
                        <span>Message Type</span>
                        <select name="combo_type" style="padding: 0.6rem 0.8rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;">
                            <option value="info">Info</option>
                            <option value="warning">Warning</option>
                            <option value="success">Success</option>
                        </select>
                    </label>
                    <div style="color: #9CA3AF;">Select any lockdown flags to enable (none are enabled by default).</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <?php $catalog = function_exists('tc_ops_flag_catalog') ? tc_ops_flag_catalog() : []; ?>
                        <?php foreach ($catalog as $flag => $meta): ?>
                            <label style="display: inline-flex; align-items: center; gap: 0.4rem; color: #D1D5DB; font-size: 0.9rem; border: 1px solid #374151; padding: 0.35rem 0.5rem; border-radius: 0.5rem;">
                                <input type="checkbox" name="combo_flags[]" value="<?php echo htmlspecialchars($flag, ENT_QUOTES, 'UTF-8'); ?>" />
                                <?php echo htmlspecialchars($meta['label'] ?? $flag, ENT_QUOTES, 'UTF-8'); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div>
                        <button class="btn btn-danger" type="submit">Apply Broadcast + Lockdown</button>
                    </div>
                </form>
                <form method="post" action="/admin/index.php" style="margin-top: 1rem;">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                    <input type="hidden" name="combo_clear_action" value="clear_all" />
                    <button class="btn btn-secondary" type="submit">Clear All Flags + Announcement</button>
                </form>
            </div>
        </div>

        <div class="tc-card" style="margin-top: 2rem;">
            <div style="padding: 1.5rem;">
                <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Recent Activity</h2>
                <?php if (!$activityLines): ?>
                    <div style="color: #9CA3AF;">No activity logs found.</div>
                <?php else: ?>
                    <div style="max-height: 300px; overflow-y: auto; background: rgba(5, 7, 11, 0.6); border: 1px solid #1F2937; border-radius: 0.5rem; padding: 1rem;">
                        <pre style="margin: 0; color: #D1D5DB; white-space: pre-wrap;">
<?php echo htmlspecialchars(implode("\n", $activityLines), ENT_QUOTES, 'UTF-8'); ?>
                        </pre>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>





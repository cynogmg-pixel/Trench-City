<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);
$tables = $db ? tc_admin_list_tables($db) : [];
$messages = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export_action'])) {
    if (!csrf_check($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token.';
    } elseif (!$db) {
        $errors[] = 'Database connection unavailable.';
    } else {
        $action = (string)$_POST['export_action'];
        $limit = (int)($_POST['export_limit'] ?? 2000);
        if ($limit < 1) {
            $limit = 2000;
        }
        if ($limit > 10000) {
            $limit = 10000;
        }

        $filename = '';
        $rows = [];
        if ($action === 'users' && tc_admin_table_exists($db, 'users')) {
            $filename = 'users_export_' . date('Ymd_His') . '.csv';
            $rows = $db->fetchAll("SELECT id, username, email, level, status, created_at FROM users ORDER BY id ASC LIMIT {$limit}");
        } elseif ($action === 'bank' && tc_admin_table_exists($db, 'bank_transactions')) {
            $filename = 'bank_transactions_' . date('Ymd_His') . '.csv';
            $rows = $db->fetchAll("SELECT id, user_id, transaction_type, amount, cash_after, bank_after, created_at FROM bank_transactions ORDER BY id DESC LIMIT {$limit}");
        } elseif ($action === 'market' && tc_admin_table_exists($db, 'market_transactions')) {
            $filename = 'market_transactions_' . date('Ymd_His') . '.csv';
            $rows = $db->fetchAll("SELECT id, user_id, item_id, transaction_type, quantity, total_price, created_at FROM market_transactions ORDER BY id DESC LIMIT {$limit}");
        } else {
            $errors[] = 'Export source not available.';
        }

        if (!$errors && $filename !== '') {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            $out = fopen('php://output', 'w');
            if ($out && $rows) {
                fputcsv($out, array_keys($rows[0]));
                foreach ($rows as $row) {
                    fputcsv($out, $row);
                }
            } elseif ($out) {
                fputcsv($out, ['message']);
                fputcsv($out, ['No rows returned.']);
            }
            if ($out) {
                fclose($out);
            }
            exit;
        }
    }
}

$section_title = 'Data Tools & Exports';
$section_description = 'Export user and economy data for audits and disputes.';
$section_features = [
    'CSV/JSON exports for users, economy, logs, and bans.',
    'Backup status and restore test tracking.',
    'GDPR tooling for user export and deletion.',
];
$section_notes = [
    'Exports should be rate-limited and audited before enabling downloads.',
];

$tc_page_title = 'Owner Panel - Data Tools';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Data Tools &amp; Exports</h1>
            <p class="content-description">Prepare exports, backups, and compliance workflows.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>
        <?php include __DIR__ . '/../../includes/admin_section.php'; ?>

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

        <div class="grid grid-2" style="margin-top: 1.5rem;">
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Export Queues</h2>
                    <form method="post" action="/admin/data_tools.php" style="display: grid; gap: 0.75rem;">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <label style="display: grid; gap: 0.35rem; color: #9CA3AF;">
                            <span>Row limit (max 10000)</span>
                            <input type="number" name="export_limit" min="1" max="10000" value="2000" style="max-width: 180px; padding: 0.6rem 0.8rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;" />
                        </label>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                            <button class="btn btn-secondary" type="submit" name="export_action" value="users">Export Users (CSV)</button>
                            <button class="btn btn-secondary" type="submit" name="export_action" value="bank">Export Bank Tx (CSV)</button>
                            <button class="btn btn-secondary" type="submit" name="export_action" value="market">Export Market Tx (CSV)</button>
                        </div>
                        <div style="color: #9CA3AF;">Exports are read-only and limited for safety.</div>
                    </form>
                </div>
            </div>

            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Backups</h2>
                    <ul style="margin: 0; padding-left: 1.25rem; color: #D1D5DB;">
                        <li>Last DB backup: not configured.</li>
                        <li>Last restore test: not configured.</li>
                        <li>Retention policy: manual.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tc-card" style="margin-top: 1.5rem;">
            <div style="padding: 1.5rem;">
                <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Available Tables</h2>
                <?php if (!$tables): ?>
                    <div style="color: #9CA3AF;">No tables detected.</div>
                <?php else: ?>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <?php foreach ($tables as $table): ?>
                            <span style="padding: 0.35rem 0.6rem; border: 1px solid #374151; border-radius: 0.5rem; color: #D1D5DB; font-size: 0.85rem;">
                                <?php echo htmlspecialchars($table, ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

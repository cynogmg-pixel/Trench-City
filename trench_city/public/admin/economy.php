<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);
$columns = tc_admin_user_columns($db);

$formatCash = function ($value): string {
    $value = (float)$value;
    return function_exists('formatCash') ? formatCash($value) : number_format($value, 2);
};

$metrics = [
    'total_cash' => null,
    'total_bank' => null,
    'total_cash_all' => null,
    'total_users' => null,
    'bank_tx_24h' => null,
    'bank_volume_24h' => null,
    'market_tx_24h' => null,
    'market_volume_24h' => null,
    'market_items' => null,
];

$topRich = [];

if ($db && tc_admin_table_exists($db, 'users')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users");
        $metrics['total_users'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $metrics['total_users'] = null;
    }

    if (in_array('cash', $columns, true)) {
        try {
            $row = $db->fetchOne("SELECT SUM(cash) AS total FROM users");
            $metrics['total_cash'] = (float)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $metrics['total_cash'] = null;
        }
    }

    if (in_array('bank_balance', $columns, true)) {
        try {
            $row = $db->fetchOne("SELECT SUM(bank_balance) AS total FROM users");
            $metrics['total_bank'] = (float)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $metrics['total_bank'] = null;
        }
    }

    if ($metrics['total_cash'] !== null || $metrics['total_bank'] !== null) {
        $metrics['total_cash_all'] = (float)($metrics['total_cash'] ?? 0) + (float)($metrics['total_bank'] ?? 0);
    }

    if (in_array('cash', $columns, true) && in_array('bank_balance', $columns, true)) {
        try {
            $topRich = $db->fetchAll(
                "SELECT id, username, (cash + bank_balance) AS net_worth FROM users ORDER BY net_worth DESC LIMIT 5"
            );
        } catch (Throwable $e) {
            $topRich = [];
        }
    }
}

if ($db && tc_admin_table_exists($db, 'bank_transactions')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM bank_transactions WHERE created_at >= (NOW() - INTERVAL 1 DAY)");
        $metrics['bank_tx_24h'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $metrics['bank_tx_24h'] = null;
    }

    try {
        $row = $db->fetchOne("SELECT SUM(amount) AS total FROM bank_transactions WHERE created_at >= (NOW() - INTERVAL 1 DAY)");
        $metrics['bank_volume_24h'] = (float)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $metrics['bank_volume_24h'] = null;
    }
}

if ($db && tc_admin_table_exists($db, 'market_transactions')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM market_transactions WHERE created_at >= (NOW() - INTERVAL 1 DAY)");
        $metrics['market_tx_24h'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $metrics['market_tx_24h'] = null;
    }

    try {
        $row = $db->fetchOne("SELECT SUM(total_price) AS total FROM market_transactions WHERE created_at >= (NOW() - INTERVAL 1 DAY)");
        $metrics['market_volume_24h'] = (float)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $metrics['market_volume_24h'] = null;
    }
}

if ($db && tc_admin_table_exists($db, 'market_items')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM market_items WHERE is_active = 1");
        $metrics['market_items'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $metrics['market_items'] = null;
    }
}

$section_title = 'Economy Control Center';
$section_description = 'Monitor money supply, market volume, and points circulation.';
$section_features = [
    'Total cash in circulation and bank liquidity.',
    'Market volume, trade flow, and transaction spikes.',
    'Tools for currency adjustments and rollbacks (guarded).',
];
$section_notes = [
    'Write operations require additional schema and validation hooks.',
];

$tc_page_title = 'Owner Panel - Economy';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Economy Control Center</h1>
            <p class="content-description">Monitor money supply, market volume, and transaction flow.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>
        <?php include __DIR__ . '/../../includes/admin_section.php'; ?>

        <div class="grid grid-3" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Cash On Hand</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.85rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $metrics['total_cash'] !== null ? $formatCash($metrics['total_cash']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">User wallets</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Total Bank</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.85rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $metrics['total_bank'] !== null ? $formatCash($metrics['total_bank']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Stored balances</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Total Supply</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.85rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $metrics['total_cash_all'] !== null ? $formatCash($metrics['total_cash_all']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Cash in circulation</div>
                </div>
            </div>
        </div>

        <div class="grid grid-3" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Bank Transfers 24h</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.65rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $metrics['bank_tx_24h'] !== null ? number_format($metrics['bank_tx_24h']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Transactions logged</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Bank Volume 24h</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.65rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $metrics['bank_volume_24h'] !== null ? $formatCash($metrics['bank_volume_24h']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Total moved</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Market Items</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.65rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $metrics['market_items'] !== null ? number_format($metrics['market_items']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Active listings</div>
                </div>
            </div>
        </div>

        <div class="grid grid-2" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Market Volume 24h</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.65rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $metrics['market_volume_24h'] !== null ? $formatCash($metrics['market_volume_24h']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Sum of market transactions</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Market Transactions 24h</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.65rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $metrics['market_tx_24h'] !== null ? number_format($metrics['market_tx_24h']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Trades executed</div>
                </div>
            </div>
        </div>

        <div class="tc-card" style="margin-top: 1.5rem;">
            <div style="padding: 1.5rem;">
                <h2 style="color: #D4AF37; margin-bottom: 1rem;">Top Net Worth (Sample)</h2>
                <?php if (!$topRich): ?>
                    <div style="color: #9CA3AF;">No ranking data available.</div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #374151;">
                                    <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">User</th>
                                    <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">Username</th>
                                    <th style="padding: 0.6rem; text-align: right; color: #9CA3AF;">Net Worth</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topRich as $row): ?>
                                    <tr style="border-bottom: 1px solid #1F2937;">
                                        <td style="padding: 0.6rem; color: #F9FAFB;">#<?php echo (int)$row['id']; ?></td>
                                        <td style="padding: 0.6rem; color: #D1D5DB;"><?php echo htmlspecialchars($row['username'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td style="padding: 0.6rem; text-align: right; color: #D1D5DB;">
                                            <?php echo $formatCash($row['net_worth'] ?? 0); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

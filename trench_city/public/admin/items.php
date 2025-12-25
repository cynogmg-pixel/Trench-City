<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);

$stats = [
    'items_catalog' => null,
    'market_catalog' => null,
    'inventory_items' => null,
    'market_inventory' => null,
];

$itemsSample = [];
$marketSample = [];

if ($db && tc_admin_table_exists($db, 'items')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM items");
        $stats['items_catalog'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['items_catalog'] = null;
    }

    try {
        $itemsSample = $db->fetchAll("SELECT id, name, rarity FROM items ORDER BY id DESC LIMIT 5");
    } catch (Throwable $e) {
        $itemsSample = [];
    }
}

if ($db && tc_admin_table_exists($db, 'market_items')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM market_items");
        $stats['market_catalog'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['market_catalog'] = null;
    }

    try {
        $marketSample = $db->fetchAll("SELECT id, name, category, base_price FROM market_items ORDER BY id DESC LIMIT 5");
    } catch (Throwable $e) {
        $marketSample = [];
    }
}

if ($db && tc_admin_table_exists($db, 'user_items')) {
    try {
        $row = $db->fetchOne("SELECT SUM(qty) AS total FROM user_items");
        $stats['inventory_items'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['inventory_items'] = null;
    }
}

if ($db && tc_admin_table_exists($db, 'user_inventory')) {
    try {
        $row = $db->fetchOne("SELECT SUM(quantity) AS total FROM user_inventory");
        $stats['market_inventory'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['market_inventory'] = null;
    }
}

$section_title = 'Items & Inventory Tools';
$section_description = 'Item database browsing, grants, removals, and inventory cleanup.';
$section_features = [
    'Item database browser and rarity review.',
    'Give or remove items with audit notes.',
    'Inventory cleanup and invalid stack fixes.',
    'Drop-table debugger (simulation).',
];
$section_notes = [
    'Grant/remove actions require guardrails and audit logging.',
];

$tc_page_title = 'Owner Panel - Items';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Items &amp; Inventory Tools</h1>
            <p class="content-description">Browse items and monitor inventory health.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>
        <?php include __DIR__ . '/../../includes/admin_section.php'; ?>

        <div class="grid grid-4" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Item Catalog</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['items_catalog'] !== null ? number_format($stats['items_catalog']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Core items table</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Market Catalog</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['market_catalog'] !== null ? number_format($stats['market_catalog']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Market items</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Inventory Qty</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['inventory_items'] !== null ? number_format($stats['inventory_items']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">User items total</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Market Inventory</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['market_inventory'] !== null ? number_format($stats['market_inventory']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Market user inventory</div>
                </div>
            </div>
        </div>

        <div class="grid grid-2" style="margin-top: 1.5rem;">
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Latest Core Items</h2>
                    <?php if (!$itemsSample): ?>
                        <div style="color: #9CA3AF;">No core items available.</div>
                    <?php else: ?>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #374151;">
                                        <th style="padding: 0.5rem; text-align: left; color: #9CA3AF;">ID</th>
                                        <th style="padding: 0.5rem; text-align: left; color: #9CA3AF;">Name</th>
                                        <th style="padding: 0.5rem; text-align: right; color: #9CA3AF;">Rarity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($itemsSample as $row): ?>
                                        <tr style="border-bottom: 1px solid #1F2937;">
                                            <td style="padding: 0.5rem; color: #D1D5DB;">#<?php echo (int)$row['id']; ?></td>
                                            <td style="padding: 0.5rem; color: #F9FAFB;"><?php echo htmlspecialchars($row['name'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td style="padding: 0.5rem; text-align: right; color: #D1D5DB;">
                                                <?php echo isset($row['rarity']) ? (int)$row['rarity'] : '-'; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Latest Market Items</h2>
                    <?php if (!$marketSample): ?>
                        <div style="color: #9CA3AF;">No market items available.</div>
                    <?php else: ?>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #374151;">
                                        <th style="padding: 0.5rem; text-align: left; color: #9CA3AF;">ID</th>
                                        <th style="padding: 0.5rem; text-align: left; color: #9CA3AF;">Name</th>
                                        <th style="padding: 0.5rem; text-align: left; color: #9CA3AF;">Category</th>
                                        <th style="padding: 0.5rem; text-align: right; color: #9CA3AF;">Base Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($marketSample as $row): ?>
                                        <tr style="border-bottom: 1px solid #1F2937;">
                                            <td style="padding: 0.5rem; color: #D1D5DB;">#<?php echo (int)$row['id']; ?></td>
                                            <td style="padding: 0.5rem; color: #F9FAFB;"><?php echo htmlspecialchars($row['name'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td style="padding: 0.5rem; color: #D1D5DB;">
                                                <?php echo htmlspecialchars($row['category'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>
                                            <td style="padding: 0.5rem; text-align: right; color: #D1D5DB;">
                                                <?php echo isset($row['base_price']) ? number_format((int)$row['base_price']) : '-'; ?>
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
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

<?php
require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

$tc_page_title = 'Items Hub - Trench City';
include __DIR__ . '/../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>
<div class="tc-page">
    <div class="tc-card">
        <h1 class="tc-page-title">Items Hub</h1>
        <p class="tc-lock-message">Manage your gear from one place. Visit the market to acquire equipment or open your inventory to equip and organize.</p>
        <div class="tc-button-row">
            <a class="btn btn-primary" href="/market.php">Visit Market</a>
            <a class="btn btn-secondary" href="/inventory.php">Open Inventory</a>
        </div>
        <p class="tc-lock-subtext">Full item management will unlock later in the build order. For now, these shortcuts keep navigation tight.</p>
    </div>
</div>
<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>

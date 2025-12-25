<?php
require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

$tc_page_title = 'Enemies - Trench City';
include __DIR__ . '/../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>
<div class="tc-page">
    <div class="tc-card">
        <h1 class="tc-page-title">Enemies</h1>
        <p class="tc-lock-message">Locked until build phase reached.</p>
    </div>
</div>
<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>

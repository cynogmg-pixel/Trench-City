<?php
require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

$tc_page_title = 'Rules - Trench City';
include __DIR__ . '/../includes/postlogin-header.php';
?>
<div class="tc-page">
    <div class="tc-card">
        <h1 class="tc-page-title">Rules</h1>
        <p class="tc-lock-message">Locked until build phase reached.</p>
    </div>
</div>
<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>

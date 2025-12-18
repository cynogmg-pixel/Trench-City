<?php
require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

$tc_page_title = 'Community Events - Trench City';
include __DIR__ . '/../includes/postlogin-header.php';
?>
<div class="tc-page">
    <div class="tc-card">
        <h1 class="tc-page-title">Community Events</h1>
        <p class="tc-lock-message">Locked until build phase reached.</p>
    </div>
</div>
<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>

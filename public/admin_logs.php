<?php
require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

$tc_page_title = 'Admin Logs - Trench City';
include __DIR__ . '/../includes/postlogin-header.php';
?>
<div class="main-content">
    <div class="content-wrapper">
        <div class="tc-card">
            <h1 class="tc-page-title">Admin Logs</h1>
            <p>Locked until build phase reached.</p>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>

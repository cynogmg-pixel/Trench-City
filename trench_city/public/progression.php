<?php
require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

$tc_page_title = 'Progression - Trench City';
include __DIR__ . '/../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>
<div class="main-content">
    <div class="content-wrapper">
        <div class="tc-card">
            <h1 class="tc-page-title">Progression</h1>
            <p>Locked until build phase reached.</p>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>

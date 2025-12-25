<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);

$stats = [
    'jobs' => null,
    'active_jobs' => null,
    'employed' => null,
    'job_actions_24h' => null,
];

if ($db && tc_admin_table_exists($db, 'jobs')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM jobs");
        $stats['jobs'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['jobs'] = null;
    }

    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM jobs WHERE is_active = 1");
        $stats['active_jobs'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['active_jobs'] = null;
    }
}

if ($db && tc_admin_table_exists($db, 'user_current_job')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM user_current_job");
        $stats['employed'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['employed'] = null;
    }
}

if ($db && tc_admin_table_exists($db, 'user_job_history')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM user_job_history WHERE worked_at >= (NOW() - INTERVAL 1 DAY)");
        $stats['job_actions_24h'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['job_actions_24h'] = null;
    }
}

$section_title = 'Jobs / Companies / Factions';
$section_description = 'Admin tooling for factions, wars, and company payroll audits.';
$section_features = [
    'Create or rename factions and resolve disputes.',
    'Force-end wars and reset chains (future modules).',
    'Fix broken employment states and payroll audits.',
];
$section_notes = [
    'Companies and factions require additional tables before edits can go live.',
];

$tc_page_title = 'Owner Panel - Jobs & Factions';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Jobs, Companies &amp; Factions</h1>
            <p class="content-description">Admin controls for employment, payroll, and faction management.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>
        <?php include __DIR__ . '/../../includes/admin_section.php'; ?>

        <div class="grid grid-3" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Jobs Catalog</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['jobs'] !== null ? number_format($stats['jobs']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Total job entries</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Active Jobs</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['active_jobs'] !== null ? number_format($stats['active_jobs']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Open roles</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Employed Users</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['employed'] !== null ? number_format($stats['employed']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Current jobs assigned</div>
                </div>
            </div>
        </div>

        <div class="tc-card" style="margin-top: 1.5rem;">
            <div style="padding: 1.5rem;">
                <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Job Activity 24h</h2>
                <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                    <?php echo $stats['job_actions_24h'] !== null ? number_format($stats['job_actions_24h']) : 'N/A'; ?>
                </div>
                <div style="color: #9CA3AF; margin-top: 0.5rem;">Work logs recorded</div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

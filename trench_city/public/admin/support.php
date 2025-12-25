<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);
$columns = tc_admin_user_columns($db);

$stats = [
    'pending_verifications' => null,
    'mail_last_24h' => null,
    'recovery_requests' => null,
];

if ($db && tc_admin_table_exists($db, 'users') && in_array('email_verified', $columns, true)) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE email_verified = 0");
        $stats['pending_verifications'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['pending_verifications'] = null;
    }
}

if ($db && tc_admin_table_exists($db, 'mail_messages')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM mail_messages WHERE sent_at >= (NOW() - INTERVAL 1 DAY)");
        $stats['mail_last_24h'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['mail_last_24h'] = null;
    }
}

if ($db && tc_admin_table_exists($db, 'email_verification_logs')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM email_verification_logs WHERE verified_at IS NULL");
        $stats['recovery_requests'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $stats['recovery_requests'] = null;
    }
}

$section_title = 'Support Tools';
$section_description = 'Account recovery workflows, stuck-state helpers, and payment issue tracking.';
$section_features = [
    'Unstick travel, reset timers, and clear broken missions.',
    'Account recovery reviews with ownership proof notes.',
    'Payment issues and manual credit review (audited).',
    'Canned response templates for common support needs.',
];
$section_notes = [
    'Recovery and payment workflows require additional tables and approvals.',
];

$tc_page_title = 'Owner Panel - Support';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Support Tools</h1>
            <p class="content-description">Handle account recovery, stuck-state fixes, and support responses.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>
        <?php include __DIR__ . '/../../includes/admin_section.php'; ?>

        <div class="grid grid-3" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Unverified Accounts</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['pending_verifications'] !== null ? number_format($stats['pending_verifications']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Email verification pending</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Mail Volume 24h</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['mail_last_24h'] !== null ? number_format($stats['mail_last_24h']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Messages sent</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Recovery Queue</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['recovery_requests'] !== null ? number_format($stats['recovery_requests']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Pending verification logs</div>
                </div>
            </div>
        </div>

        <div class="grid grid-2" style="margin-top: 1.5rem;">
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Stuck Player Helpers</h2>
                    <ul style="margin: 0; padding-left: 1.25rem; color: #D1D5DB;">
                        <li>Unstick travel timers and clear blocked missions.</li>
                        <li>Reset cooldowns for crimes and attacks (guarded).</li>
                        <li>Force logout all sessions (needs session map).</li>
                    </ul>
                </div>
            </div>
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Response Templates</h2>
                    <ul style="margin: 0; padding-left: 1.25rem; color: #D1D5DB;">
                        <li>Account recovery acknowledgment.</li>
                        <li>Payment dispute follow-up.</li>
                        <li>Behavior warning and escalation.</li>
                    </ul>
                    <div style="color: #9CA3AF; margin-top: 1rem;">Template storage can be added to the config tables.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

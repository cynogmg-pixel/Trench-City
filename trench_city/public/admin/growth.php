<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);
$columns = tc_admin_user_columns($db);

$stats = [
    'new_today' => null,
    'new_7d' => null,
    'verified_pct' => null,
    'active_7d' => null,
];

$totalUsers = null;

if ($db && tc_admin_table_exists($db, 'users')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users");
        $totalUsers = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $totalUsers = null;
    }

    if (in_array('created_at', $columns, true)) {
        try {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE created_at >= CURDATE()");
            $stats['new_today'] = (int)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $stats['new_today'] = null;
        }

        try {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE created_at >= (NOW() - INTERVAL 7 DAY)");
            $stats['new_7d'] = (int)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $stats['new_7d'] = null;
        }
    }

    if (in_array('last_login_at', $columns, true)) {
        try {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE last_login_at >= (NOW() - INTERVAL 7 DAY)");
            $stats['active_7d'] = (int)($row['total'] ?? 0);
        } catch (Throwable $e) {
            $stats['active_7d'] = null;
        }
    }

    if (in_array('email_verified', $columns, true) && $totalUsers) {
        try {
            $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE email_verified = 1");
            $verified = (int)($row['total'] ?? 0);
            $stats['verified_pct'] = $totalUsers > 0 ? round(($verified / $totalUsers) * 100, 1) : null;
        } catch (Throwable $e) {
            $stats['verified_pct'] = null;
        }
    }
}

$section_title = 'Onboarding & Growth';
$section_description = 'Track referrals, tutorials, and conversion funnels.';
$section_features = [
    'Invite and referral tracking.',
    'Tutorial progress stats and completion rates.',
    'Conversion tracking: verified email and day-1 retention.',
];
$section_notes = [
    'Referral tracking requires dedicated tables.',
];

$tc_page_title = 'Owner Panel - Growth';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Onboarding &amp; Growth</h1>
            <p class="content-description">Track conversion and onboarding funnels.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>
        <?php include __DIR__ . '/../../includes/admin_section.php'; ?>

        <div class="grid grid-4" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">New Today</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['new_today'] !== null ? number_format($stats['new_today']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Accounts created</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">New 7d</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['new_7d'] !== null ? number_format($stats['new_7d']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Accounts created</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Active 7d</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['active_7d'] !== null ? number_format($stats['active_7d']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Logged in last week</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Verified %</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['verified_pct'] !== null ? $stats['verified_pct'] . '%' : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Email verification rate</div>
                </div>
            </div>
        </div>

        <div class="tc-card" style="margin-top: 1.5rem;">
            <div style="padding: 1.5rem;">
                <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Growth Notes</h2>
                <ul style="margin: 0; padding-left: 1.25rem; color: #D1D5DB;">
                    <li>Capture referral sources and campaign tags.</li>
                    <li>Track tutorial checkpoints for drop-off insights.</li>
                    <li>Measure day-1 and day-7 retention cohorts.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

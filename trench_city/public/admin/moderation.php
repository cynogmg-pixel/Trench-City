<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);

$reportTables = ['player_reports', 'chat_reports', 'faction_reports', 'mail_reports', 'reports'];
$reportCounts = [];
$hasReports = false;

if ($db) {
    foreach ($reportTables as $table) {
        if (tc_admin_table_exists($db, $table)) {
            $hasReports = true;
            try {
                $row = $db->fetchOne("SELECT COUNT(*) AS total FROM `{$table}`");
                $reportCounts[$table] = (int)($row['total'] ?? 0);
            } catch (Throwable $e) {
                $reportCounts[$table] = null;
            }
        }
    }
}

$crimeEvidence = [];
$combatEvidence = [];
$mailEvidence = [];

if ($db && tc_admin_table_exists($db, 'crime_logs')) {
    try {
        $crimeEvidence = $db->fetchAll(
            "SELECT id, user_id, crime_id, success, created_at FROM crime_logs ORDER BY id DESC LIMIT 5"
        );
    } catch (Throwable $e) {
        $crimeEvidence = [];
    }
}

if ($db && tc_admin_table_exists($db, 'combat_logs')) {
    try {
        $combatEvidence = $db->fetchAll(
            "SELECT id, attacker_id, defender_id, outcome, created_at FROM combat_logs ORDER BY id DESC LIMIT 5"
        );
    } catch (Throwable $e) {
        $combatEvidence = [];
    }
}

if ($db && tc_admin_table_exists($db, 'mail_messages')) {
    try {
        $mailEvidence = $db->fetchAll(
            "SELECT id, from_user_id, to_user_id, subject, sent_at FROM mail_messages ORDER BY id DESC LIMIT 5"
        );
    } catch (Throwable $e) {
        $mailEvidence = [];
    }
}

$section_title = 'Moderation & Enforcement';
$section_description = 'Reports intake, evidence review, and enforcement tooling.';
$section_features = [
    'Reports queue: player, chat, faction, and mail abuse reports.',
    'Evidence viewer for message context, trade history, and combat logs.',
    'Punishment tools: warnings, mutes, bans, and cooldown actions.',
    'Auto-mod rule set for spam and scam detection.',
];
$section_notes = [];
if (!$hasReports) {
    $section_notes[] = 'Report queues are not configured yet.';
}

$tc_page_title = 'Owner Panel - Moderation';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Moderation &amp; Enforcement</h1>
            <p class="content-description">Manage reports, evidence, and player punishments.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>

        <?php include __DIR__ . '/../../includes/admin_section.php'; ?>

        <div class="grid grid-2" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Reports Queue</h2>
                </div>
                <div class="card-body">
                    <?php if ($reportCounts): ?>
                        <div style="display: grid; gap: 0.75rem;">
                            <?php foreach ($reportCounts as $table => $count): ?>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #9CA3AF;"><?php echo htmlspecialchars(str_replace('_', ' ', $table), ENT_QUOTES, 'UTF-8'); ?></span>
                                    <span style="color: #F9FAFB; font-weight: 600;">
                                        <?php echo $count !== null ? number_format($count) : 'N/A'; ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div style="color: #9CA3AF;">No report queues detected.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Enforcement Templates</h2>
                </div>
                <div class="card-body">
                    <ul style="margin: 0; padding-left: 1.25rem; color: #D1D5DB;">
                        <li>Warnings and cooldown punishments (manual templates).</li>
                        <li>Timed mutes, bans, or travel locks (requires columns).</li>
                        <li>Moderator notes and escalation tags (future).</li>
                    </ul>
                    <div style="color: #9CA3AF; margin-top: 1rem;">Link these actions to the user profile tools when schemas are added.</div>
                </div>
            </div>
        </div>

        <div class="grid grid-2" style="margin-top: 1.5rem;">
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 1rem;">Recent Crime Evidence</h2>
                    <?php if (!$crimeEvidence): ?>
                        <div style="color: #9CA3AF;">No crime logs available.</div>
                    <?php else: ?>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #374151;">
                                        <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">Log</th>
                                        <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">User</th>
                                        <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">Crime</th>
                                        <th style="padding: 0.6rem; text-align: center; color: #9CA3AF;">Success</th>
                                        <th style="padding: 0.6rem; text-align: right; color: #9CA3AF;">When</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($crimeEvidence as $row): ?>
                                        <tr style="border-bottom: 1px solid #1F2937;">
                                            <td style="padding: 0.6rem; color: #D1D5DB;">#<?php echo (int)$row['id']; ?></td>
                                            <td style="padding: 0.6rem; color: #F9FAFB;"><?php echo (int)$row['user_id']; ?></td>
                                            <td style="padding: 0.6rem; color: #D1D5DB;"><?php echo (int)$row['crime_id']; ?></td>
                                            <td style="padding: 0.6rem; text-align: center; color: #D1D5DB;">
                                                <?php echo !empty($row['success']) ? 'Yes' : 'No'; ?>
                                            </td>
                                            <td style="padding: 0.6rem; text-align: right; color: #9CA3AF;">
                                                <?php echo htmlspecialchars($row['created_at'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
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
                    <h2 style="color: #D4AF37; margin-bottom: 1rem;">Recent Combat Evidence</h2>
                    <?php if (!$combatEvidence): ?>
                        <div style="color: #9CA3AF;">No combat logs available.</div>
                    <?php else: ?>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #374151;">
                                        <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">Log</th>
                                        <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">Attacker</th>
                                        <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">Defender</th>
                                        <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">Outcome</th>
                                        <th style="padding: 0.6rem; text-align: right; color: #9CA3AF;">When</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($combatEvidence as $row): ?>
                                        <tr style="border-bottom: 1px solid #1F2937;">
                                            <td style="padding: 0.6rem; color: #D1D5DB;">#<?php echo (int)$row['id']; ?></td>
                                            <td style="padding: 0.6rem; color: #F9FAFB;"><?php echo (int)$row['attacker_id']; ?></td>
                                            <td style="padding: 0.6rem; color: #F9FAFB;"><?php echo (int)$row['defender_id']; ?></td>
                                            <td style="padding: 0.6rem; color: #D1D5DB;">
                                                <?php echo htmlspecialchars($row['outcome'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>
                                            <td style="padding: 0.6rem; text-align: right; color: #9CA3AF;">
                                                <?php echo htmlspecialchars($row['created_at'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
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

        <div class="tc-card" style="margin-top: 1.5rem;">
            <div style="padding: 1.5rem;">
                <h2 style="color: #D4AF37; margin-bottom: 1rem;">Mail Evidence Snapshot</h2>
                <?php if (!$mailEvidence): ?>
                    <div style="color: #9CA3AF;">No mail messages available.</div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #374151;">
                                    <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">ID</th>
                                    <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">From</th>
                                    <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">To</th>
                                    <th style="padding: 0.6rem; text-align: left; color: #9CA3AF;">Subject</th>
                                    <th style="padding: 0.6rem; text-align: right; color: #9CA3AF;">Sent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mailEvidence as $row): ?>
                                    <tr style="border-bottom: 1px solid #1F2937;">
                                        <td style="padding: 0.6rem; color: #D1D5DB;">#<?php echo (int)$row['id']; ?></td>
                                        <td style="padding: 0.6rem; color: #F9FAFB;"><?php echo (int)$row['from_user_id']; ?></td>
                                        <td style="padding: 0.6rem; color: #F9FAFB;"><?php echo (int)$row['to_user_id']; ?></td>
                                        <td style="padding: 0.6rem; color: #D1D5DB;"><?php echo htmlspecialchars($row['subject'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td style="padding: 0.6rem; text-align: right; color: #9CA3AF;">
                                            <?php echo htmlspecialchars($row['sent_at'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
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

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

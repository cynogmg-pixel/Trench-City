<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);

function tc_admin_fetch_config_rows($db, string $table, int $limit = 20): array
{
    if (!$db || !tc_admin_table_exists($db, $table)) {
        return [];
    }

    try {
        return $db->fetchAll("SELECT config_key, config_value, description FROM `{$table}` ORDER BY config_key ASC LIMIT {$limit}");
    } catch (Throwable $e) {
        return [];
    }
}

$configTables = [
    'bank_config' => 'Bank Config',
    'combat_config' => 'Combat Config',
    'mail_config' => 'Mail Config',
    'email_config' => 'Email Config',
];

$configData = [];
foreach ($configTables as $table => $label) {
    $configData[$table] = tc_admin_fetch_config_rows($db, $table);
}

$section_title = 'Game Config & Balance Tuning';
$section_description = 'Monitor and tune configuration values for core systems.';
$section_features = [
    'XP rates, regen rates, and drop curves.',
    'Daily/weekly events and feature flags.',
    'Economy sinks and fee tuning.',
];
$section_notes = [
    'Editing values should be guarded and audited before enabling writes.',
];

$tc_page_title = 'Owner Panel - Config';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Game Config &amp; Balance</h1>
            <p class="content-description">Review configuration tables and tuning values.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>
        <?php include __DIR__ . '/../../includes/admin_section.php'; ?>

        <div class="grid grid-2" style="margin-top: 1.5rem;">
            <?php foreach ($configTables as $table => $label): ?>
                <div class="tc-card">
                    <div style="padding: 1.5rem;">
                        <h2 style="color: #D4AF37; margin-bottom: 0.75rem;"><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></h2>
                        <?php if (!$configData[$table]): ?>
                            <div style="color: #9CA3AF;">No entries found.</div>
                        <?php else: ?>
                            <div style="overflow-x: auto;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #374151;">
                                            <th style="padding: 0.5rem; text-align: left; color: #9CA3AF;">Key</th>
                                            <th style="padding: 0.5rem; text-align: left; color: #9CA3AF;">Value</th>
                                            <th style="padding: 0.5rem; text-align: left; color: #9CA3AF;">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($configData[$table] as $row): ?>
                                            <tr style="border-bottom: 1px solid #1F2937;">
                                                <td style="padding: 0.5rem; color: #F9FAFB;">
                                                    <?php echo htmlspecialchars($row['config_key'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                                <td style="padding: 0.5rem; color: #D1D5DB;">
                                                    <?php echo htmlspecialchars($row['config_value'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                                <td style="padding: 0.5rem; color: #9CA3AF;">
                                                    <?php echo htmlspecialchars($row['description'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

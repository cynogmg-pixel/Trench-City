<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);
$columns = tc_admin_user_columns($db);

$checks = [
    'negative_balances' => null,
    'xp_level_mismatch' => null,
    'bars_out_of_range' => null,
];

if ($db && tc_admin_table_exists($db, 'users')) {
    if (in_array('cash', $columns, true) || in_array('bank_balance', $columns, true)) {
        $clauses = [];
        if (in_array('cash', $columns, true)) {
            $clauses[] = 'cash < 0';
        }
        if (in_array('bank_balance', $columns, true)) {
            $clauses[] = 'bank_balance < 0';
        }
        if ($clauses) {
            try {
                $row = $db->fetchOne("SELECT COUNT(*) AS total FROM users WHERE " . implode(' OR ', $clauses));
                $checks['negative_balances'] = (int)($row['total'] ?? 0);
            } catch (Throwable $e) {
                $checks['negative_balances'] = null;
            }
        }
    }

    if (in_array('xp', $columns, true) && in_array('level', $columns, true)) {
        try {
            $sample = $db->fetchAll("SELECT id, xp, level FROM users ORDER BY id DESC LIMIT 200");
            $mismatch = 0;
            foreach ($sample as $row) {
                $xp = (int)($row['xp'] ?? 0);
                $level = (int)($row['level'] ?? 0);
                $expected = calculateLevel($xp);
                if ($expected !== $level) {
                    $mismatch++;
                }
            }
            $checks['xp_level_mismatch'] = $mismatch;
        } catch (Throwable $e) {
            $checks['xp_level_mismatch'] = null;
        }
    }
}

if ($db && tc_admin_table_exists($db, 'player_bars')) {
    try {
        $row = $db->fetchOne(
            "SELECT COUNT(*) AS total FROM player_bars
             WHERE energy_current < 0 OR nerve_current < 0 OR happy_current < 0 OR life_current < 0
             OR energy_current > energy_max OR nerve_current > nerve_max OR happy_current > happy_max OR life_current > life_max"
        );
        $checks['bars_out_of_range'] = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $checks['bars_out_of_range'] = null;
    }
}

$section_title = 'Anti-Cheat / Exploit Detection';
$section_description = 'Integrity checks, anomaly detection, and kill switches for risky modules.';
$section_features = [
    'Rate-limit monitors and suspicious activity scoring.',
    'Duplicate account signals (IP and device matching).',
    'Integrity checks for negative values and XP-level sync.',
    'Module kill switches for crimes, market, and fights.',
];
$section_notes = [
    'Auto-mod scoring requires additional telemetry tables.',
];

$tc_page_title = 'Owner Panel - Anti-Cheat';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Anti-Cheat &amp; Exploit Detection</h1>
            <p class="content-description">Monitor abuse, detect anomalies, and isolate risky systems.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>
        <?php include __DIR__ . '/../../includes/admin_section.php'; ?>

        <div class="grid grid-3" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Negative Balances</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $checks['negative_balances'] !== null ? number_format($checks['negative_balances']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Users with cash or bank below zero</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">XP/Level Mismatch</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $checks['xp_level_mismatch'] !== null ? number_format($checks['xp_level_mismatch']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Sample of 200 newest users</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Bars Out of Range</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $checks['bars_out_of_range'] !== null ? number_format($checks['bars_out_of_range']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Energy/nerve/happy/life anomalies</div>
                </div>
            </div>
        </div>

        <div class="grid grid-2" style="margin-top: 1.5rem;">
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Suspicion Scoring</h2>
                    <ul style="margin: 0; padding-left: 1.25rem; color: #D1D5DB;">
                        <li>Rapid XP gain and impossible regen patterns.</li>
                        <li>Repeated wins or cash transfers above limits.</li>
                        <li>Referral loops and duplicate devices.</li>
                    </ul>
                    <div style="color: #9CA3AF; margin-top: 1rem;">Enable once telemetry tables are available.</div>
                </div>
            </div>
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Kill Switches</h2>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                        <button class="btn btn-ghost" type="button" disabled>Disable crimes</button>
                        <button class="btn btn-ghost" type="button" disabled>Disable market</button>
                        <button class="btn btn-ghost" type="button" disabled>Disable fights</button>
                        <button class="btn btn-ghost" type="button" disabled>Disable trading</button>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 1rem;">Kill switches require routing guards to enforce.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

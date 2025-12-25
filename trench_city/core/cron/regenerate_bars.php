<?php
/**
 * ================================================================
 * BAR REGENERATION CRON JOB
 * Trench City V2
 * ================================================================
 *
 * Run every 5 minutes via crontab:
 * 0-59/5 * * * * /usr/bin/php /var/www/trench_city/core/cron/regenerate_bars.php
 *
 * Regenerates Energy, Nerve, and Happy bars for all active players
 */

// Set timezone
date_default_timezone_set('UTC');

// Include database connection
require_once __DIR__ . '/../db.php';

$db = getDB();

// Log start
$logFile = __DIR__ . '/../../storage/logs/cron.log';
$startTime = date('Y-m-d H:i:s');
file_put_contents($logFile, "[{$startTime}] Starting bar regeneration...\n", FILE_APPEND);

try {
    // Regeneration rates (per 5 minutes)
    $energyRegen = 5;  // 5 energy per 5 minutes
    $nerveRegen = 1;   // 1 nerve per 5 minutes
    $happyDecay = 1;   // 1 happy lost per 5 minutes (if not in property)

    // Regenerate Energy and Nerve for all active players
    $affectedRows = $db->execute(
        "
        UPDATE player_bars
        SET
            energy_current = LEAST(energy_max, energy_current + :energy_regen),
            nerve_current = LEAST(nerve_max, nerve_current + :nerve_regen),
            last_regen_at = NOW()
        WHERE user_id IN (SELECT id FROM users WHERE status = 'active')
    ",
        ['energy_regen' => $energyRegen, 'nerve_regen' => $nerveRegen]
    );

    // Log success
    $endTime = date('Y-m-d H:i:s');
    file_put_contents(
        $logFile,
        "[{$endTime}] Bar regeneration complete. Updated {$affectedRows} players.\n",
        FILE_APPEND
    );

    echo "Bar regeneration complete. Updated {$affectedRows} players.\n";
    exit(0);

} catch (Exception $e) {
    $errorTime = date('Y-m-d H:i:s');
    $errorMsg = "[{$errorTime}] ERROR: " . $e->getMessage() . "\n";
    file_put_contents($logFile, $errorMsg, FILE_APPEND);
    echo $errorMsg;
    exit(1);
}

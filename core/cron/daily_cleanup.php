<?php
/**
 * ================================================================
 * DAILY CLEANUP CRON JOB
 * Trench City V2
 * ================================================================
 *
 * Run daily at 3 AM via crontab:
 * 0 3 * * * /usr/bin/php /var/www/trench_city/core/cron/daily_cleanup.php
 *
 * Performs daily maintenance:
 * - Clear expired hospital/jail times
 * - Clean old logs (30+ days)
 * - Optimize database tables
 * - Calculate daily interest (if enabled)
 */

date_default_timezone_set('UTC');
require_once __DIR__ . '/../db.php';

$db = getDB();
$logFile = __DIR__ . '/../../storage/logs/cron.log';
$startTime = date('Y-m-d H:i:s');

file_put_contents($logFile, "\n[{$startTime}] Starting daily cleanup...\n", FILE_APPEND);

try {
    // 1. Clear expired hospital/jail times
    $hospitalsCleared = $db->execute(
        "
        UPDATE users
        SET hospital_until = NULL
        WHERE hospital_until < NOW()
    "
    );

    $jailsCleared = $db->execute(
        "
        UPDATE users
        SET jail_until = NULL
        WHERE jail_until < NOW()
    "
    );

    file_put_contents($logFile, "  - Cleared {$hospitalsCleared} hospitals, {$jailsCleared} jails\n", FILE_APPEND);

    // 2. Clean old logs (keep last 30 days)
    $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));

    $trainingLogsDeleted = $db->execute(
        "DELETE FROM training_logs WHERE created_at < :threshold",
        ['threshold' => $thirtyDaysAgo]
    );

    $crimeLogsDeleted = $db->execute(
        "DELETE FROM crime_logs WHERE created_at < :threshold",
        ['threshold' => $thirtyDaysAgo]
    );

    $combatLogsDeleted = $db->execute(
        "DELETE FROM combat_logs WHERE created_at < :threshold",
        ['threshold' => $thirtyDaysAgo]
    );

    file_put_contents($logFile, "  - Deleted old logs: {$trainingLogsDeleted} training, {$crimeLogsDeleted} crime, {$combatLogsDeleted} combat\n", FILE_APPEND);

    // 3. Delete fully-deleted mail messages (both sender and recipient deleted)
    $mailDeleted = $db->execute(
        "
        DELETE FROM mail_messages
        WHERE is_deleted_by_sender = 1
        AND is_deleted_by_recipient = 1
        AND sent_at < :threshold
    ",
        ['threshold' => $thirtyDaysAgo]
    );

    file_put_contents($logFile, "  - Deleted {$mailDeleted} fully-deleted mail messages\n", FILE_APPEND);

    // 4. Optimize database tables
    $tables = ['users', 'player_stats', 'player_bars', 'combat_logs', 'bank_transactions', 'mail_messages', 'training_logs', 'crime_logs'];
    foreach ($tables as $table) {
        $db->execute("OPTIMIZE TABLE {$table}");
    }
    file_put_contents($logFile, "  - Optimized " . count($tables) . " database tables\n", FILE_APPEND);

    // 5. Calculate daily interest (if enabled)
    $interestConfig = $db->fetchOne(
        "SELECT config_value FROM bank_config WHERE config_key = 'interest_enabled' LIMIT 1"
    );
    $interestEnabled = ($interestConfig['config_value'] ?? 'false') === 'true';

    if ($interestEnabled) {
        $rateRow = $db->fetchOne(
            "SELECT config_value FROM bank_config WHERE config_key = 'interest_rate_daily' LIMIT 1"
        );
        $interestRate = (float)($rateRow['config_value'] ?? 0) / 100;

        // Apply interest to all bank accounts
        $db->beginTransaction();

        $users = $db->fetchAll(
            "
            SELECT id, username, bank_balance
            FROM users
            WHERE status = 'active' AND bank_balance > 0
        "
        );

        $totalInterest = 0;
        $usersProcessed = 0;

        foreach ($users as $user) {
            $interest = $user['bank_balance'] * $interestRate;
            if ($interest < 0.01) continue; // Skip tiny amounts

            $newBalance = $user['bank_balance'] + $interest;

            // Update balance
            $db->execute(
                "UPDATE users SET bank_balance = :balance WHERE id = :id",
                ['balance' => $newBalance, 'id' => $user['id']]
            );

            $db->execute(
                "
                INSERT INTO bank_transactions
                (user_id, transaction_type, amount, cash_after, bank_after, description)
                SELECT :user_id, 'interest', :amount, cash, :bank_after, 'Daily interest'
                FROM users WHERE id = :user_row_id
            ",
                [
                    'user_id' => $user['id'],
                    'amount' => $interest,
                    'bank_after' => $newBalance,
                    'user_row_id' => $user['id']
                ]
            );

            $totalInterest += $interest;
            $usersProcessed++;
        }

        $db->commit();
        file_put_contents($logFile, "  - Paid £" . number_format($totalInterest, 2) . " interest to {$usersProcessed} players\n", FILE_APPEND);
    }

    // Log completion
    $endTime = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[{$endTime}] Daily cleanup complete.\n", FILE_APPEND);

    echo "Daily cleanup complete.\n";
    exit(0);

} catch (Exception $e) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }

    $errorTime = date('Y-m-d H:i:s');
    $errorMsg = "[{$errorTime}] ERROR in daily cleanup: " . $e->getMessage() . "\n";
    file_put_contents($logFile, $errorMsg, FILE_APPEND);
    echo $errorMsg;
    exit(1);
}

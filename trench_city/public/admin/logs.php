<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

function tc_admin_tail_file(string $path, int $lines = 200): array
{
    if (!is_readable($path)) {
        return [];
    }

    $handle = fopen($path, 'rb');
    if (!$handle) {
        return [];
    }

    $buffer = '';
    $chunkSize = 4096;
    fseek($handle, 0, SEEK_END);
    $position = ftell($handle);

    while ($position > 0 && substr_count($buffer, "\n") <= $lines) {
        $readSize = ($position - $chunkSize) >= 0 ? $chunkSize : $position;
        $position -= $readSize;
        fseek($handle, $position);
        $buffer = fread($handle, $readSize) . $buffer;
    }

    fclose($handle);

    $buffer = trim($buffer);
    if ($buffer === '') {
        return [];
    }

    $allLines = explode("\n", $buffer);
    return array_slice($allLines, -$lines);
}

$logBase = defined('LOG_PATH') ? LOG_PATH : __DIR__ . '/../../storage/logs';
$logFile = '';
$logLines = [];

if (is_dir($logBase)) {
    $files = glob($logBase . '/info-*.log');
    if ($files) {
        usort($files, function ($a, $b) {
            return filemtime($b) <=> filemtime($a);
        });
        $logFile = $files[0] ?? '';
    }
}

if ($logFile) {
    $logLines = tc_admin_tail_file($logFile, 200);
}

$filtered = [];
foreach ($logLines as $line) {
    if (strpos($line, '[PLAYER_ACTION]') !== false) {
        $filtered[] = $line;
    }
}

$displayLines = $filtered ?: $logLines;

$tc_page_title = 'Owner Panel - Logs';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Activity Logs</h1>
            <p class="content-description">Recent player and admin actions.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>

        <div class="tc-card">
            <div style="padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2 style="color: #D4AF37; margin: 0;">Latest Entries</h2>
                    <span style="color: #9CA3AF;">
                        <?php echo $logFile ? htmlspecialchars(basename($logFile), ENT_QUOTES, 'UTF-8') : 'No log file'; ?>
                    </span>
                </div>

                <?php if (!$displayLines): ?>
                    <div style="color: #9CA3AF;">No log entries found.</div>
                <?php else: ?>
                    <div style="max-height: 420px; overflow-y: auto; background: rgba(5, 7, 11, 0.65); border: 1px solid #1F2937; border-radius: 0.5rem; padding: 1rem;">
                        <pre style="margin: 0; color: #D1D5DB; white-space: pre-wrap;">
<?php echo htmlspecialchars(implode("\n", $displayLines), ENT_QUOTES, 'UTF-8'); ?>
                        </pre>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>





<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

if (!function_exists('tc_admin_tail_file')) {
    function tc_admin_tail_file(string $path, int $lines = 300): array
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
}

if (!function_exists('tc_admin_pick_log_file')) {
    function tc_admin_pick_log_file(string $dir, array $patterns): string
    {
        $files = [];
        foreach ($patterns as $pattern) {
            $files = array_merge($files, glob(rtrim($dir, '/') . '/' . $pattern) ?: []);
        }
        if (!$files) {
            return '';
        }
        usort($files, function ($a, $b) {
            return filemtime($b) <=> filemtime($a);
        });
        return $files[0] ?? '';
    }
}

if (function_exists('safe_input')) {
    $query = safe_input('q', '', 120);
    $filter = safe_input('filter', '', 32);
} else {
    $query = trim(strip_tags($_GET['q'] ?? ''));
    $filter = trim(strip_tags($_GET['filter'] ?? ''));
}

$logBase = defined('LOG_PATH') ? LOG_PATH : __DIR__ . '/../../storage/logs';
$logFile = '';
$lines = [];

if (is_dir($logBase)) {
    $logFile = tc_admin_pick_log_file($logBase, ['info-*.log', 'info.log']);
}

if ($logFile) {
    $lines = tc_admin_tail_file($logFile, 400);
}

if ($filter === 'player_action') {
    $lines = array_values(array_filter($lines, function ($line) {
        return strpos($line, '[PLAYER_ACTION]') !== false;
    }));
} elseif ($filter === 'auth') {
    $lines = array_values(array_filter($lines, function ($line) {
        return strpos($line, '[AUTH]') !== false;
    }));
} elseif ($filter === 'admin') {
    $lines = array_values(array_filter($lines, function ($line) {
        return stripos($line, 'admin_') !== false;
    }));
}

if ($query !== '') {
    $lines = array_values(array_filter($lines, function ($line) use ($query) {
        return stripos($line, $query) !== false;
    }));
}

if (count($lines) > 200) {
    $lines = array_slice($lines, -200);
}

$tc_page_title = 'Owner Panel - Audit Logs';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Admin Action Logs</h1>
            <p class="content-description">Immutable audit trail for owner and moderator actions.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>

        <div class="tc-card">
            <div style="padding: 1.5rem;">
                <form method="get" action="/admin/audit.php" style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                    <input
                        type="text"
                        name="q"
                        placeholder="Filter logs by keyword"
                        value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>"
                        style="flex: 1; min-width: 220px; padding: 0.65rem 0.9rem; background: #1F2937; border: 1px solid #374151;
                               border-radius: 0.5rem; color: #F9FAFB;"
                    />
                    <select name="filter" style="min-width: 160px; padding: 0.65rem 0.9rem; background: #111827; border: 1px solid #374151; border-radius: 0.5rem; color: #F9FAFB;">
                        <option value="">All entries</option>
                        <option value="player_action" <?php echo $filter === 'player_action' ? 'selected' : ''; ?>>Player actions</option>
                        <option value="admin" <?php echo $filter === 'admin' ? 'selected' : ''; ?>>Admin actions</option>
                        <option value="auth" <?php echo $filter === 'auth' ? 'selected' : ''; ?>>Auth events</option>
                    </select>
                    <button class="btn btn-primary" type="submit">Apply</button>
                    <?php if ($query !== '' || $filter !== ''): ?>
                        <a class="btn btn-secondary" href="/admin/audit.php">Reset</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="tc-card" style="margin-top: 1.5rem;">
            <div style="padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2 style="color: #D4AF37; margin: 0;">Recent Entries</h2>
                    <span style="color: #9CA3AF;">
                        <?php echo $logFile ? htmlspecialchars(basename($logFile), ENT_QUOTES, 'UTF-8') : 'No log file'; ?>
                    </span>
                </div>

                <?php if (!$lines): ?>
                    <div style="color: #9CA3AF;">No matching log entries.</div>
                <?php else: ?>
                    <div style="max-height: 420px; overflow-y: auto; background: rgba(5, 7, 11, 0.65); border: 1px solid #1F2937; border-radius: 0.5rem; padding: 1rem;">
                        <pre style="margin: 0; color: #D1D5DB; white-space: pre-wrap;">
<?php echo htmlspecialchars(implode("\n", $lines), ENT_QUOTES, 'UTF-8'); ?>
                        </pre>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>





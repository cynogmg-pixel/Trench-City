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

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);

$stats = [
    'session_files' => null,
    'failed_logins' => null,
    'email_verification_required' => null,
];

$sessionDir = defined('SESSION_PATH') ? SESSION_PATH : __DIR__ . '/../../storage/sessions';
if (is_dir($sessionDir)) {
    $stats['session_files'] = count(glob($sessionDir . '/*'));
}

$logBase = defined('LOG_PATH') ? LOG_PATH : __DIR__ . '/../../storage/logs';
if (is_dir($logBase)) {
    $infoLog = tc_admin_pick_log_file($logBase, ['info-*.log', 'info.log']);
    if ($infoLog) {
        $lines = tc_admin_tail_file($infoLog, 400);
        $failed = 0;
        foreach ($lines as $line) {
            if (stripos($line, 'Failed login') !== false || stripos($line, 'failed login') !== false) {
                $failed++;
            }
        }
        $stats['failed_logins'] = $failed;
    }
}

if ($db && tc_admin_table_exists($db, 'email_config')) {
    try {
        $row = $db->fetchOne("SELECT config_value FROM email_config WHERE config_key = 'verification_required' LIMIT 1");
        if ($row && isset($row['config_value'])) {
            $value = strtolower(trim((string)$row['config_value']));
            $stats['email_verification_required'] = in_array($value, ['1', 'true', 'yes'], true);
        }
    } catch (Throwable $e) {
        $stats['email_verification_required'] = null;
    }
}

$section_title = 'Security Panel';
$section_description = 'Owner access, session control, and security telemetry.';
$section_features = [
    'Admin access allowlist and owner authentication.',
    'Session invalidation and active session review.',
    'Firewall helpers and brute-force trends.',
    '2FA enforcement roadmap for staff.',
];
$section_notes = [
    'Per-user session invalidation requires session mapping.',
];

$tc_page_title = 'Owner Panel - Security';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Security Panel</h1>
            <p class="content-description">Manage owner access and review security telemetry.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>
        <?php include __DIR__ . '/../../includes/admin_section.php'; ?>

        <div class="grid grid-3" style="margin-top: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Allowlist</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.2rem; font-weight: 700; color: #F9FAFB;">admin@trenchmade.co.uk</div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Owner email allowlist</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Session Files</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['session_files'] !== null ? number_format($stats['session_files']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Active session files</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Failed Logins</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $stats['failed_logins'] !== null ? number_format($stats['failed_logins']) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF;">Sample of latest logs</div>
                </div>
            </div>
        </div>

        <div class="grid grid-2" style="margin-top: 1.5rem;">
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Email Verification</h2>
                    <div style="font-size: 1.4rem; font-weight: 700; color: #F9FAFB;">
                        <?php
                        if ($stats['email_verification_required'] === null) {
                            echo 'N/A';
                        } else {
                            echo $stats['email_verification_required'] ? 'Required' : 'Optional';
                        }
                        ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Config flag status</div>
                </div>
            </div>
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Security Actions</h2>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                        <button class="btn btn-ghost" type="button" disabled>Invalidate sessions</button>
                        <button class="btn btn-ghost" type="button" disabled>Rotate keys</button>
                        <button class="btn btn-ghost" type="button" disabled>Enable 2FA</button>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 1rem;">Security actions require dedicated tooling before enabling.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

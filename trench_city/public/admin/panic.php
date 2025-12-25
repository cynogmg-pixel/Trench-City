<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$messages = [];
$errors = [];

$catalog = function_exists('tc_ops_flag_catalog') ? tc_ops_flag_catalog() : [];
$grouped = [];
foreach ($catalog as $flag => $meta) {
    $category = $meta['category'] ?? 'Other';
    $grouped[$category][$flag] = $meta['label'] ?? $flag;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['panic_action'])) {
    if (!csrf_check($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token.';
    } else {
        $action = $_POST['panic_action'];
        if ($action === 'toggle_flag') {
            $flag = (string)($_POST['flag'] ?? '');
            if (!array_key_exists($flag, $flags)) {
                $errors[] = 'Unknown flag.';
            } else {
                $enabled = !tc_is_ops_flag_enabled($flag);
                if (tc_set_ops_flag($flag, $enabled)) {
                    $messages[] = ($enabled ? 'Enabled ' : 'Disabled ') . $flags[$flag] . '.';
                } else {
                    $errors[] = 'Failed to update flag.';
                }
            }
        } elseif ($action === 'logout_all') {
            $confirm = trim((string)($_POST['confirm_text'] ?? ''));
            if ($confirm !== 'FORCE LOGOUT') {
                $errors[] = 'Confirmation text does not match.';
            } else {
                $sessionDir = defined('SESSION_PATH') ? SESSION_PATH : __DIR__ . '/../../storage/sessions';
                if (!is_dir($sessionDir)) {
                    $errors[] = 'Session directory not found.';
                } else {
                    $files = glob($sessionDir . '/*') ?: [];
                    $deleted = 0;
                    foreach ($files as $file) {
                        if (is_file($file) && @unlink($file)) {
                            $deleted++;
                        }
                    }
                    $messages[] = 'Force logout executed. Sessions cleared: ' . number_format($deleted) . '.';
                }
            }
        }
    }
}

$section_title = 'Panic Buttons';
$section_description = 'Emergency toggles for critical systems.';
$section_features = [
    'Disable market, crimes, trading, and fighting instantly.',
    'Freeze economy and lock new registrations.',
    'Force logout all users and lock combat.',
];
$section_notes = [
    'Kill switches require front-end guards before enabling.',
];

$tc_page_title = 'Owner Panel - Panic';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Panic Buttons</h1>
            <p class="content-description">Emergency shutdown controls for critical systems.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>
        <?php include __DIR__ . '/../../includes/admin_section.php'; ?>

        <?php if ($messages): ?>
            <div class="alert alert-success">
                <div class="alert-content">
                    <div class="alert-message"><?php echo htmlspecialchars(implode(' ', $messages), ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="alert alert-warning">
                <div class="alert-content">
                    <div class="alert-message"><?php echo htmlspecialchars(implode(' ', $errors), ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <div style="display: grid; gap: 1.5rem; margin-top: 1.5rem;">
            <?php foreach ($grouped as $category => $flags): ?>
                <div class="tc-card">
                    <div style="padding: 1.5rem;">
                        <h2 style="color: #D4AF37; margin-bottom: 0.75rem;"><?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?></h2>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                            <?php foreach ($flags as $flagKey => $label): ?>
                                <?php $active = tc_is_ops_flag_enabled($flagKey); ?>
                                <form method="post" action="/admin/panic.php">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                                    <input type="hidden" name="panic_action" value="toggle_flag" />
                                    <input type="hidden" name="flag" value="<?php echo htmlspecialchars($flagKey, ENT_QUOTES, 'UTF-8'); ?>" />
                                    <button class="btn <?php echo $active ? 'btn-danger' : 'btn-secondary'; ?>" type="submit">
                                        <?php echo $active ? 'Disable' : 'Enable'; ?> <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                                    </button>
                                </form>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="tc-card">
                <div style="padding: 1.5rem; display: grid; gap: 1rem;">
                    <div style="color: #9CA3AF;">Active flags apply immediately to their modules.</div>
                    <form method="post" action="/admin/panic.php" style="display: grid; gap: 0.75rem; max-width: 420px;">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="panic_action" value="logout_all" />
                        <label style="display: grid; gap: 0.35rem; color: #9CA3AF;">
                            <span>Force logout all users</span>
                            <input type="text" name="confirm_text" placeholder="Type FORCE LOGOUT" style="padding: 0.6rem 0.8rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;" />
                        </label>
                        <button class="btn btn-danger" type="submit">Force Logout</button>
                    </form>
                    <div>
                        <a class="btn btn-primary" href="/admin/maintenance.php">Go to Maintenance</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

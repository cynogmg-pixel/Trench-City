<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);

$mailSample = [];
$mailCount = null;
$messages = [];
$errors = [];

$currentAnnouncement = function_exists('tc_get_global_announcement') ? tc_get_global_announcement() : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['announcement_action'])) {
    if (!csrf_check($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid security token.';
    } else {
        $action = $_POST['announcement_action'];
        if ($action === 'clear') {
            if (function_exists('tc_set_global_announcement') && tc_set_global_announcement(null)) {
                $messages[] = 'Announcement cleared.';
                $currentAnnouncement = null;
            } else {
                $errors[] = 'Failed to clear announcement.';
            }
        } elseif ($action === 'save') {
            $title = trim((string)($_POST['announcement_title'] ?? ''));
            $message = trim((string)($_POST['announcement_message'] ?? ''));
            $type = trim((string)($_POST['announcement_type'] ?? 'info'));
            $expiresAt = trim((string)($_POST['announcement_expires'] ?? ''));

            if ($message === '') {
                $errors[] = 'Announcement message is required.';
            } else {
                $payload = [
                    'title' => $title,
                    'message' => $message,
                    'type' => in_array($type, ['info', 'warning', 'success'], true) ? $type : 'info',
                    'expires_at' => $expiresAt !== '' ? $expiresAt : null,
                ];

                if (function_exists('tc_set_global_announcement') && tc_set_global_announcement($payload)) {
                    $messages[] = 'Announcement saved.';
                    $currentAnnouncement = $payload;
                } else {
                    $errors[] = 'Failed to save announcement.';
                }
            }
        }
    }
}

if ($db && tc_admin_table_exists($db, 'mail_messages')) {
    try {
        $row = $db->fetchOne("SELECT COUNT(*) AS total FROM mail_messages WHERE sent_at >= (NOW() - INTERVAL 1 DAY)");
        $mailCount = (int)($row['total'] ?? 0);
    } catch (Throwable $e) {
        $mailCount = null;
    }

    try {
        $mailSample = $db->fetchAll(
            "SELECT id, from_user_id, to_user_id, subject, sent_at FROM mail_messages ORDER BY id DESC LIMIT 5"
        );
    } catch (Throwable $e) {
        $mailSample = [];
    }
}

$section_title = 'Content & Messaging';
$section_description = 'Global announcements, targeted blasts, and mail tooling.';
$section_features = [
    'Global announcements (banner, modal, news post).',
    'Targeted message blasts by level, faction, or activity.',
    'System mail tools and abusive mail review.',
    'Notification testing for email and in-game alerts.',
];
$section_notes = [
    'Announcement delivery requires front-end hooks.',
];

$tc_page_title = 'Owner Panel - Content';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Content &amp; Messaging</h1>
            <p class="content-description">Launch announcements and manage outbound communications.</p>
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

        <div class="grid grid-2" style="margin-top: 1.5rem;">
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Announcement Controls</h2>
                    <form method="post" action="/admin/content.php" style="display: grid; gap: 0.75rem;">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <label style="display: grid; gap: 0.35rem; color: #9CA3AF;">
                            <span>Title</span>
                            <input type="text" name="announcement_title" value="<?php echo htmlspecialchars((string)($currentAnnouncement['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" style="padding: 0.6rem 0.8rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;" />
                        </label>
                        <label style="display: grid; gap: 0.35rem; color: #9CA3AF;">
                            <span>Message</span>
                            <textarea name="announcement_message" rows="3" required style="padding: 0.6rem 0.8rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;"><?php echo htmlspecialchars((string)($currentAnnouncement['message'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </label>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                            <label style="display: grid; gap: 0.35rem; color: #9CA3AF;">
                                <span>Type</span>
                                <select name="announcement_type" style="min-width: 160px; padding: 0.55rem 0.75rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;">
                                    <?php $selectedType = $currentAnnouncement['type'] ?? 'info'; ?>
                                    <option value="info" <?php echo $selectedType === 'info' ? 'selected' : ''; ?>>Info</option>
                                    <option value="warning" <?php echo $selectedType === 'warning' ? 'selected' : ''; ?>>Warning</option>
                                    <option value="success" <?php echo $selectedType === 'success' ? 'selected' : ''; ?>>Success</option>
                                </select>
                            </label>
                            <label style="display: grid; gap: 0.35rem; color: #9CA3AF;">
                                <span>Expires (optional)</span>
                                <input type="text" name="announcement_expires" placeholder="YYYY-MM-DD HH:MM:SS" value="<?php echo htmlspecialchars((string)($currentAnnouncement['expires_at'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" style="min-width: 220px; padding: 0.6rem 0.8rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;" />
                            </label>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                            <button class="btn btn-primary" type="submit" name="announcement_action" value="save">Save Announcement</button>
                            <button class="btn btn-secondary" type="submit" name="announcement_action" value="clear">Clear Announcement</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tc-card">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 0.75rem;">Mail Volume 24h</h2>
                    <div style="font-size: 1.6rem; font-weight: 700; color: #F9FAFB;">
                        <?php echo $mailCount !== null ? number_format($mailCount) : 'N/A'; ?>
                    </div>
                    <div style="color: #9CA3AF; margin-top: 0.5rem;">Messages sent</div>
                </div>
            </div>
        </div>

        <div class="tc-card" style="margin-top: 1.5rem;">
            <div style="padding: 1.5rem;">
                <h2 style="color: #D4AF37; margin-bottom: 1rem;">Latest Mail Sample</h2>
                <?php if (!$mailSample): ?>
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
                                <?php foreach ($mailSample as $row): ?>
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

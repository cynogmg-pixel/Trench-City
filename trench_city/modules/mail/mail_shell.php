<?php
/**
 * MAIL/MESSAGING SYSTEM - Trench City V2
 */

require_once __DIR__ . '/../../core/bootstrap.php';
requireLogin();

$userId = currentUserId();
$db = getDB();

function getMailConfig(string $key, $default = null) {
    global $db;
    $row = $db->fetchOne(
        "SELECT config_value FROM mail_config WHERE config_key = :key LIMIT 1",
        ['key' => $key]
    );
    return $row['config_value'] ?? $default;
}

function getUnreadCount(int $userId): int {
    global $db;
    $row = $db->fetchOne(
        "SELECT COUNT(*) as unread_count FROM mail_messages WHERE to_user_id = :user_id AND is_read = 0 AND is_deleted_by_recipient = 0",
        ['user_id' => $userId]
    );
    return (int)($row['unread_count'] ?? 0);
}

function getInbox(int $userId, int $limit = 50): array {
    global $db;
    return $db->fetchAll("
        SELECT m.*, u.username as sender_name
        FROM mail_messages m
        JOIN users u ON m.from_user_id = u.id
        WHERE m.to_user_id = :user_id AND m.is_deleted_by_recipient = 0
        ORDER BY m.sent_at DESC
        LIMIT :limit_rows
    ", ['user_id' => $userId, 'limit_rows' => $limit]);
}

function getSentMessages(int $userId, int $limit = 50): array {
    global $db;
    return $db->fetchAll("
        SELECT m.*, u.username as recipient_name
        FROM mail_messages m
        JOIN users u ON m.to_user_id = u.id
        WHERE m.from_user_id = :user_id AND m.is_deleted_by_sender = 0
        ORDER BY m.sent_at DESC
        LIMIT :limit_rows
    ", ['user_id' => $userId, 'limit_rows' => $limit]);
}

function getMessage(int $messageId, int $userId): ?array {
    global $db;
    return $db->fetchOne("
        SELECT m.*, u_from.username as sender_name, u_to.username as recipient_name
        FROM mail_messages m
        JOIN users u_from ON m.from_user_id = u_from.id
        JOIN users u_to ON m.to_user_id = u_to.id
        WHERE m.id = :message_id AND (m.from_user_id = :user_id OR m.to_user_id = :user_id)
    ", ['message_id' => $messageId, 'user_id' => $userId]);
}

function sendMessage(int $fromUserId, string $toUsername, string $subject, string $body): array {
    global $db;
    $subject = trim($subject);
    $body = trim($body);
    $toUsername = trim($toUsername);

    if (empty($subject)) return ['success' => false, 'error' => 'Subject is required'];
    if (empty($body)) return ['success' => false, 'error' => 'Message body is required'];
    if (empty($toUsername)) return ['success' => false, 'error' => 'Recipient is required'];

    $recipient = $db->fetchOne(
        "SELECT id, username FROM users WHERE username = :username AND status = 'active' LIMIT 1",
        ['username' => $toUsername]
    );

    if (!$recipient) return ['success' => false, 'error' => 'Recipient not found'];
    if ($recipient['id'] == $fromUserId) return ['success' => false, 'error' => 'Cannot send mail to yourself'];

    try {
        $db->execute(
            "INSERT INTO mail_messages (from_user_id, to_user_id, subject, body) VALUES (:from_user_id, :to_user_id, :subject, :body)",
            [
                'from_user_id' => $fromUserId,
                'to_user_id' => $recipient['id'],
                'subject' => $subject,
                'body' => $body
            ]
        );
        return ['success' => true, 'message' => "Message sent to {$recipient['username']}", 'message_id' => $db->lastInsertId()];
    } catch (Exception $e) {
        return ['success' => false, 'error' => 'Failed to send message'];
    }
}

function markAsRead(int $messageId, int $userId): bool {
    global $db;
    $db->execute(
        "UPDATE mail_messages SET is_read = 1, read_at = NOW() WHERE id = :id AND to_user_id = :user_id",
        ['id' => $messageId, 'user_id' => $userId]
    );
    return true;
}

function deleteMessage(int $messageId, int $userId): bool {
    global $db;
    $db->execute(
        "
        UPDATE mail_messages
        SET is_deleted_by_sender = CASE WHEN from_user_id = :user_id THEN 1 ELSE is_deleted_by_sender END,
            is_deleted_by_recipient = CASE WHEN to_user_id = :user_id THEN 1 ELSE is_deleted_by_recipient END
        WHERE id = :id AND (from_user_id = :user_id OR to_user_id = :user_id)
    ",
        ['user_id' => $userId, 'id' => $messageId]
    );
    return true;
}

$action = $_POST['action'] ?? $_GET['action'] ?? 'inbox';
$message = '';
$error = '';
$viewMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token. Please refresh the page and try again.';
    } else {
        switch ($action) {
            case 'send':
                $result = sendMessage($userId, $_POST['to_username'] ?? '', $_POST['subject'] ?? '', $_POST['body'] ?? '');
                if ($result['success']) {
                    $message = $result['message'];
                    $action = 'sent';
                } else {
                    $error = $result['error'];
                    $action = 'compose';
                }
                break;
            case 'delete':
                $msgId = (int)($_POST['message_id'] ?? 0);
                if (deleteMessage($msgId, $userId)) {
                    $message = 'Message deleted';
                } else {
                    $error = 'Failed to delete message';
                }
                break;
        }
    }
}

if ($action === 'read') {
    $msgId = (int)($_GET['id'] ?? 0);
    $viewMessage = getMessage($msgId, $userId);
    if ($viewMessage && $viewMessage['to_user_id'] == $userId && !$viewMessage['is_read']) {
        markAsRead($msgId, $userId);
        $viewMessage['is_read'] = 1;
    }
}

$unreadCount = getUnreadCount($userId);
$inbox = ($action === 'inbox' || $action === 'read') ? getInbox($userId) : [];
$sent = ($action === 'sent') ? getSentMessages($userId) : [];
$toUsername = $_GET['to'] ?? '';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$tc_page_title = 'Mail - Trench City';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<main class="tc-main-content">
        <h1 class="tc-page-title">📧 Mail <?php if ($unreadCount > 0): ?><span style="background:#D4AF37;color:#000;padding:0.25rem 0.5rem;border-radius:0.25rem;font-size:0.875rem;margin-left:0.5rem;"><?= $unreadCount ?></span><?php endif; ?></h1>

        <?php if ($message): ?><div class="tc-alert tc-alert--success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <?php if ($error): ?><div class="tc-alert tc-alert--danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>

        <div class="tc-card" style="margin-bottom:1rem;">
            <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                <a href="?action=inbox" class="tc-btn tc-btn--<?= $action==='inbox'||$action==='read'?'primary':'secondary'?>">📥 Inbox<?php if($unreadCount>0):?>(<?=$unreadCount?>)<?php endif;?></a>
                <a href="?action=sent" class="tc-btn tc-btn--<?=$action==='sent'?'primary':'secondary'?>">📤 Sent</a>
                <a href="?action=compose" class="tc-btn tc-btn--<?=$action==='compose'?'primary':'secondary'?>">✉️ Compose</a>
            </div>
        </div>

        <?php if($action==='read'&&$viewMessage):?>
            <div class="tc-card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
                    <h2><?=htmlspecialchars($viewMessage['subject'])?></h2>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="message_id" value="<?=$viewMessage['id']?>">
                        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                        <button type="submit" class="tc-btn tc-btn--danger tc-btn--sm" onclick="return confirm('Delete?')">🗑️ Delete</button>
                    </form>
                </div>
                <div style="border-bottom:1px solid rgba(255,255,255,0.3);padding-bottom:1rem;margin-bottom:1rem;">
                    <p><strong>From:</strong> <a href="/profile.php?id=<?=$viewMessage['from_user_id']?>"><?=htmlspecialchars($viewMessage['sender_name'])?></a></p>
                    <p><strong>To:</strong> <a href="/profile.php?id=<?=$viewMessage['to_user_id']?>"><?=htmlspecialchars($viewMessage['recipient_name'])?></a></p>
                    <p><strong>Sent:</strong> <?=date('M j, Y g:i A',strtotime($viewMessage['sent_at']))?></p>
                </div>
                <div style="white-space:pre-wrap;line-height:1.6;"><?=htmlspecialchars($viewMessage['body'])?></div>
                <div style="margin-top:1.5rem;">
                    <a href="?action=compose&to=<?=urlencode($viewMessage['sender_name'])?>" class="tc-btn tc-btn--primary">↩️ Reply</a>
                    <a href="?action=inbox" class="tc-btn tc-btn--secondary">← Back</a>
                </div>
            </div>
        <?php elseif($action==='compose'):?>
            <div class="tc-card">
                <h2>✉️ Compose Message</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="send">
                    <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                    <div class="tc-form-group">
                        <label>To (Username)</label>
                        <input type="text" name="to_username" class="tc-input" value="<?=htmlspecialchars($toUsername)?>" required>
                    </div>
                    <div class="tc-form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" class="tc-input" maxlength="255" required>
                    </div>
                    <div class="tc-form-group">
                        <label>Message</label>
                        <textarea name="body" class="tc-input" rows="10" maxlength="5000" required></textarea>
                        <small>Max 5000 characters</small>
                    </div>
                    <button type="submit" class="tc-btn tc-btn--primary">📤 Send</button>
                    <a href="?action=inbox" class="tc-btn tc-btn--secondary">Cancel</a>
                </form>
            </div>
        <?php elseif($action==='sent'):?>
            <div class="tc-card">
                <h2>📤 Sent Messages</h2>
                <?php if(empty($sent)):?>
                    <p>No sent messages.</p>
                <?php else:?>
                    <table class="tc-table">
                        <thead><tr><th>To</th><th>Subject</th><th>Sent</th><th>Action</th></tr></thead>
                        <tbody>
                            <?php foreach($sent as $msg):?>
                                <tr>
                                    <td><?=htmlspecialchars($msg['recipient_name'])?></td>
                                    <td><?=htmlspecialchars($msg['subject'])?></td>
                                    <td><?=date('M j, g:i A',strtotime($msg['sent_at']))?></td>
                                    <td><a href="?action=read&id=<?=$msg['id']?>" class="tc-btn tc-btn--sm tc-btn--primary">View</a></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                <?php endif;?>
            </div>
        <?php else:?>
            <div class="tc-card">
                <h2>📥 Inbox</h2>
                <?php if(empty($inbox)):?>
                    <p>No messages in your inbox.</p>
                <?php else:?>
                    <table class="tc-table">
                        <thead><tr><th>Status</th><th>From</th><th>Subject</th><th>Received</th><th>Action</th></tr></thead>
                        <tbody>
                            <?php foreach($inbox as $msg):?>
                                <tr style="<?=!$msg['is_read']?'font-weight:600;background-color:rgba(212,175,55,0.25);':''?>">
                                    <td><?=!$msg['is_read']?'🆕':'📖'?></td>
                                    <td><?=htmlspecialchars($msg['sender_name'])?></td>
                                    <td><?=htmlspecialchars($msg['subject'])?></td>
                                    <td><?=date('M j, g:i A',strtotime($msg['sent_at']))?></td>
                                    <td><a href="?action=read&id=<?=$msg['id']?>" class="tc-btn tc-btn--sm tc-btn--primary">Read</a></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                <?php endif;?>
            </div>
        <?php endif;?>
</main>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>






<?php
/**
 * ================================================================
 * BANK SYSTEM - BANKING & FINANCIAL MANAGEMENT
 * Trench City V2 Master Skeleton
 * ================================================================
 *
 * Features:
 * - Deposit cash to bank account
 * - Withdraw cash from bank
 * - Player-to-player transfers
 * - Transaction history
 * - Transfer fees
 *
 * @version 1.0.0
 */

require_once __DIR__ . '/../../core/bootstrap.php';
requireLogin();

$userId = currentUserId();
$db = getDB();

function getBankConfig(string $key, $default = null) {
    global $db;
    $row = $db->fetchOne(
        "SELECT config_value FROM bank_config WHERE config_key = :key LIMIT 1",
        ['key' => $key]
    );
    return $row['config_value'] ?? $default;
}

function logBankTransaction(int $userId, string $type, float $amount, float $cashAfter, float $bankAfter, ?int $transferUserId = null, ?string $description = null): bool {
    global $db;
    $transferTo = ($type === 'transfer_send') ? $transferUserId : null;
    $transferFrom = ($type === 'transfer_receive') ? $transferUserId : null;

    $db->execute(
        "
        INSERT INTO bank_transactions
        (user_id, transaction_type, amount, cash_after, bank_after, transfer_to_user_id, transfer_from_user_id, description)
        VALUES (:user_id, :type, :amount, :cash_after, :bank_after, :transfer_to, :transfer_from, :description)
    ",
        [
            'user_id' => $userId,
            'type' => $type,
            'amount' => $amount,
            'cash_after' => $cashAfter,
            'bank_after' => $bankAfter,
            'transfer_to' => $transferTo,
            'transfer_from' => $transferFrom,
            'description' => $description
        ]
    );

    return true;
}

function depositCash(int $userId, float $amount): array {
    global $db;
    if ($amount <= 0) return ['success' => false, 'error' => 'Invalid amount'];

    $user = getUser($userId);
    if ($user['cash'] < $amount) return ['success' => false, 'error' => 'Insufficient cash'];

    $db->beginTransaction();
    try {
        $db->execute(
            "UPDATE users SET cash = cash - :amount, bank_balance = bank_balance + :amount WHERE id = :id",
            ['amount' => $amount, 'id' => $userId]
        );
        $updatedUser = getUser($userId);
        logBankTransaction($userId, 'deposit', $amount, $updatedUser['cash'], $updatedUser['bank_balance'], null, "Deposited �" . number_format($amount, 2));
        $db->commit();
        return ['success' => true, 'message' => "Successfully deposited �" . formatCash($amount), 'new_cash' => $updatedUser['cash'], 'new_bank' => $updatedUser['bank_balance']];
    } catch (Exception $e) {
        $db->rollBack();
        return ['success' => false, 'error' => 'Transaction failed'];
    }
}

function withdrawCash(int $userId, float $amount): array {
    global $db;
    if ($amount <= 0) return ['success' => false, 'error' => 'Invalid amount'];

    $user = getUser($userId);
    if ($user['bank_balance'] < $amount) return ['success' => false, 'error' => 'Insufficient bank balance'];

    $db->beginTransaction();
    try {
        $db->execute(
            "UPDATE users SET cash = cash + :amount, bank_balance = bank_balance - :amount WHERE id = :id",
            ['amount' => $amount, 'id' => $userId]
        );
        $updatedUser = getUser($userId);
        logBankTransaction($userId, 'withdraw', $amount, $updatedUser['cash'], $updatedUser['bank_balance'], null, "Withdrew �" . number_format($amount, 2));
        $db->commit();
        return ['success' => true, 'message' => "Successfully withdrew �" . formatCash($amount), 'new_cash' => $updatedUser['cash'], 'new_bank' => $updatedUser['bank_balance']];
    } catch (Exception $e) {
        $db->rollBack();
        return ['success' => false, 'error' => 'Transaction failed'];
    }
}

function transferMoney(int $fromUserId, string $toUsername, float $amount): array {
    global $db;
    if ($amount <= 0) return ['success' => false, 'error' => 'Invalid amount'];

    $recipient = $db->fetchOne(
        "SELECT id, username, status FROM users WHERE username = :username AND status = 'active' LIMIT 1",
        ['username' => $toUsername]
    );

    if (!$recipient) return ['success' => false, 'error' => 'Recipient not found'];
    if ($recipient['id'] == $fromUserId) return ['success' => false, 'error' => 'Cannot transfer to yourself'];

    $feePercent = (float)getBankConfig('transfer_fee_percent', 1) / 100;
    $feeMin = (float)getBankConfig('transfer_fee_min', 100);
    $fee = max($feeMin, $amount * $feePercent);
    $totalDeducted = $amount + $fee;

    $sender = getUser($fromUserId);
    if ($sender['cash'] < $totalDeducted) return ['success' => false, 'error' => "Insufficient cash. Need �" . formatCash($totalDeducted) . " (inc. �" . formatCash($fee) . " fee)"];

    $db->beginTransaction();
    try {
        $db->execute(
            "UPDATE users SET cash = cash - :amount WHERE id = :id",
            ['amount' => $totalDeducted, 'id' => $fromUserId]
        );
        $db->execute(
            "UPDATE users SET cash = cash + :amount WHERE id = :id",
            ['amount' => $amount, 'id' => $recipient['id']]
        );

        $updatedSender = getUser($fromUserId);
        $updatedRecipient = getUser($recipient['id']);

        logBankTransaction($fromUserId, 'transfer_send', $amount, $updatedSender['cash'], $updatedSender['bank_balance'], $recipient['id'], "Sent to {$recipient['username']} (fee: �" . number_format($fee, 2) . ")");
        logBankTransaction($recipient['id'], 'transfer_receive', $amount, $updatedRecipient['cash'], $updatedRecipient['bank_balance'], $fromUserId, "Received from {$sender['username']}");

        $db->commit();
        return ['success' => true, 'message' => "Sent �" . formatCash($amount) . " to {$recipient['username']} (fee: �" . formatCash($fee) . ")", 'new_cash' => $updatedSender['cash']];
    } catch (Exception $e) {
        $db->rollBack();
        return ['success' => false, 'error' => 'Transfer failed'];
    }
}

function getTransactionHistory(int $userId, int $limit = 20): array {
    global $db;
    return $db->fetchAll(
        "
        SELECT bt.*,
            CASE WHEN bt.transaction_type = 'transfer_send' THEN u_to.username
                 WHEN bt.transaction_type = 'transfer_receive' THEN u_from.username ELSE NULL END as other_username
        FROM bank_transactions bt
        LEFT JOIN users u_to ON bt.transfer_to_user_id = u_to.id
        LEFT JOIN users u_from ON bt.transfer_from_user_id = u_from.id
        WHERE bt.user_id = :user_id
        ORDER BY bt.created_at DESC
        LIMIT :limit_rows
    ",
        ['user_id' => $userId, 'limit_rows' => $limit]
    );
}

$action = $_POST['action'] ?? '';
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token. Please refresh the page and try again.';
    } else {
        switch ($action) {
            case 'deposit':
                $result = depositCash($userId, (float)($_POST['amount'] ?? 0));
                $result['success'] ? $message = $result['message'] : $error = $result['error'];
                break;
            case 'withdraw':
                $result = withdrawCash($userId, (float)($_POST['amount'] ?? 0));
                $result['success'] ? $message = $result['message'] : $error = $result['error'];
                break;
            case 'transfer':
                $result = transferMoney($userId, trim($_POST['to_username'] ?? ''), (float)($_POST['amount'] ?? 0));
                $result['success'] ? $message = $result['message'] : $error = $result['error'];
                break;
        }
    }
}

$user = getUser($userId);
$history = getTransactionHistory($userId, 20);

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$tc_page_title = 'Bank - Trench City';
include __DIR__ . '/../../includes/postlogin-header.php';
?>

<main class="tc-main-content">
        <h1 class="tc-page-title"><� Trench City Bank</h1>

        <?php if ($message): ?><div class="tc-alert tc-alert--success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <?php if ($error): ?><div class="tc-alert tc-alert--danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>

        <div class="tc-card">
            <h2>=� Your Accounts</h2>
            <div class="tc-stats-grid">
                <div class="tc-stat-card">
                    <div class="tc-stat-label">Cash on Hand</div>
                    <div class="tc-stat-value">�<?= formatCash($user['cash']) ?></div>
                </div>
                <div class="tc-stat-card">
                    <div class="tc-stat-label">Bank Balance</div>
                    <div class="tc-stat-value">�<?= formatCash($user['bank_balance']) ?></div>
                </div>
                <div class="tc-stat-card">
                    <div class="tc-stat-label">Total Net Worth</div>
                    <div class="tc-stat-value">�<?= formatCash($user['cash'] + $user['bank_balance']) ?></div>
                </div>
            </div>
        </div>

        <div class="tc-grid tc-grid--3">
            <div class="tc-card">
                <h3>=� Deposit</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="deposit">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="tc-form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="tc-input" min="1" step="0.01" max="<?= $user['cash'] ?>" required>
                        <small>Available: �<?= formatCash($user['cash']) ?></small>
                    </div>
                    <button type="submit" class="tc-btn tc-btn--primary tc-btn--block">Deposit</button>
                </form>
            </div>

            <div class="tc-card">
                <h3>=� Withdraw</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="withdraw">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="tc-form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="tc-input" min="1" step="0.01" max="<?= $user['bank_balance'] ?>" required>
                        <small>Available: �<?= formatCash($user['bank_balance']) ?></small>
                    </div>
                    <button type="submit" class="tc-btn tc-btn--primary tc-btn--block">Withdraw</button>
                </form>
            </div>

            <div class="tc-card">
                <h3>=� Transfer</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="transfer">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="tc-form-group">
                        <label>To Username</label>
                        <input type="text" name="to_username" class="tc-input" required>
                    </div>
                    <div class="tc-form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="tc-input" min="1" step="0.01" required>
                        <small>+ <?= getBankConfig('transfer_fee_percent', 1) ?>% transfer fee</small>
                    </div>
                    <button type="submit" class="tc-btn tc-btn--primary tc-btn--block">Transfer</button>
                </form>
            </div>
        </div>

        <div class="tc-card">
            <h2>=� Transaction History</h2>
            <?php if (empty($history)): ?>
                <p>No transactions yet.</p>
            <?php else: ?>
                <table class="tc-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Cash After</th>
                            <th>Bank After</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $tx): ?>
                            <?php
                                $typeIcons = ['deposit' => '=�', 'withdraw' => '=�', 'transfer_send' => '=�', 'transfer_receive' => '=�', 'interest' => '=�'];
                                $icon = $typeIcons[$tx['transaction_type']] ?? '=�';
                                $amountClass = in_array($tx['transaction_type'], ['deposit', 'transfer_receive', 'interest']) ? 'tc-text-success' : 'tc-text-danger';
                            ?>
                            <tr>
                                <td><?= date('M j, g:i A', strtotime($tx['created_at'])) ?></td>
                                <td><?= $icon ?> <?= ucwords(str_replace('_', ' ', $tx['transaction_type'])) ?></td>
                                <td><?= htmlspecialchars($tx['description']) ?></td>
                                <td class="<?= $amountClass ?>">�<?= formatCash($tx['amount']) ?></td>
                                <td>�<?= formatCash($tx['cash_after']) ?></td>
                                <td>�<?= formatCash($tx['bank_after']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
</main>

<?php include __DIR__ . '/../../includes/postlogin-footer.php'; ?>

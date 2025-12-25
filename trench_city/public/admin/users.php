<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$db = function_exists('getDB') ? getDB() : ($GLOBALS['db'] ?? null);
$columns = tc_admin_user_columns($db);

if (function_exists('safe_input')) {
    $search = safe_input('q', '', 120);
    $filterStatus = safe_input('status', '', 16);
    $filterVerified = safe_input('verified', '', 16);
    $filterRecent = safe_input('recent', '', 16);
} else {
    $search = trim(strip_tags($_GET['q'] ?? ''));
    $search = substr($search, 0, 120);
    $filterStatus = trim(strip_tags($_GET['status'] ?? ''));
    $filterVerified = trim(strip_tags($_GET['verified'] ?? ''));
    $filterRecent = trim(strip_tags($_GET['recent'] ?? ''));
}

$searchableColumns = [
    'id' => in_array('id', $columns, true),
    'email' => in_array('email', $columns, true),
    'username' => in_array('username', $columns, true),
    'last_ip' => in_array('last_ip', $columns, true),
];

$deviceColumns = ['device_hash', 'device_fingerprint'];
$deviceColumn = '';
foreach ($deviceColumns as $candidate) {
    if (in_array($candidate, $columns, true)) {
        $deviceColumn = $candidate;
        $searchableColumns[$candidate] = true;
        break;
    }
}

$hasStatus = in_array('status', $columns, true);
$hasEmailVerified = in_array('email_verified', $columns, true);
$hasLastLogin = in_array('last_login_at', $columns, true);

$users = [];
$errors = [];

$selectColumns = ['id'];
foreach (['username', 'email', 'level', 'status', 'email_verified', 'last_login_at', 'last_ip', 'created_at'] as $column) {
    if (in_array($column, $columns, true)) {
        $selectColumns[] = $column;
    }
}

if (!$db) {
    $errors[] = 'Database connection unavailable.';
} else {
    $searchParts = [];
    $filterParts = [];
    $params = [];

    if ($search !== '') {
        if (ctype_digit($search) && $searchableColumns['id']) {
            $searchParts[] = 'id = :id';
            $params['id'] = (int)$search;
        }
        if ($searchableColumns['email']) {
            $searchParts[] = 'email LIKE :email';
            $params['email'] = '%' . $search . '%';
        }
        if ($searchableColumns['username']) {
            $searchParts[] = 'username LIKE :username';
            $params['username'] = '%' . $search . '%';
        }
        if ($searchableColumns['last_ip']) {
            $searchParts[] = 'last_ip LIKE :last_ip';
            $params['last_ip'] = '%' . $search . '%';
        }
        if ($deviceColumn !== '') {
            $searchParts[] = $deviceColumn . ' LIKE :device_hash';
            $params['device_hash'] = '%' . $search . '%';
        }
    }

    if ($filterStatus !== '' && $hasStatus) {
        $filterParts[] = 'status = :status';
        $params['status'] = $filterStatus;
    }

    if ($filterVerified !== '' && $hasEmailVerified) {
        if ($filterVerified === 'verified') {
            $filterParts[] = 'email_verified = 1';
        } elseif ($filterVerified === 'unverified') {
            $filterParts[] = 'email_verified = 0';
        }
    }

    if ($filterRecent !== '' && $hasLastLogin) {
        if ($filterRecent === '24h') {
            $filterParts[] = 'last_login_at >= (NOW() - INTERVAL 1 DAY)';
        } elseif ($filterRecent === '7d') {
            $filterParts[] = 'last_login_at >= (NOW() - INTERVAL 7 DAY)';
        }
    }

    $whereParts = [];
    if ($searchParts) {
        $whereParts[] = '(' . implode(' OR ', $searchParts) . ')';
    }
    if ($filterParts) {
        $whereParts[] = implode(' AND ', $filterParts);
    }

    $whereSql = $whereParts ? ('WHERE ' . implode(' AND ', $whereParts)) : '';
    $selectSql = implode(', ', $selectColumns);

    try {
        $users = $db->fetchAll(
            "SELECT {$selectSql} FROM users {$whereSql} ORDER BY id DESC LIMIT 50",
            $params
        );
    } catch (Throwable $e) {
        $errors[] = 'Failed to load users.';
    }
}

$tc_page_title = 'Owner Panel - Users';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">User Search</h1>
            <p class="content-description">Search by id, email, username, or IP. Filters adapt to available columns.</p>
        </div>

        <?php include __DIR__ . '/../../includes/admin_nav.php'; ?>

        <div class="tc-card">
            <div style="padding: 1.5rem;">
                <form method="get" action="/admin/users.php" style="display: grid; gap: 1rem;">
                    <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                        <input
                            type="text"
                            name="q"
                            placeholder="Search by id, email, username, or IP"
                            value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>"
                            style="flex: 1; min-width: 220px; padding: 0.75rem 1rem; background: #1F2937; border: 1px solid #374151;
                                   border-radius: 0.5rem; color: #F9FAFB; font-size: 0.95rem;"
                        />
                        <button class="btn btn-primary" type="submit">Search</button>
                        <?php if ($search !== '' || $filterStatus !== '' || $filterVerified !== '' || $filterRecent !== ''): ?>
                            <a class="btn btn-secondary" href="/admin/users.php">Clear</a>
                        <?php endif; ?>
                    </div>

                    <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                        <?php if ($hasStatus): ?>
                            <label style="display: grid; gap: 0.35rem; color: #9CA3AF;">
                                <span>Status</span>
                                <select name="status" style="min-width: 160px; padding: 0.55rem 0.75rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;">
                                    <option value="">All</option>
                                    <option value="active" <?php echo $filterStatus === 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="banned" <?php echo $filterStatus === 'banned' ? 'selected' : ''; ?>>Banned</option>
                                    <option value="inactive" <?php echo $filterStatus === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </label>
                        <?php endif; ?>

                        <?php if ($hasEmailVerified): ?>
                            <label style="display: grid; gap: 0.35rem; color: #9CA3AF;">
                                <span>Email Verification</span>
                                <select name="verified" style="min-width: 180px; padding: 0.55rem 0.75rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;">
                                    <option value="">All</option>
                                    <option value="verified" <?php echo $filterVerified === 'verified' ? 'selected' : ''; ?>>Verified</option>
                                    <option value="unverified" <?php echo $filterVerified === 'unverified' ? 'selected' : ''; ?>>Unverified</option>
                                </select>
                            </label>
                        <?php endif; ?>

                        <?php if ($hasLastLogin): ?>
                            <label style="display: grid; gap: 0.35rem; color: #9CA3AF;">
                                <span>Recent Activity</span>
                                <select name="recent" style="min-width: 160px; padding: 0.55rem 0.75rem; background: #111827; color: #F9FAFB; border: 1px solid #374151; border-radius: 0.5rem;">
                                    <option value="">Any time</option>
                                    <option value="24h" <?php echo $filterRecent === '24h' ? 'selected' : ''; ?>>Active 24h</option>
                                    <option value="7d" <?php echo $filterRecent === '7d' ? 'selected' : ''; ?>>Active 7d</option>
                                </select>
                            </label>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="tc-card" style="margin-top: 1.5rem;">
            <div style="padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2 style="color: #D4AF37; margin: 0;">Results</h2>
                    <span style="color: #9CA3AF;"><?php echo number_format(count($users)); ?> found</span>
                </div>

                <?php if ($errors): ?>
                    <div class="alert alert-warning">
                        <div class="alert-content">
                            <div class="alert-message"><?php echo htmlspecialchars(implode(' ', $errors), ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                    </div>
                <?php elseif (!$users): ?>
                    <div style="text-align: center; color: #9CA3AF; padding: 2rem 1rem;">
                        No users found.
                    </div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #374151;">
                                    <th style="padding: 0.75rem; text-align: left; color: #9CA3AF;">ID</th>
                                    <th style="padding: 0.75rem; text-align: left; color: #9CA3AF;">Username</th>
                                    <th style="padding: 0.75rem; text-align: left; color: #9CA3AF;">Email</th>
                                    <?php if (in_array('email_verified', $selectColumns, true)): ?>
                                        <th style="padding: 0.75rem; text-align: center; color: #9CA3AF;">Verified</th>
                                    <?php endif; ?>
                                    <th style="padding: 0.75rem; text-align: center; color: #9CA3AF;">Level</th>
                                    <?php if (in_array('status', $selectColumns, true)): ?>
                                        <th style="padding: 0.75rem; text-align: center; color: #9CA3AF;">Status</th>
                                    <?php endif; ?>
                                    <?php if (in_array('last_login_at', $selectColumns, true)): ?>
                                        <th style="padding: 0.75rem; text-align: center; color: #9CA3AF;">Last Login</th>
                                    <?php endif; ?>
                                    <?php if (in_array('last_ip', $selectColumns, true)): ?>
                                        <th style="padding: 0.75rem; text-align: left; color: #9CA3AF;">Last IP</th>
                                    <?php endif; ?>
                                    <th style="padding: 0.75rem; text-align: center; color: #9CA3AF;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $userRow): ?>
                                    <tr style="border-bottom: 1px solid #1F2937;">
                                        <td style="padding: 0.75rem; color: #F9FAFB;">
                                            <?php echo (int)($userRow['id'] ?? 0); ?>
                                        </td>
                                        <td style="padding: 0.75rem; color: #F9FAFB;">
                                            <?php echo htmlspecialchars($userRow['username'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                        </td>
                                        <td style="padding: 0.75rem; color: #D1D5DB;">
                                            <?php echo htmlspecialchars($userRow['email'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                        </td>
                                        <?php if (array_key_exists('email_verified', $userRow)): ?>
                                            <td style="padding: 0.75rem; text-align: center; color: #D1D5DB;">
                                                <?php echo !empty($userRow['email_verified']) ? 'Yes' : 'No'; ?>
                                            </td>
                                        <?php endif; ?>
                                        <td style="padding: 0.75rem; text-align: center; color: #D1D5DB;">
                                            <?php echo isset($userRow['level']) ? (int)$userRow['level'] : '-'; ?>
                                        </td>
                                        <?php if (array_key_exists('status', $userRow)): ?>
                                            <td style="padding: 0.75rem; text-align: center; color: #D1D5DB;">
                                                <?php echo htmlspecialchars($userRow['status'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>
                                        <?php endif; ?>
                                        <?php if (array_key_exists('last_login_at', $userRow)): ?>
                                            <td style="padding: 0.75rem; text-align: center; color: #D1D5DB;">
                                                <?php echo htmlspecialchars($userRow['last_login_at'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>
                                        <?php endif; ?>
                                        <?php if (array_key_exists('last_ip', $userRow)): ?>
                                            <td style="padding: 0.75rem; text-align: left; color: #D1D5DB;">
                                                <?php echo htmlspecialchars($userRow['last_ip'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                            </td>
                                        <?php endif; ?>
                                        <td style="padding: 0.75rem; text-align: center;">
                                            <a class="btn btn-secondary btn-sm" href="/admin/user_view.php?id=<?php echo (int)$userRow['id']; ?>">View</a>
                                            <a class="btn btn-ghost btn-sm" href="/admin/user_edit.php?id=<?php echo (int)$userRow['id']; ?>">Edit</a>
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

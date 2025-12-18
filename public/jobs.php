<?php
/**
 * TRENCH CITY - JOBS
 * Work legitimate or illegal jobs to earn money
 */

require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

$userId = currentUserId();
$user = getUser($userId);
$db = getDB();

if (!$user || !$db) {
    header('Location: /login.php');
    exit;
}

$success = '';
$errors = [];
$activeTab = $_GET['tab'] ?? 'browse';

// Check cooldown (1 hour between jobs)
$lastWork = $db->fetchOne(
    "SELECT worked_at FROM user_job_history WHERE user_id = :uid ORDER BY worked_at DESC LIMIT 1",
    ['uid' => $userId]
);

$canWork = true;
$cooldownRemaining = 0;

if ($lastWork) {
    $timeSince = time() - strtotime($lastWork['worked_at']);
    $cooldownTime = 3600; // 1 hour in seconds
    if ($timeSince < $cooldownTime) {
        $canWork = false;
        $cooldownRemaining = $cooldownTime - $timeSince;
    }
}

// Handle Work Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['work_job'])) {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errors[] = 'Invalid session. Please try again.';
    }

    $jobId = (int)($_POST['job_id'] ?? 0);

    if (!$canWork) {
        $errors[] = 'You must wait before working again. Cooldown: ' . gmdate('i:s', $cooldownRemaining);
    } elseif (empty($errors) && $jobId > 0) {
        $job = $db->fetchOne("SELECT * FROM jobs WHERE id = :id AND is_active = 1", ['id' => $jobId]);

        if (!$job) {
            $errors[] = 'Job not found.';
        } elseif ($job['min_level'] > ($user['level'] ?? 1)) {
            $errors[] = "You need to be level {$job['min_level']} for this job.";
        } else {
            $earnings = $job['hourly_pay'];

            $db->beginTransaction();
            try {
                // Add cash
                $db->execute("UPDATE users SET cash = cash + :earnings WHERE id = :id", [
                    'earnings' => $earnings,
                    'id' => $userId
                ]);

                // Record work history
                $db->execute(
                    "INSERT INTO user_job_history (user_id, job_id, hours_worked, earnings)
                     VALUES (:uid, :jid, 1.00, :earnings)",
                    ['uid' => $userId, 'jid' => $jobId, 'earnings' => $earnings]
                );

                $db->commit();
                $success = "Worked as {$job['name']} and earned \$" . number_format($earnings) . "!";
                $user = getUser($userId);
                $canWork = false;
                $cooldownRemaining = 3600;
            } catch (Exception $e) {
                $db->rollback();
                $errors[] = 'Work failed. Please try again.';
            }
        }
    }
}

// Get all jobs
$tier = $_GET['tier'] ?? 'all';
$tierFilter = $tier !== 'all' ? "AND tier = :tier" : "";
$params = $tier !== 'all' ? ['tier' => $tier] : [];

$jobs = $db->fetchAll(
    "SELECT * FROM jobs WHERE is_active = 1 {$tierFilter} ORDER BY tier, hourly_pay ASC",
    $params
);

// Get work history
$history = $db->fetchAll(
    "SELECT h.*, j.name, j.icon
     FROM user_job_history h
     JOIN jobs j ON h.job_id = j.id
     WHERE h.user_id = :uid
     ORDER BY h.worked_at DESC
     LIMIT 20",
    ['uid' => $userId]
);

$tc_page_title = 'Jobs - Trench City';
include __DIR__ . '/../includes/postlogin-header.php';
?>

<!-- Main Content -->
<div class="main-content">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="content-header">
            <h1 class="content-title">💼 Employment Office</h1>
            <p class="content-description">
                Your Cash: <span style="color: #10B981; font-weight: bold;">$<?= number_format($user['cash'] ?? 0) ?></span>
                <?php if (!$canWork): ?>
                    | <span style="color: #EF4444;">⏱ Cooldown: <?= gmdate('i:s', $cooldownRemaining) ?></span>
                <?php endif; ?>
            </p>
        </div>

        <!-- Messages -->
        <?php if ($success): ?>
            <div style="margin-top: 2rem; padding: 1rem 1.5rem; background: rgba(16, 185, 129, 0.1);
                        border-left: 4px solid #10B981; border-radius: 0.5rem; color: #10B981;">
                ✓ <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div style="margin-top: 2rem; padding: 1rem 1.5rem; background: rgba(239, 68, 68, 0.1);
                        border-left: 4px solid #EF4444; border-radius: 0.5rem; color: #EF4444;">
                <?php foreach ($errors as $error): ?>
                    <div>⨯ <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Tabs -->
        <div style="margin-top: 2rem; border-bottom: 2px solid #1F2937; display: flex; gap: 1rem;">
            <a href="?tab=browse" style="padding: 1rem 1.5rem; text-decoration: none; color: <?= $activeTab === 'browse' ? '#D4AF37' : '#9CA3AF' ?>;
               border-bottom: 3px solid <?= $activeTab === 'browse' ? '#D4AF37' : 'transparent' ?>; font-weight: 600;">
                💼 Available Jobs
            </a>
            <a href="?tab=history" style="padding: 1rem 1.5rem; text-decoration: none; color: <?= $activeTab === 'history' ? '#D4AF37' : '#9CA3AF' ?>;
               border-bottom: 3px solid <?= $activeTab === 'history' ? '#D4AF37' : 'transparent' ?>; font-weight: 600;">
                📜 Work History
            </a>
        </div>

        <?php if ($activeTab === 'browse'): ?>
            <!-- Tier Filter -->
            <div style="margin-top: 2rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <a href="?tab=browse&tier=all" style="padding: 0.5rem 1rem; background: <?= $tier === 'all' ? '#D4AF37' : '#1F2937' ?>;
                   color: <?= $tier === 'all' ? '#0F172A' : '#9CA3AF' ?>; text-decoration: none; border-radius: 0.5rem; font-size: 0.9rem; font-weight: 500;">
                    All Jobs
                </a>
                <a href="?tab=browse&tier=legitimate" style="padding: 0.5rem 1rem; background: <?= $tier === 'legitimate' ? '#D4AF37' : '#1F2937' ?>;
                   color: <?= $tier === 'legitimate' ? '#0F172A' : '#9CA3AF' ?>; text-decoration: none; border-radius: 0.5rem; font-size: 0.9rem; font-weight: 500;">
                    🏪 Legitimate
                </a>
                <a href="?tab=browse&tier=criminal" style="padding: 0.5rem 1rem; background: <?= $tier === 'criminal' ? '#D4AF37' : '#1F2937' ?>;
                   color: <?= $tier === 'criminal' ? '#0F172A' : '#9CA3AF' ?>; text-decoration: none; border-radius: 0.5rem; font-size: 0.9rem; font-weight: 500;">
                    🎭 Criminal
                </a>
                <a href="?tab=browse&tier=management" style="padding: 0.5rem 1rem; background: <?= $tier === 'management' ? '#D4AF37' : '#1F2937' ?>;
                   color: <?= $tier === 'management' ? '#0F172A' : '#9CA3AF' ?>; text-decoration: none; border-radius: 0.5rem; font-size: 0.9rem; font-weight: 500;">
                    👔 Management
                </a>
            </div>

            <!-- Jobs Grid -->
            <div style="margin-top: 2rem; display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
                <?php foreach ($jobs as $job): ?>
                    <div class="tc-card">
                        <div style="padding: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                <div>
                                    <div style="font-size: 2rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($job['icon'], ENT_QUOTES, 'UTF-8') ?></div>
                                    <h3 style="color: #D4AF37; margin-bottom: 0.25rem; font-size: 1.1rem;"><?= htmlspecialchars($job['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                                    <div style="color: #6B7280; font-size: 0.85rem; text-transform: uppercase;"><?= $job['tier'] ?></div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="color: #10B981; font-size: 1.25rem; font-weight: bold;">$<?= number_format($job['hourly_pay']) ?></div>
                                    <div style="color: #9CA3AF; font-size: 0.85rem;">/hour</div>
                                    <?php if ($job['min_level'] > 1): ?>
                                        <div style="color: #9CA3AF; font-size: 0.85rem;">Lvl <?= $job['min_level'] ?>+</div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <p style="color: #9CA3AF; font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.4;"><?= htmlspecialchars($job['description'], ENT_QUOTES, 'UTF-8') ?></p>

                            <?php if (!$canWork): ?>
                                <button disabled style="width: 100%; padding: 0.75rem; background: #374151; color: #6B7280;
                                       border: none; border-radius: 0.5rem; font-weight: 600; cursor: not-allowed;">
                                    ⏱ Cooldown: <?= gmdate('i:s', $cooldownRemaining) ?>
                                </button>
                            <?php elseif ($job['min_level'] > ($user['level'] ?? 1)): ?>
                                <button disabled style="width: 100%; padding: 0.75rem; background: #374151; color: #6B7280;
                                       border: none; border-radius: 0.5rem; font-weight: 600; cursor: not-allowed;">
                                    🔒 Requires Level <?= $job['min_level'] ?>
                                </button>
                            <?php else: ?>
                                <form method="post" style="margin: 0;">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>" />
                                    <input type="hidden" name="work_job" value="1" />
                                    <input type="hidden" name="job_id" value="<?= $job['id'] ?>" />
                                    <button type="submit" style="width: 100%; padding: 0.75rem; background: #D4AF37; color: #0F172A;
                                           border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">
                                        💼 Work Now
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="tc-card" style="margin-top: 2rem;">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 1.5rem;">Work History</h2>
                    <?php if (empty($history)): ?>
                        <div style="text-align: center; padding: 2rem; color: #9CA3AF;">No work history yet.</div>
                    <?php else: ?>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #374151;">
                                        <th style="padding: 1rem; text-align: left; color: #9CA3AF;">Job</th>
                                        <th style="padding: 1rem; text-align: center; color: #9CA3AF;">Hours</th>
                                        <th style="padding: 1rem; text-align: right; color: #9CA3AF;">Earned</th>
                                        <th style="padding: 1rem; text-align: right; color: #9CA3AF;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($history as $work): ?>
                                        <tr style="border-bottom: 1px solid #1F2937;">
                                            <td style="padding: 1rem;">
                                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                    <span style="font-size: 1.5rem;"><?= htmlspecialchars($work['icon'], ENT_QUOTES, 'UTF-8') ?></span>
                                                    <span style="color: #F9FAFB;"><?= htmlspecialchars($work['name'], ENT_QUOTES, 'UTF-8') ?></span>
                                                </div>
                                            </td>
                                            <td style="padding: 1rem; text-align: center; color: #9CA3AF;">
                                                <?= number_format($work['hours_worked'], 2) ?>
                                            </td>
                                            <td style="padding: 1rem; text-align: right;">
                                                <span style="color: #10B981; font-weight: 600;">
                                                    +$<?= number_format($work['earnings']) ?>
                                                </span>
                                            </td>
                                            <td style="padding: 1rem; text-align: right; color: #9CA3AF; font-size: 0.9rem;">
                                                <?= date('M j, g:i A', strtotime($work['worked_at'])) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>

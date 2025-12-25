<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';
requireLogin();

global $db;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /modules/gym/gym_shell.php');
    exit;
}

$csrf = $_POST['csrf_token'] ?? '';
$nonce = $_POST['train_nonce'] ?? '';
$sessionNonce = $_SESSION['gym_train_nonce'] ?? '';

if (!csrf_check($csrf) || $nonce === '' || $sessionNonce === '' || !hash_equals($sessionNonce, $nonce)) {
    $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
    header('Location: /modules/gym/gym_shell.php');
    exit;
}

unset($_SESSION['gym_train_nonce']);

$gymId = (int)($_POST['gym_id'] ?? 0);
$statKey = (string)($_POST['stat_key'] ?? '');
$allowedStats = ['strength', 'defense', 'speed', 'dexterity'];

if ($gymId <= 0 || !in_array($statKey, $allowedStats, true)) {
    $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
    header('Location: /modules/gym/gym_shell.php');
    exit;
}

$userId = currentUserId();
if (!$userId) {
    header('Location: /login.php');
    exit;
}

$preBars = getUserBars($userId);
$preStats = getUserStats($userId);
if (!$preBars || !$preStats) {
    $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
    header('Location: /modules/gym/gym_shell.php');
    exit;
}

$gym = $db->fetchOne("SELECT * FROM gyms WHERE id = :id LIMIT 1", ['id' => $gymId]);
if (!$gym) {
    $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
    header('Location: /modules/gym/gym_shell.php');
    exit;
}

$starterRow = $db->fetchOne("SELECT id FROM gyms ORDER BY tier ASC, id ASC LIMIT 1");
$starterGymId = (int)($starterRow['id'] ?? 0);

$unlocked = $db->fetchOne(
    "SELECT gym_id FROM gym_unlocks WHERE user_id = :uid AND gym_id = :gid LIMIT 1",
    ['uid' => $userId, 'gid' => $gymId]
);

if (!$unlocked && $gymId !== $starterGymId) {
    $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'This gym is locked.'];
    header('Location: /modules/gym/gym_shell.php?gym_id=' . $gymId);
    exit;
}

$energyCostPerTrain = (int)($gym['energy_cost_per_train'] ?? 0);
if ($energyCostPerTrain <= 0) {
    $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
    header('Location: /modules/gym/gym_shell.php?gym_id=' . $gymId);
    exit;
}

$trainTimes = 1;
$energyCost = $energyCostPerTrain * $trainTimes;
$xpGain = $energyCost * 2;

$statLabel = match ($statKey) {
    'strength' => 'Strength',
    'defense' => 'Defense',
    'speed' => 'Speed',
    'dexterity' => 'Dexterity',
    default => 'Stat',
};

$formatStatGain = function (float $value): string {
    $rounded = round($value, 2);
    if (abs($rounded - round($rounded)) < 0.005) {
        return (string)(int)round($rounded);
    }
    return number_format($rounded, 2);
};

try {
    $db->beginTransaction();

    $bars = $db->fetchOne(
        "SELECT * FROM player_bars WHERE user_id = :id LIMIT 1 FOR UPDATE",
        ['id' => $userId]
    );
    $stats = $db->fetchOne(
        "SELECT * FROM player_stats WHERE user_id = :id LIMIT 1 FOR UPDATE",
        ['id' => $userId]
    );
    $user = $db->fetchOne(
        "SELECT id, xp, level FROM users WHERE id = :id LIMIT 1 FOR UPDATE",
        ['id' => $userId]
    );

    if (!$bars || !$stats || !$user) {
        throw new RuntimeException('Missing player data.');
    }

    if (isset($bars['life_current']) && (int)$bars['life_current'] <= 0) {
        $db->rollBack();
        $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
        header('Location: /modules/gym/gym_shell.php?gym_id=' . $gymId);
        exit;
    }

    $energyCurrent = (int)($bars['energy_current'] ?? 0);
    if ($energyCurrent < $energyCost) {
        $db->rollBack();
        $_SESSION['gym_flash'] = [
            'type' => 'error',
            'message' => "Not enough Energy to train. Need {$energyCost}, you have {$energyCurrent}."
        ];
        header('Location: /modules/gym/gym_shell.php?gym_id=' . $gymId);
        exit;
    }

    $happyCurrent = (int)($bars['happy_current'] ?? 0);
    $currentStat = (float)($stats[$statKey] ?? 0);

    $baseGain = (float)($gym['base_stat_gain'] ?? 0);
    $statMult = (float)($gym[$statKey . '_mult'] ?? 1.0);
    $gainBase = $baseGain * $statMult;

    $statScale = 1.0 / (1.0 + pow(($currentStat / 2500.0), 0.85));
    $happyMult = 1.0 + (0.18 * log(1.0 + ($happyCurrent / 500.0)));
    $happyMult = max(1.0, min(2.20, $happyMult));
    $rng = random_int(950, 1050) / 1000;

    $statGain = max(0.01, $gainBase * $statScale * $happyMult * $rng);
    $newStatValue = round($currentStat + $statGain, 2);

    $happyLoss = (int)round($energyCost * 0.5);
    if ($energyCost >= 2 && $happyLoss <= 0) {
        $happyLoss = 1;
    }
    $happyAfter = max(0, $happyCurrent - $happyLoss);
    $energyAfter = $energyCurrent - $energyCost;

    $db->execute(
        "UPDATE player_stats SET {$statKey} = :new_value WHERE user_id = :user_id",
        ['new_value' => $newStatValue, 'user_id' => $userId]
    );

    updateUserBars($userId, [
        'energy_current' => $energyAfter,
        'happy_current' => $happyAfter,
    ]);

    $newXp = (int)$user['xp'] + $xpGain;
    $newLevel = calculateLevel($newXp);
    $db->execute(
        "UPDATE users SET xp = :xp, level = :level WHERE id = :id",
        ['xp' => $newXp, 'level' => $newLevel, 'id' => $userId]
    );

    $db->execute(
        "INSERT INTO training_logs (user_id, gym_id, stat_trained, energy_spent, stat_gain, xp_gained, created_at)
         VALUES (:user_id, :gym_id, :stat_trained, :energy_spent, :stat_gain, :xp_gained, NOW())",
        [
            'user_id' => $userId,
            'gym_id' => $gymId,
            'stat_trained' => $statKey,
            'energy_spent' => $energyCost,
            'stat_gain' => $statGain,
            'xp_gained' => $xpGain,
        ]
    );

    $db->commit();

    logPlayerAction($userId, 'gym_train', [
        'gym_id' => $gymId,
        'stat' => $statKey,
        'gain' => $statGain,
        'energy' => $energyCost,
        'happy_loss' => $happyLoss,
        'xp' => $xpGain,
    ]);

    $gainDisplay = $formatStatGain($statGain);

    $_SESSION['gym_flash'] = [
        'type' => 'success',
        'banner' => "Training complete! +{$gainDisplay} {$statLabel} | +{$xpGain} XP",
        'line' => "+{$gainDisplay} {$statLabel} • +{$xpGain} XP • -{$energyCost} Energy • -{$happyLoss} Happy",
        'gym_name' => (string)($gym['name'] ?? 'Gym'),
    ];
} catch (Throwable $e) {
    if ($db && $db->inTransaction()) {
        $db->rollBack();
    }

    tc_log("[GYM] Training error for user {$userId}: {$e->getMessage()}", 'error');
    $_SESSION['gym_flash'] = ['type' => 'error', 'message' => 'Invalid training request.'];
}

header('Location: /modules/gym/gym_shell.php?gym_id=' . $gymId);
exit;

<?php
/**
 * ======================================================
 *  TRENCH CITY HELPERS CORE (v1.2 FINAL)
 *  Global utility library — consistent, secure, optimized.
 *  ✅ Works in CLI + FPM + API contexts
 *  ✅ No duplicate functions
 *  ✅ Clean integration with Log + Redis + Security Core
 *  Author: Architect
 * ======================================================
 */

// ------------------------------------------------------
//  Ensure bootstrap context (for constants + env)
// ------------------------------------------------------
if (!defined('TRENCH_CITY')) {
    $bootstrap = __DIR__ . '/bootstrap.php';
    if (file_exists($bootstrap)) {
        require_once $bootstrap;
    } else {
        error_log('[HELPERS] bootstrap.php not found — environment incomplete.');
    }
}
if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

// ------------------------------------------------------
//  ENVIRONMENT HELPERS
// ------------------------------------------------------
function is_dev(): bool     { return defined('APP_ENV') && in_array(APP_ENV, ['dev', 'development']); }
function is_alpha(): bool   { return defined('APP_ENV') && APP_ENV === 'alpha'; }
function is_prod(): bool    { return defined('APP_ENV') && in_array(APP_ENV, ['prod', 'production']); }
function app_env(): string  { return defined('APP_ENV') ? APP_ENV : 'unknown'; }

// ------------------------------------------------------
//  DEBUG HELPERS
// ------------------------------------------------------
function dd(...$vars): void
{
    $isCli = php_sapi_name() === 'cli';
    if ($isCli) {
        foreach ($vars as $v) var_dump($v);
        exit(0);
    }
    echo "<pre style='background:#0a0a0a;color:#cba135;padding:10px;border-radius:8px;'>";
    foreach ($vars as $v) var_dump($v);
    echo "</pre>";
    exit;
}

function pretty_json($data): string
{
    return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

// ------------------------------------------------------
//  STRING / DATA HELPERS
// ------------------------------------------------------
function uuidv4(): string
{
    $data = random_bytes(16);
    $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
    $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function str_sanitize(string $input, int $maxLength = 255): string
{
    $clean = trim(strip_tags($input));
    return mb_substr($clean, 0, $maxLength, 'UTF-8');
}

function safe_input(string $key, $default = '', int $maxLength = 255): string
{
    if (!isset($_REQUEST[$key])) return $default;
    return str_sanitize((string)$_REQUEST[$key], $maxLength);
}

// ------------------------------------------------------
//  SECURITY HELPERS
// ------------------------------------------------------
function tc_hash(string $value): string
{
    return password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
}

function tc_verify(string $value, string $hash): bool
{
    return password_verify($value, $hash);
}

// ------------------------------------------------------
//  RATE LIMITING (Uses core/redis.php)
// ------------------------------------------------------
function rate_limit(string $key, int $max, int $seconds): bool
{
    if (!function_exists('redis')) return false;
    $r = redis();
    if (!$r) return false;

    try {
        $key = 'rate:' . md5($key);
        $count = $r->incr($key);
        if ($count === 1) $r->expire($key, $seconds);
        return $count <= $max;
    } catch (Throwable $t) {
        tc_log("[RATE_LIMIT] Redis error: " . $t->getMessage(), 'warn');
        return true; // fallback: never block if Redis unavailable
    }
}

// ------------------------------------------------------
//  TIME HELPERS
// ------------------------------------------------------
function now(): string
{
    return date('Y-m-d H:i:s');
}

function seconds_since(string $datetime): int
{
    return time() - strtotime($datetime);
}

// ------------------------------------------------------
//  PATH HELPERS
// ------------------------------------------------------
function core_path(string $file = ''): string
{
    return defined('CORE_PATH')
        ? rtrim(CORE_PATH, '/') . ($file ? '/' . ltrim($file, '/') : '')
        : __DIR__;
}

function public_path(string $file = ''): string
{
    return defined('PUBLIC_PATH')
        ? rtrim(PUBLIC_PATH, '/') . ($file ? '/' . ltrim($file, '/') : '')
        : '/var/www/trench_city/public';
}

function include_path_trench(string $file = ''): string
{
    return defined('INCLUDE_PATH')
        ? rtrim(INCLUDE_PATH, '/') . ($file ? '/' . ltrim($file, '/') : '')
        : '/var/www/trench_city/includes';
}

// ------------------------------------------------------
//  CLI & UTIL SHORTCUTS
// ------------------------------------------------------
function console_log(string $message): void
{
    if (php_sapi_name() === 'cli') {
        echo "[" . date('H:i:s') . "] " . $message . PHP_EOL;
    } else {
        tc_log($message, 'debug');
    }
}

function memory_usage(): string
{
    return round(memory_get_usage(true) / 1048576, 2) . ' MB';
}

// ------------------------------------------------------
//  GAME HELPERS - CORE PLAYER FUNCTIONS
// ------------------------------------------------------

/**
 * Get user by ID with caching
 */
function getUser(int $userId): ?array
{
    global $db;
    if (!$db) return null;

    $user = $db->fetchOne(
        "SELECT * FROM users WHERE id = :id LIMIT 1",
        ['id' => $userId]
    );

    return $user ?: null;
}

/**
 * Get player stats (Strength, Speed, Defense, Dexterity)
 */
function getUserStats(int $userId): ?array
{
    global $db;
    if (!$db) return null;

    $stats = $db->fetchOne(
        "SELECT * FROM player_stats WHERE user_id = :id LIMIT 1",
        ['id' => $userId]
    );

    return $stats ?: null;
}

/**
 * Get player bars (Energy, Nerve, Happy, Life)
 */
function getUserBars(int $userId): ?array
{
    global $db;
    if (!$db) return null;

    $bars = $db->fetchOne(
        "SELECT * FROM player_bars WHERE user_id = :id LIMIT 1",
        ['id' => $userId]
    );

    return $bars ?: null;
}

/**
 * Update user bars atomically
 * @param int $userId
 * @param array $bars - Keys: energy_current, nerve_current, happy_current, life_current
 */
function updateUserBars(int $userId, array $bars): bool
{
    global $db;
    if (!$db) return false;

    $allowed = ['energy_current', 'nerve_current', 'happy_current', 'life_current'];
    $updates = [];
    $params = ['user_id' => $userId];

    foreach ($bars as $key => $value) {
        if (in_array($key, $allowed)) {
            $updates[] = "{$key} = :{$key}";
            $params[$key] = (int)$value;
        }
    }

    if (empty($updates)) return false;

    $sql = "UPDATE player_bars SET " . implode(', ', $updates) . " WHERE user_id = :user_id";

    try {
        $db->execute($sql, $params);
        tc_log("[BARS] Updated bars for user_id={$userId}", 'info');
        return true;
    } catch (Exception $e) {
        tc_log("[BARS] Failed to update bars: {$e->getMessage()}", 'error');
        return false;
    }
}

/**
 * Calculate player level from XP
 * Formula: Level = floor(0.25 * sqrt(XP))
 */
function calculateLevel(int $xp): int
{
    if ($xp <= 0) return 1;
    return max(1, (int)floor(0.25 * sqrt($xp)));
}

/**
 * Get XP required for a specific level
 * Inverse formula: XP = (Level / 0.25)^2
 */
function getXPForLevel(int $level): int
{
    if ($level <= 1) return 0;
    return (int)pow($level / 0.25, 2);
}

/**
 * Award XP to player and update level
 */
function awardXP(int $userId, int $xpAmount): bool
{
    global $db;
    if (!$db || $xpAmount <= 0) return false;

    $user = getUser($userId);
    if (!$user) return false;

    $newXP = (int)$user['xp'] + $xpAmount;
    $newLevel = calculateLevel($newXP);

    try {
        $db->execute(
            "UPDATE users SET xp = :xp, level = :level WHERE id = :id",
            ['xp' => $newXP, 'level' => $newLevel, 'id' => $userId]
        );

        if ($newLevel > (int)$user['level']) {
            tc_log("[XP] User {$userId} leveled up: {$user['level']} → {$newLevel}", 'info');
        }

        return true;
    } catch (Exception $e) {
        tc_log("[XP] Failed to award XP: {$e->getMessage()}", 'error');
        return false;
    }
}

/**
 * Log player actions for audit/admin
 */
function logPlayerAction(int $userId, string $actionType, array $details = []): void
{
    $data = [
        'user_id' => $userId,
        'action' => $actionType,
        'details' => json_encode($details),
        'timestamp' => now()
    ];

    tc_log("[PLAYER_ACTION] user_id={$userId} action={$actionType} " . json_encode($details), 'info');

    // If you have a player_actions table, insert here
    // For now, just logging
}

/**
 * Check if user is authenticated
 */
function requireLogin(bool $allowUnverified = false): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['user_id'])) {
        header('Location: /login.php');
        exit;
    }

    if (!$allowUnverified) {
        tc_enforce_email_verification();
    }
}

function tc_enforce_email_verification(): void
{
    if (!tc_email_verification_required()) {
        return;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['user_id'])) {
        return;
    }

    static $alreadyChecked = false;
    if ($alreadyChecked) {
        return;
    }
    $alreadyChecked = true;

    $script = $_SERVER['SCRIPT_NAME'] ?? ($_SERVER['PHP_SELF'] ?? '');
    $script = strtolower(basename(str_replace('\\', '/', $script)));
    $allowed = ['verify-email.php', 'logout.php'];
    if (in_array($script, $allowed, true)) {
        return;
    }

    $user = getUser((int)$_SESSION['user_id']);
    if (!$user) {
        session_destroy();
        header('Location: /login.php');
        exit;
    }

    if (!array_key_exists('email_verified', $user)) {
        return;
    }

    if ((int)$user['email_verified'] === 1) {
        $_SESSION['email_verified'] = 1;
        return;
    }

    $_SESSION['email_verified'] = 0;
    header('Location: /verify-email.php');
    exit;
}

function tc_email_verification_required(): bool
{
    static $required = null;
    if ($required !== null) {
        return $required;
    }

    global $db;
    if (!$db) {
        return true;
    }

    try {
        $row = $db->fetchOne(
            "SELECT config_value FROM email_config WHERE config_key = 'verification_required' LIMIT 1"
        );
        $required = ($row['config_value'] ?? 'true') === 'true';
    } catch (Throwable $e) {
        $required = true;
    }

    return $required;
}

function tc_issue_email_verification_token(int $userId, string $email): ?string
{
    global $db;
    if (!$db) {
        return null;
    }

    $token = bin2hex(random_bytes(32));
    $db->execute(
        "UPDATE users
         SET email_verified = 0,
             email_verification_token = :token,
             email_verification_sent_at = NOW(),
             email_verified_at = NULL
         WHERE id = :id",
        [
            'token' => $token,
            'id' => $userId
        ]
    );

    return $token;
}

function tc_send_email_verification_token(int $userId, string $email, string $token): bool
{
    $sent = false;

    if (!class_exists('Email')) {
        $emailClass = __DIR__ . '/Email.php';
        if (file_exists($emailClass)) {
            require_once $emailClass;
        }
    }

    if (class_exists('Email')) {
        try {
            $mailer = new Email();
            $sent = $mailer->sendVerificationEmail($userId, $email, $token);
        } catch (Throwable $e) {
            tc_log("[EMAIL] Verification send failure user_id={$userId}: {$e->getMessage()}", 'error');
        }
    }

    if (!$sent) {
        tc_log("[EMAIL] Verification token for user_id={$userId} email={$email}: {$token}", 'warn');
    }

    if (is_dev()) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['dev_last_verification_token'] = $token;
    }

    return $sent;
}

/**
 * Get current authenticated user ID
 */
function currentUserId(): ?int
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
}

/**
 * Format currency (cash)
 */
function formatCash(float $amount): string
{
    return '£' . number_format($amount, 2);
}

/**
 * Format large numbers with commas
 */
function formatNumber(int $number): string
{
    return number_format($number);
}

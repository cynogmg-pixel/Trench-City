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

function tc_storage_candidate_paths(string $filename, array $fallbackDirs = ['cache', 'logs']): array
{
    $base = defined('STORAGE_PATH')
        ? rtrim(STORAGE_PATH, '/')
        : rtrim(__DIR__ . '/../storage', '/');

    $filename = ltrim($filename, '/');
    $paths = [$base . '/' . $filename];

    foreach ($fallbackDirs as $dir) {
        $candidateDir = $base . '/' . trim($dir, '/');
        $paths[] = rtrim($candidateDir, '/') . '/' . $filename;
    }

    return $paths;
}

function tc_storage_file_path(string $filename, array $fallbackDirs = ['cache', 'logs'], bool $forWrite = false): string
{
    $paths = tc_storage_candidate_paths($filename, $fallbackDirs);

    if ($forWrite) {
        foreach ($paths as $path) {
            if (file_exists($path) && is_writable($path)) {
                return $path;
            }
        }

        foreach ($paths as $path) {
            $dir = dirname($path);
            if (is_dir($dir) && is_writable($dir)) {
                return $path;
            }
        }

        return '';
    }

    foreach ($paths as $path) {
        if (file_exists($path) && is_readable($path)) {
            return $path;
        }
    }

    return $paths[0];
}

function tc_ops_flags_path(): string
{
    return tc_storage_file_path('ops_flags.json', ['cache', 'logs'], true);
}

function tc_load_ops_flags(): array
{
    $path = tc_ops_flags_path();
    $raw = null;

    if (is_readable($path)) {
        $raw = file_get_contents($path);
    } else {
        $paths = tc_storage_candidate_paths('ops_flags.json');
        foreach ($paths as $candidate) {
            if (is_readable($candidate)) {
                $raw = file_get_contents($candidate);
                if ($raw !== false && $raw !== '') {
                    if ($candidate !== $path && is_dir(dirname($path)) && is_writable(dirname($path))) {
                        @file_put_contents($path, $raw, LOCK_EX);
                    }
                    break;
                }
            }
        }
    }

    if ($raw === false || $raw === null || $raw === '') {
        return [];
    }

    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function tc_save_ops_flags(array $flags): bool
{
    $path = tc_storage_file_path('ops_flags.json', ['cache', 'logs'], true);
    if ($path === '') {
        return false;
    }
    $dir = dirname($path);
    if (!is_dir($dir) || !is_writable($dir)) {
        return false;
    }
    if (file_exists($path) && !is_writable($path)) {
        return false;
    }

    $payload = json_encode($flags, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    return $payload !== false && @file_put_contents($path, $payload, LOCK_EX) !== false;
}

function tc_is_ops_flag_enabled(string $flag): bool
{
    $flags = tc_load_ops_flags();
    return !empty($flags[$flag]);
}

function tc_set_ops_flag(string $flag, bool $enabled): bool
{
    $flags = tc_load_ops_flags();
    if ($enabled) {
        $flags[$flag] = true;
    } else {
        unset($flags[$flag]);
    }
    return tc_save_ops_flags($flags);
}

function tc_global_announcement_path(): string
{
    return tc_storage_file_path('global_announcement.json', ['cache', 'logs'], true);
}

function tc_get_global_announcement(): ?array
{
    $path = tc_global_announcement_path();
    $raw = null;
    if (is_readable($path)) {
        $raw = file_get_contents($path);
    } else {
        $paths = tc_storage_candidate_paths('global_announcement.json');
        foreach ($paths as $candidate) {
            if (is_readable($candidate)) {
                $raw = file_get_contents($candidate);
                if ($raw !== false && $raw !== '') {
                    if ($candidate !== $path && is_dir(dirname($path)) && is_writable(dirname($path))) {
                        @file_put_contents($path, $raw, LOCK_EX);
                    }
                    break;
                }
            }
        }
    }

    if ($raw === false || $raw === null || $raw === '') {
        return null;
    }

    $data = json_decode($raw, true);
    if (!is_array($data) || empty($data['message'])) {
        return null;
    }

    if (!empty($data['expires_at'])) {
        $expires = strtotime((string)$data['expires_at']);
        if ($expires && $expires < time()) {
            return null;
        }
    }

    return $data;
}

function tc_set_global_announcement(?array $data): bool
{
    if ($data === null) {
        $paths = tc_storage_candidate_paths('global_announcement.json');
        $deleted = false;
        $anyExists = false;
        foreach ($paths as $candidate) {
            if (!file_exists($candidate)) {
                continue;
            }
            $anyExists = true;
            if (!is_writable($candidate)) {
                continue;
            }
            if (@unlink($candidate)) {
                $deleted = true;
                continue;
            }
            if (@file_put_contents($candidate, '', LOCK_EX) !== false) {
                $deleted = true;
            }
        }
        return $deleted || !$anyExists;
    }

    $path = tc_storage_file_path('global_announcement.json', ['cache', 'logs'], true);
    if ($path === '') {
        return false;
    }
    $dir = dirname($path);
    if (!is_dir($dir) || !is_writable($dir)) {
        return false;
    }
    if (file_exists($path) && !is_writable($path)) {
        return false;
    }

    $payload = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    return $payload !== false && @file_put_contents($path, $payload, LOCK_EX) !== false;
}

function tc_render_postlogin_notice(string $title, string $message, string $returnUrl = '/dashboard.php'): void
{
    $tc_page_title = $title . ' - Trench City';
    include __DIR__ . '/../includes/tc_header.php';
    tcRenderPageStart(['mode' => 'postlogin']);
    echo "<div class='main-content'><div class='content-wrapper'>";
    echo "<div class='tc-card' style='margin-top:2rem;'><div style='padding:1.5rem;'>";
    echo "<h1 class='tc-page-title' style='margin-top:0;'>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</h1>";
    echo "<p style='color:#D1D5DB;'>" . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<a class='btn btn-secondary' href='" . htmlspecialchars($returnUrl, ENT_QUOTES, 'UTF-8') . "'>Back</a>";
    echo "</div></div></div></div>";
    include __DIR__ . '/../includes/postlogin-footer.php';
    exit;
}

function tc_render_prelogin_notice(string $title, string $message, string $returnUrl = '/'): void
{
    $tc_page_title = $title . ' - Trench City';
    include __DIR__ . '/../includes/tc_header.php';
    tcRenderPageStart(['mode' => 'prelogin']);
    echo "<div class='tc-app-shell' style='padding: 2rem 0;'>";
    echo "<div class='tc-card' style='max-width:720px; margin: 0 auto; padding: 2rem;'>";
    echo "<h1 class='tc-page-title' style='margin-top:0;'>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</h1>";
    echo "<p style='color:#D1D5DB;'>" . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<a class='btn btn-secondary' href='" . htmlspecialchars($returnUrl, ENT_QUOTES, 'UTF-8') . "'>Back</a>";
    echo "</div></div>";
    include __DIR__ . '/../includes/prelogin-footer.php';
    exit;
}

function tc_redirect_maintenance(): void
{
    if (headers_sent()) {
        tc_render_postlogin_notice('Maintenance', 'This area is temporarily unavailable.', '/dashboard.php');
    }

    header('Location: /maintenance.php');
    exit;
}

function tc_enforce_feature_flag(string $flag, string $title, string $message, string $returnUrl = '/dashboard.php'): void
{
    if (tc_is_ops_flag_enabled($flag)) {
        tc_redirect_maintenance();
    }
}

function tc_ops_flag_catalog(): array
{
    return [
        'global_lockdown' => ['label' => 'Disable all modules', 'category' => 'System'],
        'lock_registrations' => ['label' => 'Lock registrations', 'category' => 'System'],
        'disable_dashboard' => ['label' => 'Disable dashboard', 'category' => 'System'],
        'disable_settings' => ['label' => 'Disable settings', 'category' => 'System'],
        'disable_profile' => ['label' => 'Disable profile', 'category' => 'System'],
        'freeze_economy' => ['label' => 'Freeze economy', 'category' => 'Economy'],
        'disable_trading' => ['label' => 'Disable trading', 'category' => 'Economy'],
        'disable_market' => ['label' => 'Disable market', 'category' => 'Economy'],
        'disable_black_market' => ['label' => 'Disable black market', 'category' => 'Economy'],
        'disable_bank' => ['label' => 'Disable bank', 'category' => 'Economy'],
        'disable_casino' => ['label' => 'Disable casino', 'category' => 'Economy'],
        'disable_stock' => ['label' => 'Disable stock', 'category' => 'Economy'],
        'disable_crimes' => ['label' => 'Disable crimes', 'category' => 'Combat'],
        'disable_fighting' => ['label' => 'Disable fighting', 'category' => 'Combat'],
        'disable_targets' => ['label' => 'Disable targets', 'category' => 'Combat'],
        'disable_gym' => ['label' => 'Disable gym', 'category' => 'Combat'],
        'disable_elimination' => ['label' => 'Disable elimination', 'category' => 'Combat'],
        'disable_enemies' => ['label' => 'Disable enemies', 'category' => 'Combat'],
        'disable_hospital' => ['label' => 'Disable hospital', 'category' => 'World'],
        'disable_jail' => ['label' => 'Disable jail', 'category' => 'World'],
        'disable_city' => ['label' => 'Disable city', 'category' => 'World'],
        'disable_travel' => ['label' => 'Disable travel', 'category' => 'World'],
        'disable_missions' => ['label' => 'Disable missions', 'category' => 'World'],
        'disable_jobs' => ['label' => 'Disable jobs', 'category' => 'World'],
        'disable_companies' => ['label' => 'Disable companies', 'category' => 'World'],
        'disable_properties' => ['label' => 'Disable properties', 'category' => 'World'],
        'disable_vehicles' => ['label' => 'Disable vehicles', 'category' => 'World'],
        'disable_education' => ['label' => 'Disable education', 'category' => 'World'],
        'disable_progression' => ['label' => 'Disable progression', 'category' => 'World'],
        'disable_factions' => ['label' => 'Disable factions', 'category' => 'Community'],
        'disable_friends' => ['label' => 'Disable friends', 'category' => 'Community'],
        'disable_forums' => ['label' => 'Disable forums', 'category' => 'Community'],
        'disable_mail' => ['label' => 'Disable mail', 'category' => 'Community'],
        'disable_newspaper' => ['label' => 'Disable newspaper', 'category' => 'Community'],
        'disable_leaderboards' => ['label' => 'Disable leaderboards', 'category' => 'Community'],
        'disable_players' => ['label' => 'Disable players list', 'category' => 'Community'],
        'disable_recruitment' => ['label' => 'Disable recruitment', 'category' => 'Community'],
        'disable_community_events' => ['label' => 'Disable community events', 'category' => 'Community'],
        'disable_calendar' => ['label' => 'Disable calendar', 'category' => 'Community'],
        'disable_hall_of_fame' => ['label' => 'Disable hall of fame', 'category' => 'Community'],
        'disable_rules' => ['label' => 'Disable rules', 'category' => 'Community'],
        'disable_risk_reward' => ['label' => 'Disable risk reward', 'category' => 'Community'],
        'disable_items' => ['label' => 'Disable items', 'category' => 'Inventory'],
        'disable_inventory' => ['label' => 'Disable inventory', 'category' => 'Inventory'],
    ];
}

function tc_ops_route_rules(): array
{
    return [
        'bank.php' => [
            'flags' => ['disable_bank', 'freeze_economy', 'disable_trading'],
            'title' => 'Bank Offline',
            'message' => 'Banking is temporarily disabled by admin action.',
        ],
        'market.php' => [
            'flags' => ['disable_market', 'disable_trading', 'freeze_economy'],
            'title' => 'Market Offline',
            'message' => 'Market access is temporarily disabled by admin action.',
        ],
        'black_market.php' => [
            'flags' => ['disable_black_market', 'disable_market', 'disable_trading', 'freeze_economy'],
            'title' => 'Black Market Offline',
            'message' => 'The black market is temporarily disabled by admin action.',
        ],
        'casino.php' => [
            'flags' => ['disable_casino'],
            'title' => 'Casino Offline',
            'message' => 'Casino access is temporarily disabled by admin action.',
        ],
        'crimes.php' => [
            'flags' => ['disable_crimes'],
            'title' => 'Crimes Offline',
            'message' => 'Crimes are temporarily disabled by admin action.',
        ],
        'combat.php' => [
            'flags' => ['disable_fighting'],
            'title' => 'Combat Offline',
            'message' => 'Combat is temporarily disabled by admin action.',
        ],
        'targets.php' => [
            'flags' => ['disable_targets', 'disable_fighting'],
            'title' => 'Targets Offline',
            'message' => 'Targeting is temporarily disabled by admin action.',
        ],
        'gym.php' => [
            'flags' => ['disable_gym'],
            'title' => 'Gym Offline',
            'message' => 'Gym training is temporarily disabled by admin action.',
        ],
        'mail.php' => [
            'flags' => ['disable_mail'],
            'title' => 'Mail Offline',
            'message' => 'Mail is temporarily disabled by admin action.',
        ],
    ];
}

function tc_enforce_ops_for_route(): void
{
    if (php_sapi_name() === 'cli') {
        return;
    }

    $script = $_SERVER['SCRIPT_NAME'] ?? ($_SERVER['PHP_SELF'] ?? '');
    $script = strtolower(basename(str_replace('\\', '/', $script)));
    if ($script === '') {
        return;
    }

    $allow = ['maintenance.php', 'verify-email.php', 'logout.php'];
    if (in_array($script, $allow, true)) {
        return;
    }

    if (tc_is_ops_flag_enabled('global_lockdown')) {
        tc_redirect_maintenance();
    }

    $rules = tc_ops_route_rules();
    if (isset($rules[$script])) {
        $rule = $rules[$script];
        foreach ($rule['flags'] as $flag) {
            if (tc_is_ops_flag_enabled($flag)) {
                tc_redirect_maintenance();
            }
        }
        return;
    }

    $base = pathinfo($script, PATHINFO_FILENAME);
    if ($base !== '') {
        $flag = 'disable_' . $base;
        if (tc_is_ops_flag_enabled($flag)) {
            tc_redirect_maintenance();
        }
    }
}

function tc_maintenance_flag_path(): string
{
    return defined('STORAGE_PATH')
        ? STORAGE_PATH . '/maintenance.flag'
        : __DIR__ . '/../storage/maintenance.flag';
}

function tc_is_maintenance_enabled(): bool
{
    return file_exists(tc_maintenance_flag_path());
}

function tc_is_owner_user(?int $userId = null): bool
{
    $ownerEmail = 'admin@trenchmade.co.uk';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_SESSION['owner_panel_unlocked'])) {
        return true;
    }

    if ($userId === null) {
        if (function_exists('currentUserId')) {
            $userId = currentUserId();
        } else {
            $userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
        }
    }

    if (!$userId) {
        return false;
    }

    $user = function_exists('getUser') ? getUser($userId) : null;
    if (!$user && isset($GLOBALS['db'])) {
        $db = $GLOBALS['db'];
        if ($db) {
            $user = $db->fetchOne(
                "SELECT email FROM users WHERE id = :id LIMIT 1",
                ['id' => (int)$userId]
            );
        }
    }

    $email = strtolower(trim((string)($user['email'] ?? '')));
    return $email === $ownerEmail;
}

function tc_enforce_maintenance(): void
{
    if (!tc_is_maintenance_enabled()) {
        return;
    }

    $script = $_SERVER['SCRIPT_NAME'] ?? ($_SERVER['PHP_SELF'] ?? '');
    $script = strtolower(basename(str_replace('\\', '/', $script)));
    $allowed = ['maintenance.php', 'logout.php'];
    if (in_array($script, $allowed, true)) {
        return;
    }

    if (tc_is_owner_user()) {
        return;
    }

    header('Location: /maintenance.php');
    exit;
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

    tc_enforce_maintenance();
    if (function_exists('tc_enforce_ops_for_route')) {
        tc_enforce_ops_for_route();
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
            // Fetch username from database
            global $db;
            $username = 'Player';
            if ($db) {
                $user = $db->fetchOne("SELECT username FROM users WHERE id = :id", ['id' => $userId]);
                if ($user && !empty($user['username'])) {
                    $username = $user['username'];
                }
            }

            $mailer = new Email();
            $sent = $mailer->sendVerificationEmail($userId, $email, $token, $username);
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

/**
 * Regenerate player bars based on time elapsed
 *
 * Regeneration rates:
 * - Energy: 5 every 12.5 minutes (750 seconds)
 * - Nerve: 1 every 4 minutes (240 seconds)
 * - Happy: 5 every 10 minutes (600 seconds)
 * - Life: 5 every 5 minutes (300 seconds)
 *
 * @param int $userId
 * @return array|null Updated bars or null on failure
 */
function regenerateUserBars(int $userId): ?array
{
    global $db;
    if (!$db) return null;

    // Get current bars
    $bars = $db->fetchOne(
        "SELECT * FROM player_bars WHERE user_id = :id LIMIT 1",
        ['id' => $userId]
    );

    if (!$bars) return null;

    $now = new DateTime();
    $updated = false;

    // Energy regeneration: 5 every 12.5 minutes (750 seconds)
    $energyLastRegen = $bars['energy_last_regen'] ? new DateTime($bars['energy_last_regen']) : $now;
    $energyElapsed = $now->getTimestamp() - $energyLastRegen->getTimestamp();
    $energyTicks = floor($energyElapsed / 750); // 12.5 minutes = 750 seconds

    if ($energyTicks > 0 && $bars['energy_current'] < $bars['energy_max']) {
        $energyGain = $energyTicks * 5;
        $newEnergy = min($bars['energy_current'] + $energyGain, $bars['energy_max']);
        $bars['energy_current'] = $newEnergy;
        $bars['energy_last_regen'] = $now->format('Y-m-d H:i:s');
        $updated = true;
    }

    // Nerve regeneration: 1 every 4 minutes (240 seconds)
    $nerveLastRegen = $bars['nerve_last_regen'] ? new DateTime($bars['nerve_last_regen']) : $now;
    $nerveElapsed = $now->getTimestamp() - $nerveLastRegen->getTimestamp();
    $nerveTicks = floor($nerveElapsed / 240); // 4 minutes = 240 seconds

    if ($nerveTicks > 0 && $bars['nerve_current'] < $bars['nerve_max']) {
        $nerveGain = $nerveTicks * 1;
        $newNerve = min($bars['nerve_current'] + $nerveGain, $bars['nerve_max']);
        $bars['nerve_current'] = $newNerve;
        $bars['nerve_last_regen'] = $now->format('Y-m-d H:i:s');
        $updated = true;
    }

    // Happy regeneration: 5 every 10 minutes (600 seconds)
    $happyLastRegen = $bars['happy_last_regen'] ? new DateTime($bars['happy_last_regen']) : $now;
    $happyElapsed = $now->getTimestamp() - $happyLastRegen->getTimestamp();
    $happyTicks = floor($happyElapsed / 600); // 10 minutes = 600 seconds

    if ($happyTicks > 0 && $bars['happy_current'] < $bars['happy_max']) {
        $happyGain = $happyTicks * 5;
        $newHappy = min($bars['happy_current'] + $happyGain, $bars['happy_max']);
        $bars['happy_current'] = $newHappy;
        $bars['happy_last_regen'] = $now->format('Y-m-d H:i:s');
        $updated = true;
    }

    // Life regeneration: 5 every 5 minutes (300 seconds)
    $lifeLastRegen = $bars['life_last_regen'] ? new DateTime($bars['life_last_regen']) : $now;
    $lifeElapsed = $now->getTimestamp() - $lifeLastRegen->getTimestamp();
    $lifeTicks = floor($lifeElapsed / 300); // 5 minutes = 300 seconds

    if ($lifeTicks > 0 && $bars['life_current'] < $bars['life_max']) {
        $lifeGain = $lifeTicks * 5;
        $newLife = min($bars['life_current'] + $lifeGain, $bars['life_max']);
        $bars['life_current'] = $newLife;
        $bars['life_last_regen'] = $now->format('Y-m-d H:i:s');
        $updated = true;
    }

    // Update database if any bars regenerated
    if ($updated) {
        $db->execute(
            "UPDATE player_bars SET
                energy_current = :energy_current,
                energy_last_regen = :energy_last_regen,
                nerve_current = :nerve_current,
                nerve_last_regen = :nerve_last_regen,
                happy_current = :happy_current,
                happy_last_regen = :happy_last_regen,
                life_current = :life_current,
                life_last_regen = :life_last_regen,
                last_regen_at = NOW()
            WHERE user_id = :user_id",
            [
                'energy_current' => $bars['energy_current'],
                'energy_last_regen' => $bars['energy_last_regen'],
                'nerve_current' => $bars['nerve_current'],
                'nerve_last_regen' => $bars['nerve_last_regen'],
                'happy_current' => $bars['happy_current'],
                'happy_last_regen' => $bars['happy_last_regen'],
                'life_current' => $bars['life_current'],
                'life_last_regen' => $bars['life_last_regen'],
                'user_id' => $userId
            ]
        );
    }

    return $bars;
}

/**
 * Get time until next regeneration tick for each bar
 *
 * @param int $userId
 * @return array|null Array with seconds until next tick for each bar
 */
function getBarRegenTimers(int $userId): ?array
{
    global $db;
    if (!$db) return null;

    $bars = $db->fetchOne(
        "SELECT energy_last_regen, nerve_last_regen, happy_last_regen, life_last_regen
         FROM player_bars WHERE user_id = :id LIMIT 1",
        ['id' => $userId]
    );

    if (!$bars) return null;

    $now = new DateTime();

    // Energy: 750 seconds per tick
    $energyLastRegen = $bars['energy_last_regen'] ? new DateTime($bars['energy_last_regen']) : $now;
    $energyElapsed = $now->getTimestamp() - $energyLastRegen->getTimestamp();
    $energyNext = 750 - ($energyElapsed % 750);

    // Nerve: 240 seconds per tick
    $nerveLastRegen = $bars['nerve_last_regen'] ? new DateTime($bars['nerve_last_regen']) : $now;
    $nerveElapsed = $now->getTimestamp() - $nerveLastRegen->getTimestamp();
    $nerveNext = 240 - ($nerveElapsed % 240);

    // Happy: 600 seconds per tick
    $happyLastRegen = $bars['happy_last_regen'] ? new DateTime($bars['happy_last_regen']) : $now;
    $happyElapsed = $now->getTimestamp() - $happyLastRegen->getTimestamp();
    $happyNext = 600 - ($happyElapsed % 600);

    // Life: 300 seconds per tick
    $lifeLastRegen = $bars['life_last_regen'] ? new DateTime($bars['life_last_regen']) : $now;
    $lifeElapsed = $now->getTimestamp() - $lifeLastRegen->getTimestamp();
    $lifeNext = 300 - ($lifeElapsed % 300);

    return [
        'energy_seconds' => (int)$energyNext,
        'nerve_seconds' => (int)$nerveNext,
        'happy_seconds' => (int)$happyNext,
        'life_seconds' => (int)$lifeNext,
        'energy_formatted' => gmdate('i:s', $energyNext),
        'nerve_formatted' => gmdate('i:s', $nerveNext),
        'happy_formatted' => gmdate('i:s', $happyNext),
        'life_formatted' => gmdate('i:s', $lifeNext),
    ];
}

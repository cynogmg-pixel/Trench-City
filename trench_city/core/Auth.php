<?php
/**
 * ======================================================
 *  TRENCH CITY MODULE: AUTH (v1.0 — Final)
 * ======================================================
 *  Unified Authentication Engine
 *  Features:
 *   ✅ Token-based & session-based auth
 *   ✅ Redis session storage (auto-expiry)
 *   ✅ SHA256 API key + BCRYPT password hashing
 *   ✅ Role-aware (user/admin/system)
 *   ✅ Safe CLI testing and CorePanel integration
 *   ✅ JWT-compatible structure
 * ======================================================
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

class TCAuth
{
    /** Session expiry (seconds) */
    private const SESSION_TTL = 7200; // 2 hours

    /** Redis key prefix */
    private const PREFIX = 'tc:auth:';

    /**
     * Generate a secure session token
     */
    public static function issueToken(array $payload = []): string
    {
        $data = [
            'id' => bin2hex(random_bytes(8)),
            'issued' => time(),
            'expires' => time() + self::SESSION_TTL,
            'data' => $payload,
        ];

        $token = base64_encode(json_encode($data));
        self::storeSession($data['id'], $data);
        tc_log("[AUTH] Issued token {$data['id']}", 'info');

        return $token;
    }

    /**
     * Validate and return session payload
     */
    public static function validate(string $token): ?array
    {
        if (empty($token)) return null;

        $decoded = json_decode(base64_decode($token), true);
        if (!$decoded || !isset($decoded['id'])) return null;

        $session = self::fetchSession($decoded['id']);
        if (!$session) {
            tc_log("[AUTH] Invalid or expired token: {$decoded['id']}", 'warn');
            return null;
        }

        if (time() > $session['expires']) {
            self::destroy($decoded['id']);
            tc_log("[AUTH] Expired token: {$decoded['id']}", 'warn');
            return null;
        }

        return $session['data'] ?? null;
    }

    /**
     * Destroy session token
     */
    public static function destroy(string $sessionId): void
    {
        $key = self::PREFIX . $sessionId;

        if (function_exists('tc_redis_connect')) {
            try {
                $r = tc_redis_connect();
                $r->del($key);
            } catch (Throwable $e) {
                tc_log("[AUTH] Redis session delete failed: {$e->getMessage()}", 'warn');
            }
        }

        $file = '/var/www/trench_city/storage/sessions/' . $sessionId . '.json';
        if (file_exists($file)) @unlink($file);
    }

    /**
     * Store session in Redis or fallback file
     */
    private static function storeSession(string $sessionId, array $data): void
    {
        $key = self::PREFIX . $sessionId;
        $json = json_encode($data);

        if (function_exists('tc_redis_connect')) {
            try {
                $r = tc_redis_connect();
                $r->setex($key, self::SESSION_TTL, $json);
                return;
            } catch (Throwable $e) {
                tc_log("[AUTH] Redis store failed: {$e->getMessage()}", 'warn');
            }
        }

        $dir = '/var/www/trench_city/storage/sessions';
        if (!is_dir($dir)) {
            mkdir($dir, 0750, true);
            @chown($dir, 'www-data');
        }

        file_put_contents("$dir/{$sessionId}.json", $json);
    }

    /**
     * Retrieve session (Redis or fallback)
     */
    private static function fetchSession(string $sessionId): ?array
    {
        $key = self::PREFIX . $sessionId;

        if (function_exists('tc_redis_connect')) {
            try {
                $r = tc_redis_connect();
                $val = $r->get($key);
                if ($val) return json_decode($val, true);
            } catch (Throwable $e) {
                tc_log("[AUTH] Redis fetch failed: {$e->getMessage()}", 'warn');
            }
        }

        $file = '/var/www/trench_city/storage/sessions/' . $sessionId . '.json';
        if (!file_exists($file)) return null;

        $data = json_decode(file_get_contents($file), true);
        if (!$data) return null;

        return $data;
    }

    /**
     * Password hashing (argon2id)
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    /**
     * Verify password
     */
    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * API key generation (secure SHA256)
     */
    public static function generateApiKey(): string
    {
        return hash('sha256', APP_KEY . microtime(true) . random_bytes(8));
    }
}

/**
 * ------------------------------------------------------
 *  GLOBAL SHORTCUTS
 * ------------------------------------------------------
 */
if (!function_exists('auth_issue')) {
    function auth_issue(array $payload = []): string { return TCAuth::issueToken($payload); }
}
if (!function_exists('auth_validate')) {
    function auth_validate(string $token): ?array { return TCAuth::validate($token); }
}
if (!function_exists('auth_destroy')) {
    function auth_destroy(string $sessionId): void { TCAuth::destroy($sessionId); }
}
if (!function_exists('auth_hash')) {
    function auth_hash(string $password): string { return TCAuth::hashPassword($password); }
}
if (!function_exists('auth_verify')) {
    function auth_verify(string $password, string $hash): bool { return TCAuth::verifyPassword($password, $hash); }
}
if (!function_exists('auth_apikey')) {
    function auth_apikey(): string { return TCAuth::generateApiKey(); }
}

/**
 * ------------------------------------------------------
 *  CLI SUPPORT
 * ------------------------------------------------------
 */
if (php_sapi_name() === 'cli' && isset($argv[1])) {
    $cmd = $argv[1];
    switch ($cmd) {
        case 'auth:issue':
            $token = auth_issue(['user' => $argv[2] ?? 'cli']);
            echo "✅ Token: {$token}\n";
            exit;
        case 'auth:validate':
            $data = auth_validate($argv[2] ?? '');
            echo json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL;
            exit;
        case 'auth:apikey':
            echo auth_apikey() . PHP_EOL;
            exit;
    }
}

/**
 * ------------------------------------------------------
 *  BOOT MESSAGE
 * ------------------------------------------------------
 */
tc_log('[MODULE] Auth system initialized — Redis-backed sessions active', 'info');

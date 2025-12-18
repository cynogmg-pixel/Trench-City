<?php
/**
 * ======================================================
 *  TRENCH CITY DATABASE CORE (FINAL)
 *  Secure PDO Connector + Auto-Reconnect + Logging
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) {
    define('TRENCH_CITY', true);
}

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';
// tc_log may not be loaded yet (bootstrap loads db before log.php); provide safe fallback.
if (!function_exists('tc_log')) {
    function tc_log(string $msg, string $level = 'info'): void {
        // noop fallback before log.php is loaded
    }
}

/**
 * ------------------------------------------------------
 *  Establish persistent PDO connection
 * ------------------------------------------------------
 */
function tc_db_connect(int $retries = 2): ?PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        try {
            $pdo->query('SELECT 1');
            return $pdo;
        } catch (Throwable $t) {
            $pdo = null; // Force reconnect
        }
    }

    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
        DB_HOST,
        DB_PORT,
        DB_NAME
    );

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_PERSISTENT         => true,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $attempt = 0;
    while ($attempt <= $retries) {
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            $pdo->query('SELECT 1'); // sanity check
            tc_log("✅ DB connected successfully to " . DB_HOST . ":" . DB_PORT, 'info');
            return $pdo;
        } catch (PDOException $e) {
            $attempt++;
            $msg = "[DB] Connection attempt {$attempt} failed: " . $e->getMessage();
            tc_log($msg, 'error');
            usleep(300000); // 0.3s delay between retries
            if ($attempt > $retries) {
                if (defined('DEBUG') && DEBUG) {
                    echo "<strong>Database error:</strong> " . htmlspecialchars($e->getMessage());
                }
                return null;
            }
        }
    }

    return null;
}

/**
 * ------------------------------------------------------
 *  Global DB Helper
 * ------------------------------------------------------
 */
function db(): ?PDO
{
    return tc_db_connect();
}

/**
 * ------------------------------------------------------
 *  Health Check
 * ------------------------------------------------------
 */
function tc_db_check(): bool
{
    try {
        $pdo = db();
        if (!$pdo) return false;

        $result = $pdo->query('SELECT 1')->fetchColumn();
        return (int)$result === 1;
    } catch (Throwable $t) {
        tc_log("[DB HEALTH] Failure: {$t->getMessage()}", 'error');
        return false;
    }
}

/**
 * ------------------------------------------------------
 *  TCDB WRAPPER (fetchOne, fetchAll, execute)
 * ------------------------------------------------------
 */
class TCDB
{
    private PDO $pdo;

    public function __construct()
    {
        $pdo = tc_db_connect();
        if (!$pdo) {
            throw new RuntimeException('Database connection unavailable.');
        }
        $this->pdo = $pdo;
    }

    public function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows ?: [];
    }

    public function execute(string $sql, array $params = []): int
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * PDO compatibility methods - for legacy code using PDO patterns
     */
    public function prepare(string $sql): PDOStatement
    {
        return $this->pdo->prepare($sql);
    }

    public function query(string $sql): PDOStatement|false
    {
        return $this->pdo->query($sql);
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function rollback(): bool
    {
        return $this->pdo->rollBack();
    }

    public function inTransaction(): bool
    {
        return $this->pdo->inTransaction();
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}

// Global DB wrapper instance (safe bootstrap)
if (!isset($GLOBALS['db']) || !$GLOBALS['db'] instanceof TCDB) {
    try {
        $GLOBALS['db'] = new TCDB();
    } catch (Throwable $e) {
        tc_log("[DB] Wrapper init failed: {$e->getMessage()}", 'error');
        $GLOBALS['db'] = null;
    }
}

/**
 * ------------------------------------------------------
 *  getDB() - Centralized database accessor
 *  Returns TCDB wrapper instance for consistent access
 * ------------------------------------------------------
 */
function getDB(): ?TCDB
{
    return $GLOBALS['db'] ?? null;
}

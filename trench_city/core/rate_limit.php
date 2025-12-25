<?php
/**
 * ======================================================
 *  TRENCH CITY MODULE: MODEL (v1.0 — Final)
 * ======================================================
 *  Lightweight ORM engine for database abstraction.
 *  Features:
 *   ✅ Safe MySQL query builder (PDO-based)
 *   ✅ Model-style interface (find, save, delete, where)
 *   ✅ Automatic table mapping by class name
 *   ✅ JSON + Array serialization
 *   ✅ Integrated logging and exception safety
 *   ✅ Works in CLI and Web modes
 * ======================================================
 *  Author: Architect
 * ======================================================
 */

if (!defined('TRENCH_CITY')) define('TRENCH_CITY', true);

abstract class TCModel implements JsonSerializable
{
    /** @var string Table name (auto-detected by default) */
    protected static string $table = '';

    /** @var string Primary key column */
    protected static string $primaryKey = 'id';

    /** @var array Attributes for this model */
    protected array $attributes = [];

    /** @var bool Indicates if record exists in DB */
    protected bool $exists = false;

    /** TCDB instance */
    protected static ?TCDB $db = null;

    /**
     * Initialize DB connection
     */
    protected static function db(): TCDB
    {
        if (!self::$db) {
            $conn = getDB();
            if (!$conn) {
                throw new RuntimeException('Database connection not available.');
            }
            self::$db = $conn;
        }
        return self::$db;
    }

    /**
     * Table name resolver
     */
    protected static function tableName(): string
    {
        if (static::$table !== '') return static::$table;
        $class = strtolower((new ReflectionClass(static::class))->getShortName());
        return $class . 's'; // Example: User -> users
    }

    /**
     * Find record by ID
     */
    public static function find(int|string $id): ?static
    {
        $table = static::tableName();
        $pk = static::$primaryKey;

        $row = self::db()->fetchOne("SELECT * FROM `$table` WHERE `$pk` = :id LIMIT 1", ['id' => $id]);

        if (!$row) return null;

        $model = new static();
        $model->fill($row);
        $model->exists = true;
        return $model;
    }

    /**
     * Where query (returns array of models)
     */
    public static function where(string $column, string $operator, mixed $value): array
    {
        $table = static::tableName();
        $rows = self::db()->fetchAll("SELECT * FROM `$table` WHERE `$column` $operator :value", ['value' => $value]);
        return array_map(function ($row) {
            $m = new static();
            $m->fill($row);
            $m->exists = true;
            return $m;
        }, $rows);
    }

    /**
     * Save record (insert or update)
     */
    public function save(): bool
    {
        $table = static::tableName();
        $pk = static::$primaryKey;

        if ($this->exists) {
            $columns = array_keys($this->attributes);
            $fields = [];
            $params = [];
            foreach ($columns as $col) {
                if ($col === $pk) continue;
                $fields[] = "`$col` = :$col";
                $params[$col] = $this->attributes[$col];
            }
            $params[$pk] = $this->attributes[$pk];
            $sql = "UPDATE `$table` SET " . implode(', ', $fields) . " WHERE `$pk` = :$pk";
        } else {
            $columns = array_keys($this->attributes);
            $placeholders = array_map(fn($c) => ':' . $c, $columns);
            $sql = "INSERT INTO `$table` (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
            $params = $this->attributes;
        }

        try {
            $affected = self::db()->execute($sql, $params);
            $success = $affected !== false;

            if (!$this->exists) {
                $this->attributes[$pk] = self::db()->lastInsertId();
                $this->exists = true;
            }

            tc_log("[MODEL] Saved record in {$table} ({$pk}={$this->attributes[$pk]})", 'info');
            return $success;
        } catch (Throwable $e) {
            tc_log("[MODEL] Save failed: {$e->getMessage()}", 'error');
            return false;
        }
    }

    /**
     * Delete record
     */
    public function delete(): bool
    {
        if (!$this->exists) return false;

        $table = static::tableName();
        $pk = static::$primaryKey;
        try {
            self::db()->execute("DELETE FROM `$table` WHERE `$pk` = :id", ['id' => $this->attributes[$pk]]);
            $this->exists = false;
            tc_log("[MODEL] Deleted record from {$table} ({$pk}={$this->attributes[$pk]})", 'info');
            return true;
        } catch (Throwable $e) {
            tc_log("[MODEL] Delete failed: {$e->getMessage()}", 'error');
            return false;
        }
    }

    /**
     * Fill model with attributes
     */
    public function fill(array $data): void
    {
        foreach ($data as $key => $val) {
            $this->attributes[$key] = $val;
        }
    }

    /**
     * Magic getter
     */
    public function __get(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * Magic setter
     */
    public function __set(string $name, mixed $value): void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Export as array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * JSON serialization
     */
    public function jsonSerialize(): mixed
    {
        return $this->attributes;
    }
}

/**
 * ------------------------------------------------------
 *  CLI TEST SUPPORT
 * ------------------------------------------------------
 */
if (php_sapi_name() === 'cli' && isset($argv[1])) {
    $cmd = $argv[1];
    if ($cmd === 'model:test') {
        class TestModel extends TCModel { protected static string $table = 'test_table'; }
        $m = new TestModel();
        $m->fill(['name' => 'CLI Tester', 'created_at' => date('Y-m-d H:i:s')]);
        $m->save();
        print_r($m->toArray());
        exit;
    }
}

/**
 * ------------------------------------------------------
 *  BOOT MESSAGE
 * ------------------------------------------------------
 */
tc_log('[MODULE] Model engine initialized — ORM-lite active', 'info');


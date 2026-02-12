<?php

declare(strict_types=1);

namespace BFrame\Core;

use PDO;
use PDOException;
use PDOStatement;

/**
 * Class Database
 * Simple PDO Abstraction Layer (Singleton)
 */
class Database
{
    /**
     * @var ?PDO
     */
    private static ?PDO $instance = null;

    /**
     * @var PDO
     */
    public private(set) ?PDO $connection = null;

    /**
     * Database constructor.
     */
    private function __construct()
    {
        try {
            $driver = DB_DRIVER;
            $host = HOSTNAME;
            $port = (string) DB_PORT;
            $db_name = DB_NAME;
            $user = DB_USER;
            $pass = DB_PASSWORD;
            $charset = DB_CHARSET;

            if ($driver === 'pgsql') {
                $dsn = "pgsql:host=$host;port=$port;dbname=$db_name";
            } else {
                // mysql or mariadb
                $dsn = "mysql:host=$host;port=$port;dbname=$db_name;charset=$charset";
            }

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new PDO($dsn, $user, $pass, $options);

        } catch (PDOException $e) {
            if (defined('DEBUG') && DEBUG) {
                throw new \RuntimeException("Connection Error: " . $e->getMessage());
            } else {
                throw new \RuntimeException("A database error occurred.");
            }
        }
    }

    /**
     * Get Database Instance (Singleton)
     */
    public static function getInstance(): ?PDO
    {
        if (!defined('DB_DRIVER') || empty(DB_DRIVER)) {
            return null;
        }

        if (self::$instance === null) {
            $db = new self();
            self::$instance = $db->connection;
        }

        return self::$instance;
    }

    /**
     * Execute a SQL query with parameters
     */
    public static function query(string $sql, array $params = []): PDOStatement
    {
        $instance = self::getInstance();
        if ($instance === null) {
            throw new \RuntimeException("Database is disabled. Check your DB_DRIVER configuration.");
        }
        $stmt = $instance->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Select data from a table
     * @return array<int, array<string, mixed>>
     */
    public static function select(string $table, array $conditions = [], string $fields = '*'): array
    {
        $sql = "SELECT $fields FROM $table";
        $params = [];

        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "$key = :$key";
                $params[$key] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        return self::query($sql, $params)->fetchAll();
    }

    /**
     * Insert data into a table
     */
    public static function insert(string $table, array $data): bool
    {
        $keys = array_keys($data);
        $fields = implode(', ', $keys);
        $placeholders = ':' . implode(', :', $keys);

        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";

        $stmt = self::query($sql, $data);
        return $stmt instanceof PDOStatement;
    }

    /**
     * Get last inserted ID
     */
    public static function lastInsertId(?string $name = null): string|false
    {
        $instance = self::getInstance();
        if ($instance === null) {
            return false;
        }
        return $instance->lastInsertId($name);
    }

    /**
     * Prevent cloning
     */
    private function __clone()
    {
    }

    /**
     * Prevent unserialize
     */
    public function __wakeup()
    {
    }
}

<?php

declare(strict_types=1);

namespace BFrame\Core;

use PDO;
use PDOException;
use PDOStatement;
use RuntimeException;

/**
 * Class Database
 * High-level PDO Abstraction Layer using the Singleton Pattern.
 * Refactored for PHP 8.4 compatibility and resilient connection handling.
 */
class Database
{
    /**
     * Singleton instance of PDO.
     */
    private static ?PDO $instance = null;

    /**
     * Private constructor to prevent direct instantiation.
     */
    private function __construct()
    {
    }

    /**
     * Returns the Singleton instance of the PDO connection.
     * * If DB_DRIVER is not defined or the connection fails, it returns null 
     * instead of throwing a fatal exception, allowing the app to degrade gracefully.
     * * @return PDO|null The active connection or null if unavailable.
     */
    public static function getInstance(): ?PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        /**
         * Check if the Database Driver is configured in the environment.
         * If not set, we assume the application can run without a database.
         */
        if (!defined('DB_DRIVER') || empty(DB_DRIVER)) {
            return null;
        }

        try {
            $dsn = self::buildDsn();

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false,
                PDO::ATTR_TIMEOUT => 2, // Fail fast (2s) if host is unreachable
            ];

            self::$instance = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
            return self::$instance;

        } catch (PDOException $e) {
            /**
             * Instead of crashing the whole app, we log the error to the server logs.
             * This prevents "Temporary failure in name resolution" from stopping the site.
             */
            error_log("BFrame Database Connection Failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Constructs the Data Source Name (DSN) string based on the driver.
     */
    private static function buildDsn(): string
    {
        $driver = DB_DRIVER;
        $host = HOSTNAME;
        $port = (string) DB_PORT;
        $dbName = DB_NAME;
        $charset = DB_CHARSET;

        return match ($driver) {
            'pgsql' => "pgsql:host=$host;port=$port;dbname=$dbName",
            'sqlite' => "sqlite:$dbName",
            default => "mysql:host=$host;port=$port;dbname=$dbName;charset=$charset",
        };
    }

    /**
     * Executes a SQL query with parameters using Prepared Statements.
     * * @throws RuntimeException If the database connection is not available.
     */
    public static function query(string $sql, array $params = []): PDOStatement
    {
        $pdo = self::getInstance();

        if (!$pdo) {
            throw new RuntimeException("Query failed: Database connection is offline or unconfigured.");
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Simple helper to select data from a specific table.
     * * @param string $table Table name.
     * @param array<string, mixed> $conditions WHERE clause as ['column' => 'value'].
     * @param string $fields Comma separated fields.
     * @return array<int, array<string, mixed>>
     */
    public static function select(string $table, array $conditions = [], string $fields = '*'): array
    {
        $sql = "SELECT $fields FROM `$table`";
        $params = [];

        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                // Use backticks to escape column names for SQL safety
                $where[] = "`$key` = :$key";
                $params[$key] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        return self::query($sql, $params)->fetchAll();
    }

    /**
     * Simple helper to insert data into a table.
     * * @param string $table Table name.
     * @param array<string, mixed> $data Associative array of data to insert.
     */
    public static function insert(string $table, array $data): bool
    {
        $keys = array_keys($data);
        $fields = '`' . implode('`, `', $keys) . '`';
        $placeholders = ':' . implode(', :', $keys);

        $sql = "INSERT INTO `$table` ($fields) VALUES ($placeholders)";

        return self::query($sql, $data) instanceof PDOStatement;
    }

    /**
     * Returns the ID of the last inserted row or sequence value.
     */
    public static function lastInsertId(?string $name = null): string|false
    {
        return self::getInstance()?->lastInsertId($name) ?? false;
    }

    /**
     * Prevent object cloning to maintain Singleton integrity.
     */
    private function __clone()
    {
    }

    /**
     * Prevent object unserialization.
     */
    public function __wakeup()
    {
        throw new RuntimeException("Serialization of Singleton classes is prohibited.");
    }
}
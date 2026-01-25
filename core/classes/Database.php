<?php
/**
 * Class Database
 * Simple PDO Abstraction Layer (Singleton)
 */
class Database
{
    /**
     * @var PDO
     */
    private static $instance;

    /**
     * @var PDO
     */
    private $connection;

    /**
     * Database constructor.
     */
    private function __construct()
    {
        try {
            $driver = DB_DRIVER;
            $host = HOSTNAME;
            $port = DB_PORT;
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
                die("Connection Error: " . $e->getMessage());
            } else {
                die("A database error occurred.");
            }
        }
    }

    /**
     * Get Database Instance (Singleton)
     * @return PDO
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            $db = new self();
            self::$instance = $db->connection;
        }

        return self::$instance;
    }

    /**
     * Execute a SQL query with parameters
     * @param string $sql
     * @param array $params
     * @return PDOStatement
     */
    public static function query($sql, $params = [])
    {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Select data from a table
     * @param string $table
     * @param array $conditions Key-value pairs for WHERE clause
     * @param string $fields
     * @return array
     */
    public static function select($table, $conditions = [], $fields = '*')
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
     * @param string $table
     * @param array $data Key-value pairs for column and value
     * @return bool
     */
    public static function insert($table, $data)
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
     * @param string|null $name Name of the sequence object (important for PostgreSQL)
     * @return string
     */
    public static function lastInsertId($name = null)
    {
        return self::getInstance()->lastInsertId($name);
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
    private function __wakeup()
    {
    }
}

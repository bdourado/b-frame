<?php

declare(strict_types=1);

namespace BFrame\Core;

use PDO;

/**
 * Class MainModel
 * The base model class that provides the database connection to all children.
 * Refactored to handle cases where the database might be offline.
 */
abstract class MainModel
{
    /**
     * The database connection instance.
     * We use a nullable PDO type (?) because the database might be 
     * disabled or unreachable.
     */
    protected readonly ?PDO $db;

    /**
     * MainModel constructor.
     * Initializes the database connection from the Singleton.
     */
    public function __construct()
    {
        /**
         * We assign the instance directly. If Database::getInstance() 
         * returns null (due to connection failure or missing driver), 
         * this class no longer throws a RuntimeException.
         */
        $this->db = Database::getInstance();
    }

    /**
     * Helper method to check if the database is currently connected.
     * Use this in child models before performing queries.
     */
    protected function isDbConnected(): bool
    {
        return $this->db !== null;
    }
}
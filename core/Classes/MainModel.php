<?php

declare(strict_types=1);

namespace BFrame\Core;

use PDO;

/**
 * MainModel - All models should extend this class
 */
class MainModel
{
    /**
     * @var PDO
     */
    protected readonly ?PDO $db;

    /**
     * MainModel constructor.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}
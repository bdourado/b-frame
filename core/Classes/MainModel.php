<?php

namespace BFrame\Core;

/**
 * MainModel - All models should extend this class
 */
class MainModel
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * MainModel constructor.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}
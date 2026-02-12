<?php

declare(strict_types=1);

/**
 * BFrame Configuration File
 */

// 1. Prevent direct access and ensure ABSPATH is available
if (!defined('ABSPATH')) {
    header('HTTP/1.1 403 Forbidden');
    exit('Direct access denied.');
}

// 2. Load Environment Variables
use BFrame\Core\EnvLoader;

// Path to EnvLoader based on project root
require_once ABSPATH . '/core/Classes/EnvLoader.php';
EnvLoader::load(ABSPATH . '/.env');

/**
 * Application Constants
 */

// Upload folder
define('UP_ABSPATH', ABSPATH . '/public/uploads');

// Home URL - Using getenv for flexibility
define('HOME_URI', getenv('HOME_URI') ?: 'http://bframe.local');

/**
 * Database Configuration
 */
define('DB_DRIVER', getenv('DB_DRIVER') ?: 'mysql');
define('HOSTNAME', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'bframe');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASSWORD', getenv('DB_PASS') ?: '1');
define('DB_CHARSET', 'utf8mb4'); // Updated to utf8mb4 for full emoji/special char support

// Database Port (Dynamic default based on driver)
$defaultPort = (DB_DRIVER === 'pgsql') ? '5432' : '3306';
define('DB_PORT', getenv('DB_PORT') ?: $defaultPort);

/**
 * Debug Mode
 * Converts the string 'true' from .env to a real boolean
 */
define('DEBUG', getenv('DEBUG') === 'true');
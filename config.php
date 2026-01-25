<?php
/**
 * App configuration
 */

/**
 * root folder
 */
define('ABSPATH', dirname(__FILE__));

/**
 * Load environment variables
 */
require_once ABSPATH . '/core/Classes/EnvLoader.php';
EnvLoader::load(ABSPATH . '/.env');

/**
 * upload folder
 */
define('UP_ABSPATH', ABSPATH . '/public/uploads');

/**
 * home URL
 */
define('HOME_URI', getenv('HOME_URI') ?: 'http://bframe.local');

/**
 * database driver (mysql or pgsql)
 */
define('DB_DRIVER', getenv('DB_DRIVER') ?: 'mysql');

/**
 * database host
 */
define('HOSTNAME', getenv('DB_HOST') ?: 'localhost');

/**
 * database port
 */
define('DB_PORT', getenv('DB_PORT') ?: (DB_DRIVER === 'pgsql' ? '5432' : '3306'));

/**
 * database name
 */
define('DB_NAME', getenv('DB_NAME') ?: 'bframe');

/**
 * database user
 */
define('DB_USER', getenv('DB_USER') ?: 'root');

/**
 * database password
 */
define('DB_PASSWORD', getenv('DB_PASS') ?: '1');

/**
 * database charset
 */
define('DB_CHARSET', 'utf8');

/**
 * debug value
 */
define('DEBUG', getenv('DEBUG') === 'true');


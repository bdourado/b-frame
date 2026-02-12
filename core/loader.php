<?php
/**
 * Prevent users from accessing this file directly
 */
if (!defined('ABSPATH'))
    exit;

/**
 * Autoloader (Custom PSR-4 or Composer fallback)
 */
require_once ABSPATH . '/core/Autoloader.php';
\BFrame\Core\Autoloader::register();

if (file_exists(ABSPATH . '/vendor/autoload.php')) {
    require_once ABSPATH . '/vendor/autoload.php';
}

/**
 * start the session
 */
session_start();

/**
 * verify debug value
 */
if (!defined('DEBUG') || DEBUG === false) {
    error_reporting(0);
    ini_set("display_errors", 0);
} else {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

/**
 * global functions & helpers
 */

/**
 * Load Routes
 */
require_once ABSPATH . '/app/routes.php';

/**
 * load the application
 */
BFrame\Core\Router::dispatch();
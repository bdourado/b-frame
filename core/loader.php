<?php
/**
 * Prevent users from accessing this file directly
 */
if (!defined('ABSPATH'))
    exit;

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
 * global functions
 */
require_once ABSPATH . '/core/functions.php';

/**
 * Load Router and Routes
 */
require_once ABSPATH . '/core/classes/Router.php';
require_once ABSPATH . '/app/routes.php';

/**
 * load the application
 */
Router::dispatch();
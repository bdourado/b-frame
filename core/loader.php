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
 * load the application
 */
$bFrame = new BFrame();
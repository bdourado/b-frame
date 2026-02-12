<?php

declare(strict_types=1);

/**
 * BFrame - A Lightweight MVC Framework
 * * Front Controller: All requests are routed through this file.
 */

// 1. Define the absolute path to the project root
// This prevents issues with relative paths in different environments
define('ABSPATH', dirname(__DIR__));

// 2. Load the configuration file
// Using absolute path for better performance and security
$configFile = ABSPATH . '/config.php';

if (!file_exists($configFile)) {
    header('HTTP/1.1 503 Service Unavailable');
    exit('The configuration file (config.php) is missing. Please create one.');
}

require_once $configFile;

// 3. Launch the application loader
// This will start sessions, autoloaders, and the router
$loaderFile = ABSPATH . '/core/loader.php';

if (!file_exists($loaderFile)) {
    header('HTTP/1.1 500 Internal Server Error');
    exit('Critical Error: Application loader not found.');
}

require_once $loaderFile;
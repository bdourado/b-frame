<?php

declare(strict_types=1);

/**
 * BFrame Loader - Senior Secured Entry Point
 * * Handles setup, environment, autoloader, session management,
 * and global error handling.
 */

// 1. Output Buffering - Prevents "headers already sent"
ob_start();

// 2. Strict Access Control
if (!defined('ABSPATH')) {
    header('HTTP/1.1 403 Forbidden');
    exit('Direct access denied.');
}

/**
 * 3. Environment & Configuration
 * Load environment variables before anything else
 */
require_once ABSPATH . '/core/Classes/EnvLoader.php';
\BFrame\Core\EnvLoader::load(ABSPATH . '/.env');

// Now we can define the DEBUG constant based on the .env
if (!defined('DEBUG')) {
    define('DEBUG', getenv('DEBUG') === 'true');
}

/**
 * 4. Secure Session Management
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,      // XSS Protection
        'cookie_secure' => !empty($_SERVER['HTTPS']), // HTTPS only if available
        'use_strict_mode' => true,      // Fixation Protection
        'cookie_samesite' => 'Lax',     // CSRF Protection
    ]);
}

/**
 * 5. Autoloading Infrastructure
 */
$composerAutoload = ABSPATH . '/vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
}

require_once ABSPATH . '/core/Autoloader.php';
\BFrame\Core\Autoloader::register();

/**
 * 6. Global Helper Functions
 */
if (!function_exists('e')) {
    /**
     * Escape HTML for safe output (XSS protection)
     */
    function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * 7. Global Exception & Error Handling
 */
$isDebug = DEBUG;
error_reporting($isDebug ? E_ALL : 0);
ini_set('display_errors', $isDebug ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', ABSPATH . '/logs/php_error.log');

try {
    // 8. Load Application Routes
    $routesPath = ABSPATH . '/app/routes.php';
    if (!file_exists($routesPath)) {
        throw new \RuntimeException("Critical file missing: app/routes.php");
    }
    require_once $routesPath;

    // 9. Dispatching the Application
    \BFrame\Core\Router::dispatch();

} catch (\Throwable $e) {
    if (ob_get_length()) {
        ob_clean(); // Clear output to show only the error page
    }

    error_log(sprintf(
        "[%s] %s in %s on line %d",
        get_class($e),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine()
    ));

    if ($isDebug) {
        // Dev Error Template
        echo "<div style='font-family:sans-serif; padding:20px; background:#fff1f2; border:1px solid #fda4af; color:#9f1239; border-radius:10px; margin:20px;'>";
        echo "<h1 style='margin-top:0;'>Fatal Error</h1>";
        echo "<p><strong>Message:</strong> " . e($e->getMessage()) . "</p>";
        echo "<p><strong>File:</strong> " . e($e->getFile()) . " on line " . $e->getLine() . "</p>";
        echo "<h3>Stack Trace:</h3><pre>" . e($e->getTraceAsString()) . "</pre>";
        echo "</div>";
    } else {
        // Production Error Template
        $errorPage = ABSPATH . '/app/Views/errors/500.php';
        http_response_code(500);
        if (file_exists($errorPage)) {
            require $errorPage;
        } else {
            echo "<h1>500 Internal Server Error</h1><p>Something went wrong on our end.</p>";
        }
    }
} finally {
    // Flush the buffer to the browser
    while (ob_get_level() > 0) {
        ob_end_flush();
    }
}
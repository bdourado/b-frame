<?php

declare(strict_types=1);

/**
 * BFrame Loader - Senior Secured Entry Point
 * 
 * This file handles the initial setup, autoloader, session management,
 * and error handling for the entire application.
 */

// 1. Output Buffering - Prevents "headers already sent" and allows header manipulation at any time
ob_start();

// 2. Strict Access Control
if (!defined('ABSPATH')) {
    header('HTTP/1.1 403 Forbidden');
    exit('Direct access denied.');
}

/**
 * 3. Secure Session Management
 * Prevents Session Hijacking and Fixation
 */
if (session_status() === PHP_SESSION_NONE) {
    if (headers_sent($file, $line)) {
        // Log error if headers were sent before session started
        error_log("Session could not start securely. Headers already sent in {$file} on line {$line}.");
    } else {
        session_start([
            'cookie_httponly' => true,      // Prevents JavaScript access to session cookie (XSS protection)
            'cookie_secure' => !empty($_SERVER['HTTPS']), // Only send cookies over HTTPS if available
            'use_strict_mode' => true,      // Prevents session fixation
            'cookie_samesite' => 'Lax',     // CSRF Protection
        ]);
    }
}

/**
 * 4. Autoloading Infrastructure
 */
// Prioritize Composer Autoloader
$composerAutoload = ABSPATH . '/vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
}

// Fallback to BFrame Custom Autoloader
require_once ABSPATH . '/core/Autoloader.php';
\BFrame\Core\Autoloader::register();

/**
 * 5. Global Exception & Error Handling
 */
$isDebug = defined('DEBUG') && DEBUG === true;

// Configure Error Reporting
error_reporting($isDebug ? E_ALL : 0);
ini_set('display_errors', $isDebug ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', ABSPATH . '/logs/php_error.log');

try {
    // 6. Load Application Routes
    $routesPath = ABSPATH . '/app/routes.php';
    if (!file_exists($routesPath)) {
        throw new \RuntimeException("Critical file missing: app/routes.php");
    }
    require_once $routesPath;

    // 7. Dispatching the Application
    \BFrame\Core\Router::dispatch();

} catch (\Throwable $e) {
    // Clean output buffer to avoid partial rendering on fatal error
    if (ob_get_length()) {
        ob_clean();
    }

    // Comprehensive logging
    error_log(sprintf(
        "[%s] %s in %s on line %d",
        get_class($e),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine()
    ));

    if ($isDebug) {
        // Rich error reporting for development
        echo "<div style='font-family:sans-serif; padding:20px; background:#fff1f2; border:1px solid #fda4af; color:#9f1239; border-radius:10px; margin:20px;'>";
        echo "<h1 style='margin-top:0;'>Fatal Error</h1>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " on line " . $e->getLine() . "</p>";
        echo "<h3>Stack Trace:</h3><pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        echo "</div>";
    } else {
        // Production-safe error landing
        $errorPage = ABSPATH . '/app/Views/errors/500.php';
        if (file_exists($errorPage)) {
            require $errorPage;
        } else {
            http_response_code(500);
            echo "<h1>500 Internal Server Error</h1><p>Something went wrong on our end.</p>";
        }
    }
} finally {
    // End output buffering and send output
    if (ob_get_length()) {
        ob_end_flush();
    }
}
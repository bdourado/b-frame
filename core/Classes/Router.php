<?php

declare(strict_types=1);

namespace BFrame\Core;

use BFrame\Core\Enums\HttpMethod;
use RuntimeException;
use Throwable;

/**
 * Class Router
 * * A high-performance, centralized routing engine for the BFrame framework.
 * Supports static routes, dynamic parameters, and API-aware error handling.
 */
class Router
{
    /** * @var array<int, array{method: HttpMethod, pattern: string, handler: string}> 
     * Stores registered routes with their HTTP methods and regex patterns.
     */
    private static array $routes = [];

    /**
     * Register a GET route
     */
    public static function get(string $path, string $handler): void
    {
        self::addRoute(HttpMethod::GET, $path, $handler);
    }

    /**
     * Register a POST route
     */
    public static function post(string $path, string $handler): void
    {
        self::addRoute(HttpMethod::POST, $path, $handler);
    }

    /**
     * Normalizes paths and converts curly-brace placeholders into Named Regex Groups.
     * Example: /user/{id} becomes #^user/(?P<id>[^/]+)$#D
     */
    private static function addRoute(HttpMethod $method, string $path, string $handler): void
    {
        $path = trim($path, '/');

        // Convert {param} to (?P<param>[^/]+)
        $pattern = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '(?P<$1>[^/]+)', $path);

        self::$routes[] = [
            'method' => $method,
            'pattern' => "#^" . ($pattern === '' ? '' : $pattern) . "$#D", // 'D' modifier prevents newline bypass
            'handler' => $handler
        ];
    }

    /**
     * Matches the current HTTP request against registered routes.
     * Handles 404 and 500 errors gracefully based on request type (Web vs API).
     */
    public static function dispatch(): void
    {
        // Extract URL path and sanitize
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $uri = trim($uri, '/');

        // Determine HTTP Method
        $rawMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $method = HttpMethod::tryFrom($rawMethod) ?: HttpMethod::GET;

        // Check if the request is targeting an API route
        $isApi = str_starts_with($uri, 'api/');

        try {
            foreach (self::$routes as $route) {
                // Validate Method and Regex Pattern
                if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {

                    // Filter matches to keep only named parameters (strings)
                    $params = array_filter($matches, fn($key) => is_string($key), ARRAY_FILTER_USE_KEY);

                    self::execute($route['handler'], $params);
                    return;
                }
            }

            self::respondNotFound($isApi, $uri);
        } catch (Throwable $e) {
            self::respondError($isApi, $e);
        }
    }

    /**
     * Instantiates the controller and invokes the specified method.
     * Supports "ControllerName@methodName" handler syntax.
     * * @throws RuntimeException If class or method does not exist.
     */
    private static function execute(string $handler, array $params): void
    {
        if (!str_contains($handler, '@')) {
            throw new RuntimeException("Invalid handler format. Expected 'Controller@method'.");
        }

        [$controllerName, $method] = explode('@', $handler);

        // Prepend default namespace if it's a short class name
        if (!str_contains($controllerName, 'BFrame\\')) {
            $controllerName = "BFrame\\App\\Controllers\\$controllerName";
        }

        if (!class_exists($controllerName)) {
            throw new RuntimeException("Controller class [$controllerName] not found.");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            throw new RuntimeException("Method [$method] not found in controller [$controllerName].");
        }

        // Execute using argument unpacking (PHP 8.x feature)
        // Passes parameters as an array to the controller method
        $controller->$method(...($params ? [$params] : []));
    }

    /**
     * Standardized 404 Not Found response.
     */
    private static function respondNotFound(bool $isApi, string $uri): never
    {
        http_response_code(404);

        if ($isApi) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 404, 'error' => 'Resource not found', 'path' => "/$uri"]);
            exit;
        }

        $viewPath = ABSPATH . '/app/Views/404.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "<h1>404</h1><p>Page Not Found</p>";
        }
        exit;
    }

    /**
     * Standardized 500 Internal Server Error response.
     * In Debug mode, it exposes the error; in Production, it shows a generic message.
     */
    private static function respondError(bool $isApi, Throwable $e): never
    {
        http_response_code(500);

        $showDetails = defined('DEBUG') && DEBUG === true;

        if ($isApi) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 500,
                'error' => 'Internal Server Error',
                'message' => $showDetails ? $e->getMessage() : 'An unexpected error occurred.'
            ]);
            exit;
        }

        // Rethrow the error so it can be handled by the global error handler (loader.php)
        throw $e;
    }
}
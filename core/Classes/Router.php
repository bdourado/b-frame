<?php

declare(strict_types=1);

namespace BFrame\Core;

use BFrame\Core\Enums\HttpMethod;
use BFrame\Core\Attributes\Route;
use ReflectionClass;
use Exception;

/**
 * Class Router
 * Modern Centralized Routing System for BFrame
 */
class Router
{
    /**
     * @var array Holds all registered routes
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
     * Add route to the internal storage
     */
    private static function addRoute(HttpMethod $method, string $path, string $handler): void
    {
        $path = trim($path, '/');
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = "#^" . $pattern . "$#";

        self::$routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    /**
     * Dispatch the request
     */
    public static function dispatch(): void
    {
        $uri = isset($_GET['path']) ? $_GET['path'] : '/';
        $uri = trim($uri, '/');
        $methodName = $_SERVER['REQUEST_METHOD'];
        $method = HttpMethod::tryFrom($methodName) ?: HttpMethod::GET;
        $isApi = str_starts_with($uri, 'api/');

        // Load Attribute-based routes from controllers
        self::loadAttributeRoutes();

        try {
            foreach (self::$routes as $route) {
                if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                    $params = array_filter($matches, fn($key) => is_string($key), ARRAY_FILTER_USE_KEY);
                    self::execute($route['handler'], $params);
                    return;
                }
            }

            self::respondNotFound($isApi, $uri);
        } catch (Exception $e) {
            self::respondError($isApi, $e);
        }
    }

    /**
     * Load routes defined in Controller Attributes
     */
    private static function loadAttributeRoutes(): void
    {
        $controllersDir = ABSPATH . '/app/Controllers';
        $files = self::getControllerFiles($controllersDir);

        foreach ($files as $file) {
            $class = self::getNamespaceFromFile($file);
            if (!$class || !class_exists($class)) continue;

            $reflection = new ReflectionClass($class);
            foreach ($reflection->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class);
                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    // Handler format: ControllerShortName@method
                    $shortName = str_replace(['BFrame\\App\\Controllers\\', '\\'], ['', '@'], $class);
                    $shortName = str_replace('@', '\\', $shortName); // Fix for subdirectories
                    self::addRoute($route->method, $route->path, "$shortName@{$method->getName()}");
                }
            }
        }
    }

    /**
     * Execute the controller method
     */
    private static function execute(string $handler, array $params): void
    {
        [$controllerName, $method] = explode('@', $handler);

        if (!str_contains($controllerName, 'BFrame\\')) {
            $controllerName = "BFrame\\App\\Controllers\\$controllerName";
        }

        if (!class_exists($controllerName)) {
            die("Class $controllerName not found");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            die("Method $method not found in $controllerName");
        }

        call_user_func_array([$controller, $method], [$params]);
    }

    private static function respondNotFound(bool $isApi, string $uri): never
    {
        if ($isApi) {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(['error' => 'Resource not found', 'path' => "/$uri"]);
            exit;
        }

        require_once ABSPATH . '/app/Views/404.php';
        exit;
    }

    private static function respondError(bool $isApi, Exception $e): never
    {
        if ($isApi) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
            exit;
        }
        throw $e;
    }

    private static function getControllerFiles(string $dir): array
    {
        $files = [];
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            $path = $dir . '/' . $item;
            if (is_dir($path)) {
                $files = array_merge($files, self::getControllerFiles($path));
            } else {
                $files[] = $path;
            }
        }
        return $files;
    }

    private static function getNamespaceFromFile(string $file): ?string
    {
        $content = file_get_contents($file);
        if (preg_match('/namespace\s+(.+?);/s', $content, $m)) {
            $namespace = $m[1];
            if (preg_match('/class\s+(\w+)/', $content, $m)) {
                return $namespace . '\\' . $m[1];
            }
        }
        return null;
    }
}

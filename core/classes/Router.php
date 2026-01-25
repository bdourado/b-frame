<?php
/**
 * Class Router
 * Centralized Routing System for BFrame
 */
class Router
{
    /**
     * @var array Holds all registered routes
     */
    private static $routes = [];

    /**
     * Register a GET route
     * @param string $path
     * @param string $handler Controller@method
     */
    public static function get($path, $handler)
    {
        self::addRoute('GET', $path, $handler);
    }

    /**
     * Register a POST route
     * @param string $path
     * @param string $handler Controller@method
     */
    public static function post($path, $handler)
    {
        self::addRoute('POST', $path, $handler);
    }

    /**
     * Add route to the internal storage
     */
    private static function addRoute($method, $path, $handler)
    {
        $path = trim($path, '/');
        // Convert Laravel-style {param} to Regex
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
    public static function dispatch()
    {
        $uri = isset($_GET['path']) ? $_GET['path'] : '/';
        $uri = trim($uri, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                // Filter matches to keep only named parameters
                $params = array_filter($matches, function ($key) {
                    return is_string($key);
                }, ARRAY_FILTER_USE_KEY);

                self::execute($route['handler'], $params);
                return;
            }
        }

        // 404 Not Found
        require_once ABSPATH . '/app/views/404.php';
    }

    /**
     * Execute the controller method
     */
    private static function execute($handler, $params)
    {
        list($controllerName, $method) = explode('@', $handler);

        $controllerFile = ABSPATH . '/app/controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            die("Controller $controllerName not found");
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            die("Class $controllerName not found");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            die("Method $method not found in $controllerName");
        }

        // Call the method and pass dynamic parameters
        call_user_func_array([$controller, $method], [$params]);
    }
}

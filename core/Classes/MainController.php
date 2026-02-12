<?php

declare(strict_types=1);

namespace BFrame\Core;

/**
 * MainController
 * * The base controller providing helper methods for views, JSON responses, 
 * and request data handling.
 */
abstract class MainController
{
    /**
     * Property Hook for JSON Request Body.
     * Accessing $this->body will lazily parse the php://input.
     */
    public ?array $body {
        get {
            $content = file_get_contents('php://input');
            if (empty($content)) {
                return null;
            }
            return json_decode($content, true) ?: null;
        }
    }

    /**
     * Renders a PHP view file.
     * * @param string $view Name of the view file (without .php)
     * @param array $data Data to be extracted into the view's scope
     */
    protected function view(string $view, array $data = []): void
    {
        // Use a safe variable name for the view path to avoid collisions with extracted $data
        $_viewPath = ABSPATH . '/app/Views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($_viewPath)) {
            // Throwing an exception is cleaner than die(), as it's caught by your Loader's try-catch
            throw new \RuntimeException("View [{$view}] not found at [{$_viewPath}]");
        }

        // Extract data into local scope
        if (!empty($data)) {
            extract($data);
        }

        require $_viewPath;
    }

    /**
     * Sends a JSON response and terminates execution.
     */
    protected function json(mixed $data, int $status = 200): never
    {
        // Ensure no previous output (like warnings) ruins the JSON header
        if (ob_get_length()) {
            ob_clean();
        }

        header('Content-Type: application/json; charset=utf-8');
        http_response_code($status);

        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        exit;
    }

    /**
     * Redirect to a specific URL
     */
    protected function redirect(string $url): never
    {
        header("Location: $url");
        exit;
    }
}
<?php

declare(strict_types=1);

namespace BFrame\Core;

/**
 * MainController - All controllers should extend this class
 */
class MainController
{
    /**
     * Render a view
     */
    public function view(string $name, array $params = []): void
    {
        if (!empty($params)) {
            extract($params);
        }

        $viewFile = ABSPATH . '/app/Views/' . $name . '.php';

        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("View $name not found");
        }
    }

    /**
     * Return a JSON response
     */
    public function json(mixed $data, int $status = 200): never
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    /**
     * Get JSON body from the request
     */
    public function getBody(): ?array
    {
        $json = file_get_contents('php://input');
        return json_decode($json, true) ?: null;
    }
}
<?php

declare(strict_types=1);

namespace BFrame\App\Controllers\Api;

use BFrame\Core\MainController;

class TestController extends MainController
{
    public function index(): never
    {
        $this->json([
            'status' => 'success',
            'message' => 'Modern BFrame API (PHP 8.1+)',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    public function create(): never
    {
        $data = $this->body;

        if ($data === null) {
            $this->json(['error' => 'Invalid JSON input'], 400);
        }

        $this->json([
            'status' => 'created',
            'received_data' => $data
        ], 201);
    }
}

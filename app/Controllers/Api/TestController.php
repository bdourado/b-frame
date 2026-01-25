<?php

declare(strict_types=1);

namespace BFrame\App\Controllers\Api;

use BFrame\Core\MainController;
use BFrame\Core\Attributes\Route;
use BFrame\Core\Enums\HttpMethod;

class TestController extends MainController
{
    #[Route('/api/test', method: HttpMethod::GET)]
    public function index(): never
    {
        $this->json([
            'status' => 'success',
            'message' => 'Modern BFrame API (PHP 8.1+)',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    #[Route('/api/test', method: HttpMethod::POST)]
    public function create(): never
    {
        $data = $this->getBody();

        if ($data === null) {
            $this->json(['error' => 'Invalid JSON input'], 400);
        }

        $this->json([
            'status' => 'created',
            'received_data' => $data
        ], 201);
    }
}

<?php

namespace BFrame\App\Controllers\Api;

use BFrame\Core\MainController;

class TestController extends MainController
{
    /**
     * GET /api/test
     */
    public function index()
    {
        $this->json([
            'status' => 'success',
            'message' => 'BFrame API is working!',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * POST /api/test
     */
    public function create()
    {
        $data = $this->getBody();

        if (!$data) {
            $this->json(['error' => 'Invalid JSON input'], 400);
        }

        $this->json([
            'status' => 'created',
            'received_data' => $data
        ], 201);
    }
}

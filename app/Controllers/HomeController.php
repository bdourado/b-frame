<?php

declare(strict_types=1);

namespace BFrame\App\Controllers;

use BFrame\Core\MainController;
use BFrame\App\Models\UserModel;

class HomeController extends MainController
{
    public function index(): void
    {
        $userModel = new UserModel();
        $userData = $userModel->getUser(1);

        $params = [
            'title' => 'BFrame',
            'author' => $userData['name'],
            'role' => $userData['role'],
            'date' => date('d/m/Y'),
            'text' => 'BFrame is a lightweight MVC framework, focused on learning and ideal for small projects. Simple, modern, and PHP 8.4 ready.',
            'linkedin' => 'https://www.linkedin.com/in/bruno-dourado-8a6a4813/',
            'github' => 'https://github.com/bdourado/'
        ];

        // Example of named arguments
        $this->view(view: 'welcome', data: $params);
    }
}
<?php

declare(strict_types=1);

namespace BFrame\App\Controllers;

use BFrame\Core\MainController;

class FeaturesController extends MainController
{
    public function index(): void
    {
        $params = [
            'title' => 'Features - BFrame',
            'features' => [
                [
                    'title' => 'PHP 8.4 Support',
                    'description' => 'Fully compatible with PHP 8.4, utilizing Property Hooks, Asymmetric Visibility, and Never types.',
                    'icon' => 'code'
                ],
                [
                    'title' => 'Docker Environment',
                    'description' => 'Pre-configured Docker setup with PHP-FPM, Nginx, and MySQL for instant development.',
                    'icon' => 'container'
                ],
                [
                    'title' => 'Modern Routing',
                    'description' => 'Attribute-based routing system with dynamic parameter matching and sub-directory support.',
                    'icon' => 'route'
                ],
                [
                    'title' => 'Singleton Database',
                    'description' => 'Robust singleton PDO abstraction with optional database support for simple projects.',
                    'icon' => 'database'
                ],
                [
                    'title' => 'Clean MVC',
                    'description' => 'A lightweight architecture that separates logic, data, and presentation for better maintainability.',
                    'icon' => 'mvc'
                ],
                [
                    'title' => 'PSR-4 Autoloading',
                    'description' => 'Consistent and optimized class loading following modern PHP standards.',
                    'icon' => 'autoloader'
                ]
            ]
        ];

        $this->view('features', $params);
    }
}

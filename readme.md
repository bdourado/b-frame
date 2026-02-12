# BFrame 🏆

A lightweight, modern, and educational PHP MVC framework. BFrame is designed to be simple enough for study yet powerful enough for small production-ready projects.

## 🚀 Modern Features (v2.0)

- **PHP 8.4 Optimized**: Built for the latest PHP standards, utilizing **Property Hooks**, **Asymmetric Visibility**, and **Never** types.
- **Clean MVC Architecture**: Strict separation between Models, Controllers, and Views.
- **Centralized Routing**: Explicit route management in `app/routes.php`.
- **Bulletproof Security**: Advanced session protection (`cookie_httponly`, `cookie_samesite`, `use_strict_mode`) and automated Output Buffering.
- **Advanced Error Handling**: Global `Throwable` catch with production-safe error masking and detailed logging to `logs/php_error.log`.
- **Friendly URLs**: Standard clean URL routing via `REQUEST_URI`.
- **Premium UI**: Modern default interface built with **Tailwind CSS**, featuring glassmorphism and smooth animations.
- **Docker-Ready**: Zero-config development environment with PHP 8.4-fpm, Nginx, and MySQL.
- **Optional Database**: Simplified PDO abstraction that works with or without an active database connection.
- **REST API Native**: Built-in support for JSON responses and request body handling via Property Hooks (`$this->body`).
- **PSR-4 Autoloading**: Consistent class loading following modern standards.

## 📁 Project Structure

```text
BFrame/
├── app/                # Application logic
│   ├── Controllers/    # Controller classes
│   ├── Models/         # Data models
│   ├── Views/          # Tailwind CSS templates
│   └── routes.php      # Centralized routes definition (Primary)
├── core/               # Framework core
│   ├── Classes/        # Core framework classes (Database, Router, etc.)
│   ├── Autoloader.php  # PSR-4 Autoloader implementation
│   └── loader.php      # Application bootstrapper
├── public/              # Web root (Entry point)
│   ├── index.php       # Main entry point
│   └── uploads/        # Uploaded files
├── docker/             # Docker configuration files
├── .env                # Environment variables (ignored by git)
├── .htaccess           # URL rewriting for Apache
├── Dockerfile          # PHP 8.4-fpm image definition
├── docker-compose.yml  # Service orchestration
├── composer.json       # Dependencies & Autoload config
└── readme.md           # Documentation
```

## 🛠️ Quick Start

### 1. Docker Setup (Recommended)
BFrame is designed to run instantly with Docker.

1. Copy `.env.example` to `.env`.
2. Start the environment:
```bash
docker-compose up -d --build
```
3. Access: `http://localhost:8080`

### 2. Manual Requirements
- PHP 8.4+
- Nginx/Apache with URL rewriting.
- PDO Extensions (MySQL/PgSQL).

## 📖 Basic Usage

### 🛣️ Routing
All routes are registered in `app/routes.php`. BFrame uses clean URLs by default.

```php
use BFrame\Core\Router;

Router::get('/', 'HomeController@index');
Router::get('/features', 'FeaturesController@index');
Router::get('/api/test', 'Api\TestController@index');
```

### 🎮 Controllers
Controllers extend `BFrame\Core\MainController`. Accessing the request body is now done via a modern Property Hook.

```php
namespace BFrame\App\Controllers;

use BFrame\Core\MainController;

class HomeController extends MainController {
    public function index() {
        // Render a view
        $this->view('welcome', ['title' => 'Hello BFrame']);
    }

    public function create() {
        // Access JSON body via Property Hook (PHP 8.4)
        $data = $this->body; 
        $this->json(['status' => 'success']);
    }
}
```

### 💾 Database & Models
BFrame provide a singleton PDO wrapper. The database is optional and can be disabled in `.env` by leaving `DB_DRIVER` empty.

```php
namespace BFrame\App\Models;

use BFrame\Core\Database;
use BFrame\Core\MainModel;

class UserModel extends MainModel {
    public function getUser($id) {
        return Database::select('users', ['id' => $id]);
    }
}
```

## 📄 License
This project is open-source under the MIT License. Created for educational purposes and lightweight development.

---
*Maintained by [Bruno M. Dourado](https://github.com/bdourado/)*

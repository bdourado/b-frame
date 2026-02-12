# BFrame 🏆

**A modern, lightweight, and secure PHP MVC framework optimized for PHP 8.4.**

BFrame provides a professional starting point for small projects and educational study, featuring a clean architecture, resilient database handling, and enterprise-grade security defaults.

---

## 🚀 Key Features (v2.0)

### 🐘 PHP 8.4 Powered
Built to leverage the latest language features:
- **Property Hooks**: Modern data access in Controllers (`$this->body`).
- **Asymmetric Visibility**: Secure encapsulation in Core classes.
- **Never Return Type**: Explicit handling of redirects and JSON responses.

### 🛡️ Enterprise-Grade Security
- **Secure Sessions**: Pre-configured with `HttpOnly`, `SameSite=Lax`, and `Strict Mode` to prevent hijacking.
- **Output Buffering**: Global buffering prevents "headers already sent" errors and enables safe header manipulation.
- **XSS Protection**: Global `e()` helper for safe HTML output.
- **Error Handling**: Production-safe error pages (500) with detailed internal logging (`logs/php_error.log`).

### ⚡ Resilient Architecture
- **Lazy Database Connection**: The application **does not crash** if the database is offline. It degrades gracefully or serves static content.
- **Robust Autoloading**: Prioritizes Composer but includes a high-performance custom PSR-4 fallback.
- **Centralized Routing**: Explicit, easy-to-read route definitions in `app/routes.php`.

### 🎨 Premium UI
- **Tailwind CSS**: Pre-configured with a modern dark-mode aesthetic.
- **Glassmorphism**: Beautiful default views for Welcome, Features, 404, and 500 pages.

---

## 🛠️ Requirements

- **PHP 8.4** or higher
- **Composer** (Optional, for dependencies)
- **PDO Extension** (MySQL, PostgreSQL, or SQLite)
- **Web Server** (Nginx, Apache, or Docker)

---

## 🚀 Getting Started

### Option 1: Docker (Recommended)
Get up and running in seconds with the included Docker environment.

1. **Clone & Config**:
   ```bash
   cp .env.example .env
   ```

2. **Launch**:
   ```bash
   docker-compose up -d --build
   ```

3. **Visit**: [http://localhost:8080](http://localhost:8080)

### Option 2: Manual Installation
1. Configure your web server to point to `public/`.
2. Ensure URL rewriting is enabled (redirect all requests to `index.php`).
3. Set up your `.env` file with your database credentials.

---

## 📖 Documentation

### 1. Routing
Routes are defined centrally in `app/routes.php`. This provides a single source of truth for your application's endpoints.

```php
use BFrame\Core\Router;

// Web Routes
Router::get('/', 'HomeController@index');
Router::get('/features', 'FeaturesController@index');

// API Routes (automatically return JSON on error)
Router::post('/api/users', 'Api\UserController@create');
```

### 2. Controllers
Controllers extend `BFrame\Core\MainController`. You have access to powerful helpers for Views and APIs.

```php
namespace BFrame\App\Controllers;

use BFrame\Core\MainController;

class HomeController extends MainController
{
    public function index()
    {
        // Render a view with data
        $this->view('welcome', ['title' => 'BFrame']);
    }

    public function api()
    {
        // PHP 8.4 Property Hook for JSON Body
        $data = $this->body; 
        
        $this->json(['received' => $data], 201);
    }
}
```

### 3. Database (Singleton)
The `Database` class is a resilient Singleton. It wraps PDO and handles connection failures gracefully.

```php
namespace BFrame\App\Models;

use BFrame\Core\Database;
use BFrame\Core\MainModel;

class UserModel extends MainModel
{
    public function find(int $id)
    {
        // Check if DB is actually connected before querying
        if ($this->db) {
            return Database::select('users', ['id' => $id]);
        }
        
        // Fallback or mock data if DB is down
        return ['id' => $id, 'name' => 'Fallback User'];
    }
}
```

### 4. Configuration
All configuration is handled via `.env`.

```ini
DB_DRIVER=mysql
DB_HOST=db
DB_NAME=bframe
DB_USER=root
DB_PASS=1
DEBUG=true
```

> **Note**: In production, set `DEBUG=false` to hide stack traces and show the friendly 500 Global Error page.

---

## 📂 Directory Structure

```text
/
├── app/
│   ├── Controllers/   # Request Handlers
│   ├── Models/        # Data & Logic
│   ├── Views/         # Templates (Tailwind CSS)
│   └── routes.php     # Route Definitions
├── core/              # Framework Core (Router, DB, etc.)
├── public/            # Web Entry Point
├── logs/              # Error Logs
├── docker/            # Nginx & PHP Configs
└── ...
```

---

## 📄 License

This framework is open-source software licensed under the **MIT license**.

---
*Maintained by [Bruno M. Dourado](https://github.com/bdourado)*

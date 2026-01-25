# BFrame 🏆

A lightweight, simple, and educational PHP MVC framework designed for study and small projects.

## 🚀 Features

- **MVC Architecture**: Clear separation of concerns between Models, Controllers, and Views.
- **Centralized Routing**: Laravel-style route definitions directly in `app/routes.php`.
- **Environment Variables**: Manage sensitive data using `.env` files.
- **Database Abstraction Layer**: Unified PDO-based interaction for MySQL, MariaDB, and PostgreSQL.
- **Centralized Configuration**: All settings managed in a single `config.php` file.
- **Auto-loading**: Core classes and controllers are loaded automatically.
- **Friendly URLs**: Support for clean, SEO-friendly paths using `.htaccess`.

## 📁 Project Structure

```text
BFrame/
├── app/                # Application logic
│   ├── Controllers/    # Controller classes
│   ├── Views/          # Template files
│   ├── Models/         # Data models
│   └── routes.php      # Centralized routes definition
├── core/               # Framework core
│   ├── Classes/        # Core framework classes (Database, Router, etc.)
│   ├── functions.php   # Global helper functions
│   └── loader.php      # Application bootstrapper
├── public/              # Web root (Entry point)
│   ├── index.php       # Main entry point
│   └── uploads/        # Uploaded files
├── .env                # Sensitive environment variables (ignored by git)
├── .htaccess           # URL rewriting and security rules
├── composer.json       # Composer configuration
├── config.php          # Main configuration file
└── readme.md           # Documentation
```

## 🛠️ Getting Started

### 1. Installation
BFrame works natively but supports Composer for dependency management.

```bash
# Optional: Install dependencies if using Composer
composer install
```

Copy the `.env.example` file to `.env`:
```bash
cp .env.example .env
```

Edit the `.env` file to match your environment:
```env
DB_DRIVER=mysql
DB_HOST=localhost
DB_PORT=3306
DB_NAME=bframe
DB_USER=root
DB_PASS=your_password
DEBUG=true
HOME_URI=http://bframe.local
```

### 2. Requirements & Setup
- PHP 7.4+
- Apache with `mod_rewrite` enabled (for friendly URLs)
- PDO extensions for your chosen database (MySQL, MariaDB, or PostgreSQL)

### 3. Security Best Practices
- **Protect .env**: The internal `.htaccess` blocks public access to `.env`.
- **Production**: For maximum security, move the `.env` file outside the `public_html` folder or set environment variables at the OS/Server level.

---

### 3. Docker Setup (Recommended)
You can run BFrame using Docker Compose for a complete environment (PHP, Nginx, MySQL).

1. Ensure you have an `.env` file (copied from `.env.example`).
2. Build and start the containers:
```bash
docker-compose up -d --build
```
3. Access the application at: `http://localhost:8080`

### 4. Namespaces
The framework uses the `BFrame` root namespace:
- **Core**: `BFrame\Core` (Database, Router, MainController, etc.)
- **App**: `BFrame\App\Controllers` and `BFrame\App\Models`

---

## 📖 Basic Usage

### 🛣️ Defining Routes
All routes are registered in `app/routes.php`.

```php
Router::get('/', 'HomeController@index');
Router::get('/user/{id}', 'UserController@show');
Router::post('/contact/send', 'ContactController@send');
```

### 💾 Database Operations
BFrame provides a simplified PDO abstraction layer. Models should extend `BFrame\Core\MainModel`.

```php
namespace BFrame\App\Models;

use BFrame\Core\Database;
use BFrame\Core\MainModel;

class UserModel extends MainModel {
    public function find($id) {
        return Database::select('users', ['id' => $id]);
    }
}
```

### 🎮 Controllers & Views
Controllers should extend `BFrame\Core\MainController`.

```php
namespace BFrame\App\Controllers;

use BFrame\Core\MainController;

class HomeController extends MainController {
    public function index() {
        $this->view('welcome', ['name' => 'BFrame User']);
    }
}
```

```php
// app/views/welcome.php
<h1>Welcome, <?= $name ?>!</h1>
```

## 📄 License
This project is open-source and created for educational purposes. Feel free to use and modify it!

---
*Created by [Bruno M. Dourado](https://github.com/bdourado/)*

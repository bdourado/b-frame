# BFrame 🏆

A lightweight, simple, and educational PHP MVC framework designed for study and small projects.

## 🚀 Features

- **MVC Architecture**: Clear separation of concerns between Models, Controllers, and Views.
- **Centralized Routing**: Laravel-style route definitions directly in `app/routes.php`.
- **Environment Variables**: Manage sensitive data using `.env` files.
- **Database Abstraction Layer**: Unified PDO-based interaction for MySQL, MariaDB, and PostgreSQL.
- **Centralized Configuration**: All settings managed in a single `config.php` file.
- **Auto-loading**: Core classes and controllers are loaded automatically.
- **Friendly URLs**: Support for clean, SEO-friendly paths.

## 📁 Project Structure

```text
BFrame/
├── app/                # Application logic
│   ├── controllers/    # Controller classes
│   ├── views/          # Template files
│   └── models/         # Data models (optional)
├── core/               # Framework core
│   ├── classes/        # Core framework classes
│   ├── functions.php   # Global helper functions
│   └── loader.php      # Application bootstrapper
├── public/              # Web root
│   ├── index.php       # Entry point
│   └── uploads/        # Uploaded files
├── config.php          # Main configuration file
└── readme.md           # Documentation
```

## 🛠️ Getting Started

### 1. Environment Configuration
Copy the `.env.example` file to `.env` and fill in your credentials:

```bash
cp .env.example .env
```

Edit the `.env` file:
```env
DB_HOST=localhost
DB_NAME=bframe
DB_USER=root
DB_PASS=your_password
DEBUG=true
HOME_URI=http://bframe.local
```

> [!IMPORTANT]
> Never commit your `.env` file to version control. It is already added to `.gitignore`.

### 2. Security Best Practices
- **Protect .env**: The framework includes a `.htaccess` file to block direct access to `.env` on Apache servers.
- **Production**: In production environments, it's recommended to move the `.env` file outside of the web root or set environment variables directly at the server level (e.g., in Nginx, Apache, or Docker config).

### 3. Basic Usage

#### Defining Routes
All routes are defined in `app/routes.php`.

```php
// app/routes.php
Router::get('/', 'HomeController@index');
Router::get('/user/{id}', 'UserController@show');
Router::post('/contact/send', 'ContactController@send');
```

#### Creating a Controller
Controllers should be placed in `app/controllers/` and named like `ControllerName.php`.

```php
class HomeController extends MainController {
    public function index() {
        $this->view('welcome', ['title' => 'BFrame']);
    }
}
```

#### Creating a View
Views go into `app/views/`.

```php
// app/views/welcome.php
<h1>Welcome to <?php echo $title; ?></h1>
```

## 📄 License
This project is for educational purposes. Feel free to use and modify!

---
*Created by [Bruno M. Dourado](https://github.com/bdourado/)*

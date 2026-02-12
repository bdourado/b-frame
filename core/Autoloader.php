<?php

declare(strict_types=1);

namespace BFrame\Core;

/**
 * Custom PSR-4 Autoloader
 * 
 * This class handles mapping namespaces to the filesystem for cases
 * where Composer is not used.
 */
class Autoloader
{
    /**
     * Map of namespace prefixes to base directories.
     */
    protected static array $prefixes = [
        'BFrame\\Core\\' => ABSPATH . '/core/Classes/',
        'BFrame\\App\\' => ABSPATH . '/app/',
    ];

    /**
     * Register the autoloader with SPL.
     */
    public static function register(): void
    {
        spl_autoload_register([self::class, 'loadClass']);
    }

    /**
     * Load the requested class.
     * 
     * @param string $class The fully-qualified class name.
     * @return bool True if loaded, false otherwise.
     */
    public static function loadClass(string $class): bool
    {
        foreach (self::$prefixes as $prefix => $base_dir) {
            // Check if the class uses the namespace prefix
            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                continue;
            }

            // Get the relative class name
            $relative_class = substr($class, $len);

            // Replace the namespace separator with the directory separator
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            // If the file exists, require it
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
        }

        // Fallback for non-namespaced classes in Core/Classes for legacy support
        $legacy_file = ABSPATH . '/core/Classes/' . $class . '.php';
        if (file_exists($legacy_file)) {
            require_once $legacy_file;
            return true;
        }

        return false;
    }
}

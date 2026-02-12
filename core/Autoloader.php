<?php

declare(strict_types=1);

namespace BFrame\Core;

/**
 * Custom PSR-4 Autoloader
 * * Efficiently maps namespaces to the filesystem, supporting multiple base directories
 * and providing a fallback for legacy core classes.
 */
class Autoloader
{
    /**
     * Map of namespace prefixes to base directories.
     * @var array<string, string>
     */
    protected static array $prefixes = [
        'BFrame\\Core\\' => ABSPATH . '/core/Classes/',
        'BFrame\\App\\' => ABSPATH . '/app/',
    ];

    /**
     * Register the autoloader with the SPL autoload stack.
     */
    public static function register(): void
    {
        spl_autoload_register([self::class, 'loadClass']);
    }

    /**
     * Load the requested class by mapping its namespace to a file path.
     * * @param string $class The fully-qualified class name.
     * @return bool True if the file was found and loaded.
     */
    public static function loadClass(string $class): bool
    {
        foreach (self::$prefixes as $prefix => $baseDir) {
            // Check if the class starts with the prefix
            if (!str_starts_with($class, $prefix)) {
                continue;
            }

            // Get the relative class name (remove prefix)
            $relativeClass = substr($class, strlen($prefix));

            // Map namespace separators to directory separators
            $path = str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass);
            $file = $baseDir . $path . '.php';

            if (self::requireFile($file)) {
                return true;
            }
        }

        // Optimized Legacy Fallback: Only check if class doesn't contain backslashes
        if (!str_contains($class, '\\')) {
            return self::requireFile(ABSPATH . '/core/Classes/' . $class . '.php');
        }

        return false;
    }

    /**
     * Helper to require a file if it exists.
     * Separating this improves performance and makes it easier to debug.
     */
    private static function requireFile(string $file): bool
    {
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
        return false;
    }
}
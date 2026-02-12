<?php

declare(strict_types=1);

namespace BFrame\Core;

use RuntimeException;

/**
 * Class EnvLoader
 * * A robust and secure loader for .env environment files.
 */
class EnvLoader
{
    /**
     * Load and parse a .env file into environment variables.
     * * @param string $path Absolute path to the .env file.
     * @throws RuntimeException If the file is not readable.
     */
    public static function load(string $path): void
    {
        if (!file_exists($path)) {
            return;
        }

        if (!is_readable($path)) {
            throw new RuntimeException("The .env file at [{$path}] is not readable.");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip comments and invalid lines
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }

            // Ensure the line contains an '='
            if (!str_contains($line, '=')) {
                continue;
            }

            // Split into name and value, limiting to 2 parts
            [$name, $value] = explode('=', $line, 2);

            $name = trim($name);
            $value = trim($value);

            // Remove surrounding quotes if present (e.g., "value" or 'value')
            if (preg_match('/^["\'](.*)["\']$/', $value, $matches)) {
                $value = $matches[1];
            }

            if ($name !== '') {
                // Set environment variables in all global stacks
                putenv("{$name}={$value}");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}
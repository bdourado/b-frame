<?php

declare(strict_types=1);

namespace BFrame\Core\Enums;

/**
 * Enum HttpMethod
 * Represents standard HTTP methods and provides utility helpers.
 */
enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case PATCH = 'PATCH';
    case OPTIONS = 'OPTIONS';

    /**
     * Checks if the current method allows a request body (payload).
     */
    public function hasBody(): bool
    {
        return match ($this) {
            self::POST, self::PUT, self::PATCH => true,
            default => false,
        };
    }

    /**
     * Checks if the method is "safe" (doesn't modify state on the server).
     */
    public function isSafe(): bool
    {
        return match ($this) {
            self::GET, self::OPTIONS => true,
            default => false,
        };
    }

    /**
     * Validates and returns an Enum case from a raw string, defaulting to GET.
     */
    public static function fromRequest(string $method): self
    {
        return self::tryFrom(strtoupper($method)) ?? self::GET;
    }
}
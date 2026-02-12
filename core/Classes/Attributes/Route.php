<?php

declare(strict_types=1);

namespace BFrame\Core\Attributes;

use Attribute;
use BFrame\Core\Enums\HttpMethod;

/**
 * Attribute Route
 * * Allows defining routes directly on Controller methods using PHP 8 Attributes.
 * Target: Methods
 * Repeatable: Yes (A single method can handle multiple routes)
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Route
{
    /**
     * @param string $path The URL path (e.g., '/users/{id}')
     * @param HttpMethod $method The HTTP verb (GET, POST, etc.)
     * @param string|null $name Optional route name for reverse routing
     */
    public function __construct(
        public string $path,
        public HttpMethod $method = HttpMethod::GET,
        public ?string $name = null
    ) {
        // Normalize path: ensure it starts with / but doesn't end with it (unless it's just /)
        $this->path = '/' . ltrim(trim($path), '/');
        if ($this->path !== '/') {
            $this->path = rtrim($this->path, '/');
        }
    }
}
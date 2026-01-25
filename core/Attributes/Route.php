<?php

declare(strict_types=1);

namespace BFrame\Core\Attributes;

use Attribute;
use BFrame\Core\Enums\HttpMethod;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Route
{
    public function __construct(
        public string $path,
        public HttpMethod $method = HttpMethod::GET
    ) {
    }
}

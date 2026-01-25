<?php

declare(strict_types=1);

namespace BFrame\App\Models;

use BFrame\Core\MainModel;

/**
 * Class UserModel
 * Example model representing a user
 */
class UserModel extends MainModel
{
    /**
     * Get mock data for a user
     */
    public function getUser(int $id): array
    {
        // Mock data for demonstration
        return [
            'id' => $id,
            'name' => 'Bruno M. Dourado',
            'role' => 'Principal Architect',
            'framework' => 'BFrame Modern'
        ];
    }
}

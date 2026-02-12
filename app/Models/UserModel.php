<?php

declare(strict_types=1);

namespace BFrame\App\Models;

use BFrame\Core\MainModel;

/**
 * Class UserModel
 * Handles user-related data operations.
 */
class UserModel extends MainModel
{
    /**
     * Get user data by ID.
     * * If the database is connected, it attempts to fetch real data.
     * Otherwise, it returns mock data for development.
     */
    public function getUser(int $id): array
    {
        // 1. Check if the database connection is available
        if ($this->db !== null) {
            try {
                $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
                $stmt->execute(['id' => $id]);
                $user = $stmt->fetch();

                if ($user) {
                    return $user;
                }
            } catch (\PDOException $e) {
                // Log error if needed, but fallback to mock data
                error_log("Database query error in UserModel: " . $e->getMessage());
            }
        }

        // 2. Mock data for demonstration/fallback
        return [
            'id' => $id,
            'name' => 'Bruno M. Dourado',
            'role' => 'Principal Architect',
            'framework' => 'BFrame Modern',
            'linkedin' => 'https://linkedin.com/in/bruno-dourado',
            'github' => 'https://github.com/bframe-project'
        ];
    }
}
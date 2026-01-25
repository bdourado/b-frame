<?php
/**
 * Class UserModel
 * Example model representing a user
 */
class UserModel extends MainModel
{
    /**
     * Get mock data for a user
     * In a real scenario, you would use $this->db->select(...)
     * @param int $id
     * @return array
     */
    public function getUser($id)
    {
        // Example of using the database layer (if table exists)
        // return Database::select('users', ['id' => $id]);

        // Mock data for demonstration
        return [
            'id' => $id,
            'name' => 'Bruno M. Dourado',
            'role' => 'Developer',
            'framework' => 'BFrame'
        ];
    }
}

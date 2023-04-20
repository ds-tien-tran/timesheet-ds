<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface 
{
    /**
     * Get user by id
     */
    public function getUserById($userId) 
    {
        return User::findOrFail($userId);
    }
}
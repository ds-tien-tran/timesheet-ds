<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Config;

class UserRepository implements UserRepositoryInterface 
{
    public function __construct(protected User $user)
    {
    }
    /**
     * Get user by id
     */
    public function getUserById($userId) 
    {
        return $this->user->findOrFail($userId);
    }

    /**
     * Get list user
     */
    public function getList()
    {
        return $this->user->paginate(config('default.paginate'));
    }

    /**
     * Delete a user
     */
    public function destroy($user)
    {
        return $user->delete();
    }
}
<?php

namespace App\Repositories;

use App\Models\RoleUser;
use App\Repositories\Interfaces\RoleUserRepositoryInterface;

class RoleUserRepository implements RoleUserRepositoryInterface 
{
    public function __construct(protected RoleUser $roleUser)
    {
    }

    /**
     * Get role by user
     */
    public function getRoleById($user)
    {
        return $this->roleUser->where('user_id', $user->id)->first();
    }
}
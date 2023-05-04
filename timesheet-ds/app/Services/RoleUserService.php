<?php

namespace App\Services;

use App\Services\Interfaces\RoleUserServiceInterface;

class RoleUserService implements RoleUserServiceInterface
{
    public function __construct(protected RoleUserServiceInterface $roleUserRepository)
    {
    }

    
}

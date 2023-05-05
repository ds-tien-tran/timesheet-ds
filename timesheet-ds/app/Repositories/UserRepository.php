<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Config;

class UserRepository implements UserRepositoryInterface 
{
    public function __construct(protected User $user,protected RoleUser $roleUser)
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

    /**
     * Get list user by manager
     */
    public function getListByManager($id)
    {
        return $this->user->whereHas('roleUser', function ($query) use ($id) {
            $query->where('manager_id', $id);
        })->with('roleUser')->paginate(config('default.paginate'));
    }

    /**
     * Get list manager
     */
    public function listManager()
    {
        return $this->user->whereHas('roles', function ($query) {
            $query->where('role_id', Role::ROLE_MANAGER);
        })->paginate(config('default.paginate'));
    }

        
    /**
     * Get list user by manager
     *
     * @param  mixed $userId
     * @return void
     */
    public function listManagerUser($userId)
    {
        return $this->user->whereHas('roleUser', function ($query) use ($userId) {
            $query->where('manager_id', $userId);
        })->paginate(config('default.paginate'));
    }
    
    /**
     * list user no manager
     *
     * @return void
     */
    public function listUserNoManager()
    {
        return $this->user->whereHas('roleUser', function ($query) {
            $query->where('role_id', Role::ROLE_USER)
                ->whereNull('manager_id');
        })->paginate(config('default.paginate'));
    }

    /**
     * search user no manager
     */
    public function searchUserNoManager($request)
    {
        return $this->user->whereHas('roleUser', function ($query) {
            $query->where('role_id', Role::ROLE_USER)
                ->whereNull('manager_id');
        })->paginate(config('default.paginate'));
    }
}
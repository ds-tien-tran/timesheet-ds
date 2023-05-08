<?php

namespace App\Repositories;

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
        // TODO:: check in table role-user
        // dd($this->user->load('roleManager')->get());
        // dd($this->roleUser->whereHas('users')->with('users','user')->where('manager_id', $id)->get()); dang dung ma hoi loang ngoang
        // dd($this->user->with(['roleUser'  => function ($query) use($id) {
        //     $query->where('manager_id', $id);
        // }])->get());
        // dd($this->user->whereHas('roleUser', function ($query) use ($id) {
        //     $query->where('manager_id', $id);
        // })->with('roleUser')->get());
        // return $this->user::with('roles')->toSql();
        //  => function ($query) use($id) {
        //     $query->where('manager_id', $id);
        // }])->toSql();
        // ->paginate(config('default.paginate'));
        return $this->user->whereHas('roleUser', function ($query) use ($id) {
            $query->where('manager_id', $id);
        })->with('roleUser')->paginate(config('default.paginate'));
    }
}
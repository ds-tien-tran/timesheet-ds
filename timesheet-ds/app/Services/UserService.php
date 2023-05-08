<?php

namespace App\Services;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Interfaces\RoleUserRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\Interfaces\UserServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository, 
        protected RoleUserRepositoryInterface $roleUserRepository
        )
    {
    }

    /**
     * View show edit
     */
    public function show($id)
    {
        $user = $this->userRepository->getUserById($id);
        
        return $user;
    }

    /**
     * Update info user
     */
    public function update($id, $request)
    {
        $user = $this->userRepository->getUserById($id);
        
        if( !$user) {
            throw new Exception('Can not edit user!');
        }
       
        $user->name = $request->input('name') ?? '';
        $user->email = $request->input('email') ?? '';
        $user->description = $request->input('description') ?? '';
        
        // Add img new remove img old
        if($request->hasFile('avatar'))
        {
            $pathDefault = 'images/user/';
            File::delete($pathDefault.$user->avatar);
            $filename = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move($pathDefault, $filename);
            $user->avatar = $filename;
        }

        $user->save();

        return $user;
    }

    /**
     * Get list user
     */
    public function getList()
    {
        return $this->userRepository->getList();
    } 

    /**
     * Delete a user
     */
    public function destroy($user)
    {
        if (Auth::check() && Auth::user()->id == $user->id)
        {
            throw new Exception('You can not delete user login');
        }
        return $this->userRepository->destroy($user);
    }

    /**
     * Change role user
     */
    public function changeRole($user, $request)
    {
        //xử lí change role
        $user = $this->roleUserRepository->getRoleById($user);
        if (!$user)
        {
            throw new Exception('User have not role!');
        }
        //update role_id
        $user->role_id = $request['role'];
        $user->save();

        return $user;
    }

    /**
     * Get list user
     */
    public function getListByManager($id)
    {
        // dd($this->userRepository->getListByManager($id));
        return $this->userRepository->getListByManager($id);
    } 
}

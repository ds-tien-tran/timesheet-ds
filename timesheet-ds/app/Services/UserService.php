<?php

namespace App\Services;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\Interfaces\UserServiceInterface;
use Exception;
use Illuminate\Support\Facades\File;

class UserService implements UserServiceInterface
{
    public function __construct(protected UserRepositoryInterface $userRepository)
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
}

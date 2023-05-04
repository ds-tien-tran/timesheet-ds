<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {

    }

    /**
     * Get view edit
     */
    public function show($id)
    {
        $user = $this->userService->show($id);
        
        return view('user.edit', compact('user'));
    }
    

    /**
     * Update user
     */
    public function update($id, UpdateUserRequest $request)
    {
        try {
            $this->userService->update($id, $request);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Edit user fail!');
        }

        return redirect()->back()->with('success', 'Edit user success');
    }

    /**
     * Show list user
     */
    public function list()
    {
        $users = $this->userService->getList();
        
        return view('user.list', compact('users'));
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        try {
            $user = $this->userService->destroy($user);
            if ($user) {
                return redirect()->back()->with('success', 'Delete user success');
            }
        } catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Take info user
     */
    public function infoUser($id)
    {
        $user = $this->userService->show($id);

        return view('user.info_user', compact('user'));
    }

    /**
     * Change role user
     */
    public function changeRole(User $user, Request $request)
    {
        try {
            $this->userService->changeRole($user, $request->all());
            
            return redirect()->back()->with('success', 'Update role success');
        } catch (Exception $e)
        {
            return redirect()->back()->with('error', 'Update role error');
        }
    }
}

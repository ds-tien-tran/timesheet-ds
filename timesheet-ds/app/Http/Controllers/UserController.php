<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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

            // return response()->json([
            //     'status' => 'error',
            //     'message' => $e->getMessage()
            // ]);
        }

        return redirect()->back()->with('success', 'Edit user success');

        // return response()->json([
        //     'status' => 'success',
        //     'users' => $user
        // ]);
       
    }
}

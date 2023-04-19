<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Get view form login
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Post form login
     */
    public function postLogin(LoginRequest $request)
    {
        $credentials = 
        [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            return view('dashboard');
        }

        return redirect()->back()->withErrors('Password or email not correct !')->withInput();
    }

    /**
     * Get view form register
     */
    public function register()
    {
        return view('register');
    }


    /**
     * Post form registe
     */
    public function postRegister(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $userCreate = 
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'description' => $request->input('description'),
            ];

            if($request->hasFile('avatar'))
            {
                $filename = $request->file('avatar')->getClientOriginalName().'_'.time();
                $request->file('avatar')->move('images/user/', $filename);
                $userCreate['avatar'] = $filename;
            }
            // Create user and set role = user
            $user = User::create($userCreate);
            
            $roleUserCreate = [
                'user_id' => $user->id,
                'role_id' => Role::ROLE_USER,
                'manager_id' => null
            ];
            RoleUser::create($roleUserCreate);
            DB::commit();
            if ($user) {
                return back()->with('success', 'Register user success');
            }

            return back()->with('error', 'Register fail !');
        } catch (Exception $ex) {
            DB::rollBack();

            return back()->withError($ex->getMessage())->withInput();
        }
    }
}

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth
Route::get('/login', [AuthController::class, 'login'])->name('login.view');
Route::post('/post-login', [AuthController::class, 'postLogin'])->name('login');

Route::get('/register', [AuthController::class, 'register'])->name('login.register');
Route::post('/post-register', [AuthController::class, 'postRegister'])->name('register');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['checkLogin'])->group(function () {
    //Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //User
    Route::get('/user/edit/{id}', [UserController::class, 'show'])->name('user.edit');
    Route::patch('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
});
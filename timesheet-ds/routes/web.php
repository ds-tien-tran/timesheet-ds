<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TimesheetController;
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
    Route::name('user.')->prefix('user')->group(function() {
        Route::get('edit/{id}', [UserController::class, 'show'])->name('edit');
        Route::patch('update/{id}', [UserController::class, 'update'])->name('update');
    });

    //Timesheet
    Route::name('timesheet.')->prefix('timesheet')->group(function() {
        Route::get('create', [TimesheetController::class, 'create'])->name('create');
        Route::post('store', [TimesheetController::class, 'store'])->name('store');
        Route::get('list', [TimesheetController::class, 'list'])->name('list');
        Route::get('get-all-data/{id}', [TimesheetController::class, 'getAllByUser'])->name('getAll');
        Route::get('show/{id}', [TimesheetController::class, 'show'])->name('show');
        Route::patch('update/{id}', [TimesheetController::class, 'update'])->name('update');
    });

    //Admin
    Route::middleware(['checkAdmin'])->group(function () {
        Route::name('user.')->prefix('user')->group(function() {
            Route::get('list', [UserController::class, 'list'])->name('list');
            Route::delete('destroy/{user}', [UserController::class, 'destroy'])->name('destroy');
            Route::get('info-user/{user}', [UserController::class, 'infoUser'])->name('infoUser');
            Route::patch('change-role/{user}', [UserController::class, 'changeRole'])->name('changeRole');
        });

        Route::name('timesheet.')->prefix('timesheet')->group(function() {
            Route::get('list-timesheet/{userId}', [TimesheetController::class, 'listTimesheet'])->name('listTimesheet');
            Route::get('show-detail/{timesheet}', [TimesheetController::class, 'showDetail'])->name('showDetail');
            Route::patch('change-status/{timesheet}', [TimesheetController::class, 'changeStatus'])->name('changeStatus');
        });
    });
});
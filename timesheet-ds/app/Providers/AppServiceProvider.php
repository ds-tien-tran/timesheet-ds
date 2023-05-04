<?php

namespace App\Providers;

use App\Models\Timesheet;
use App\Repositories\Interfaces\RoleUserRepositoryInterface;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\TimesheetRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\TaskServiceInterface;
use App\Services\Interfaces\TimesheetServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\TaskService;
use App\Services\TimesheetService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class
        , function($app) {
            return new UserService(
                $app->make(UserRepositoryInterface::class),
                $app->make(RoleUserRepositoryInterface::class)
            );
        });

        $this->app->bind(TimesheetServiceInterface::class, TimesheetService::class
        , function($app) {
            return new TimesheetService(
                $app->make(TimesheetRepositoryInterface::class), 
                $app->make(TaskRepositoryInterface::class),
                $app->make(TaskServiceInterface::class)
            );
        });

        $this->app->bind(TaskServiceInterface::class, TaskService::class
        , function($app) {
            return new TaskService( 
                $app->make(TaskRepositoryInterface::class)
            );
        });
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

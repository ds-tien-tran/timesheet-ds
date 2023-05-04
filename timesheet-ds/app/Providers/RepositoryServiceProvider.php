<?php

namespace App\Providers;

use App\Repositories\Interfaces\RoleUserRepositoryInterface;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\TimesheetRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\RoleUserRepository;
use App\Repositories\TaskRepository;
use App\Repositories\TimesheetRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TimesheetRepositoryInterface::class, TimesheetRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(RoleUserRepositoryInterface::class, RoleUserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

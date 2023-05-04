<?php

namespace App\Providers;

use App\Models\Timesheet;
use App\Models\User;
use App\Policies\TimesheetPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Timesheet::class => TimesheetPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('seen', function(User $user) {
            foreach ($user->roles as $role) {
                if ($role->name == 'admin')
                {
                    return true;
                }
            }
        
            return false;
        });

        //
    }
}

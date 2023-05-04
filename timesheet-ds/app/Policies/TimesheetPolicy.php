<?php

namespace App\Policies;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TimesheetPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given post can be updated by the user.
     */
    public function show(User $user, Timesheet $timesheet)
    {
        foreach ($user->roles as $role) {
           if ($role->name == 'admin')
           {
            return true;
           }
        }
        return $user->id === $timesheet->user_id;
    }

    /**
     * Determine if the given post can be updated by the user.
     */
    public function update(User $user, Timesheet $timesheet)
    {
        /**
         * Admin approve timesheet
         */
        foreach ($user->roles as $role) {
            if ($role->name == 'admin')
            {
             return true;
            }
        }

        return $user->id === $timesheet->user_id;
    }

    /**
     * Show route if admin
     */
    public function seen(User $user)
    {
        foreach ($user->roles as $role) {
           if ($role->name == 'admin')
           {
            return true;
           }
        }

        return false;
    }
}

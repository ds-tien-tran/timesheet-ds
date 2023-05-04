<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Timesheet extends Model
{
    use HasFactory, AuthorizesRequests;

    protected $table = 'timesheets';

    CONST DAYOFF = 1; 
    CONST WORK = 0; 


    CONST STATUS_OPEN = 1;
    CONST STATUS_APPROVE = 2;
    CONST STATUS_REJECT = 3;  

    protected $fillable = ['user_id', 'day_selected', 'plan', 'note', 'status', 'dayoff'];

    /**
     * Get task for timesheet
     */
    public function tasks()
    {
       return $this->hasMany(Task::class, 'timesheet_id', 'id');
    }

    /**
     * Get user that owns timesheet
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

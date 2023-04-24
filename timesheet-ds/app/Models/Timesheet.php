<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $table = 'timesheets';

    CONST DAYOFF = 1; 
    CONST WORK = 0; 


    CONST STATUS_OPEN = 1;
    CONST STATUS_APPROVE = 2;
    CONST STATUS_REJECT = 3;  

    protected $fillable = ['user_id', 'day_selected', 'plan', 'note', 'status', 'dayoff'];
}

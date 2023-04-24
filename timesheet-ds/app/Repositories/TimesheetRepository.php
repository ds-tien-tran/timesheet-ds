<?php

namespace App\Repositories;

use App\Models\Timesheet;
use App\Repositories\Interfaces\TimesheetRepositoryInterface;

class TimesheetRepository implements TimesheetRepositoryInterface 
{
    private Timesheet $timesheet;
    public function __construct(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
    }

    public function create(array $attibutes = [])
    {
       return $this->timesheet->create($attibutes);
    }
}
<?php

namespace App\Repositories;

use App\Models\Timesheet;
use App\Repositories\Interfaces\TimesheetRepositoryInterface;

class TimesheetRepository implements TimesheetRepositoryInterface 
{
    public function __construct(protected Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
    }

    /**
     * Create a timesheet
     */
    public function create(array $attibutes = [])
    {
       return $this->timesheet->create($attibutes);
    }

    /**
     * Get all data timesheet
     */
    public function getAll()
    {
        return $this->timesheet->all();
    }

    /**
     * Get a timesheet by id
     */
    public function getById($id)
    {
        return $this->timesheet->with('tasks')->findorFail($id);
    }

    /**
     * Update timesheet
     */
    public function update($id, $request)
    {
        $result = $this->timesheet->findorFail($id);
        if (!$result) {
            return false;
        }
        
        return $result->update($request);
    }
}
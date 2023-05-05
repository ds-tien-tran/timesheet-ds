<?php

namespace App\Repositories;

use App\Models\Timesheet;
use App\Repositories\Interfaces\TimesheetRepositoryInterface;
use Carbon\Carbon;

class TimesheetRepository implements TimesheetRepositoryInterface 
{
    public function __construct(protected Timesheet $timesheet)
    {
        // $this->timesheet = $timesheet;
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
    public function getAllByUser($id)
    {
        return  $sql = $this->timesheet->where('user_id', $id)->get();     
    }

    /**
     * Get all data timesheet role admin
     */
    public function getAllByUserRoleAdmin($id, $request)
    {
        $sql = $this->timesheet->where('user_id', $id);
        $firstDate = Carbon::now()->format('Y-m-01 00:00:00');
        $endDate = Carbon::now()->format('Y-m-d 23:59:59');

        if ($request->has('month_select'))
        {
            $monthSelect = $request->input('month_select');
            $firstDate = date($monthSelect.'-01 00:00:00');
            $endDate = date($monthSelect.'-t 23:59:59');
        }

        return $sql->where('day_selected', '>=', $firstDate)
            ->where('day_selected', '<=', $endDate)
            ->get();
    }

    /**
     * Get all data timesheet 
     */
    public function getAllByUserTimeNow($userId)
    {
        $sql = $this->timesheet->where('user_id', $userId);
        $firstDate = Carbon::now()->format('Y-m-01 00:00:00)');
        $endDate = Carbon::now()->format('Y-m-d 23:59:59)');

        return $sql->where('day_selected', '>=', $firstDate)
            ->where('day_selected', '<=', $endDate)
            ->get()->count();
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
<?php

namespace App\Services;

use App\Models\Timesheet;
use App\Repositories\TaskRepository;
use App\Repositories\TimesheetRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimesheetService
{
    private TimesheetRepository $timeSheetRepository;
    private TaskRepository $taskRepository;

    public function __construct(TimesheetRepository $timeSheetRepository, TaskRepository $taskRepository)
    {
        $this->timeSheetRepository = $timeSheetRepository;
        $this->taskRepository = $taskRepository;
    }

    /**
     * create timesheet
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {
            //Create timesheet
            $dataCreateTimesheet = [
                'user_id' => Auth::user()->id,
                'day_selected' => $request->input('day_selected') ?? '',
                'plan' => $request->input('plan') ?? '',
                'note' => $request->input('note') ?? '',
                'status' => Timesheet::STATUS_OPEN, 
                'dayoff' => Timesheet::WORK,
            ];

            $timesheet = $this->timeSheetRepository->create($dataCreateTimesheet);
            // dd($timesheet);
            //Create task
            foreach($request['tasks'] as $task)
            {
                $dataCreateTask['timesheet_id'] = $timesheet->id;
                $dataCreateTask['task_id'] = $task['task_id'];
                $dataCreateTask['content'] = $task['content'];
                $dataCreateTask['time_use'] = $task['time_use'];
                $dataCreateTask['status'] = $task['status'];
                $this->taskRepository->create($dataCreateTask);
            }
            DB::commit();

            return $timesheet;
            
        } catch (Exception $ex) {
            DB::rollBack();
        }
       
    }
}

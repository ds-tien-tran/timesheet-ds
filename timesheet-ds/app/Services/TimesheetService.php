<?php

namespace App\Services;

use App\Models\Timesheet;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\TimesheetRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Services\Interfaces\TaskServiceInterface;
use App\Services\Interfaces\TimesheetServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimesheetService implements TimesheetServiceInterface
{

    public function __construct(
        protected TimesheetRepositoryInterface $timesheetRepository,
        protected TaskRepositoryInterface $taskRepository,
        protected TaskServiceInterface $taskServiceInterface
    )
    {
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

            $timesheet = $this->timesheetRepository->create($dataCreateTimesheet);
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

    /**
     * Get All data timesheet
     */
    public function getAll()
    {
       return $this->timesheetRepository->getAll();
    }

    /**
     * Get one timesheet by id
     */
    public function getById($id)
    {
        return $this->timesheetRepository->getById($id);
    }

    /**
     * Update a timesheet
     */
    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $tasks = $request->only('tasks');
            $timesheet = $this->getById($id);
            // Update timesheet
            $this->timesheetRepository->update($id, $request->except('tasks'));
            // Delete list task old
            $taskIdOlds = $this->taskRepository->getAllTaskIdBySheetId($timesheet->id);
            $this->taskRepository->deleteAllBySheetId($taskIdOlds);
            // Update task
            foreach($tasks['tasks'] as $task)
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

<?php

namespace App\Services;

use App\Models\Timesheet;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\TimesheetRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Services\Interfaces\TaskServiceInterface;
use App\Services\Interfaces\TimesheetServiceInterface;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimesheetService implements TimesheetServiceInterface
{
    use AuthorizesRequests;

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
    public function getAllByUser($id, $request)
    {
        
       return $this->timesheetRepository->getAllByUser($id, $request);
    }

    /**
     * Get one timesheet by id
     */
    public function getById($user, $id)
    {
        $timesheet = $this->timesheetRepository->getById($id);
        if (!$this->authorize('show', $timesheet))
        {
            throw new AuthorizationException("You don't have role");
        }
        
        return $timesheet;
    }

    /**
     * Update a timesheet
     */
    public function update($user, $id, $request)
    {
        $timesheet = $this->getById($user, $id);
        if (!$this->authorize('update', $timesheet))
        {
            throw new AuthorizationException('You can not edit timesheet');
        }

        DB::beginTransaction();
        try {
            $tasks = $request->only('tasks');
            
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

    /**
     * Update status timesheet
     */
    public function changeStatus($user, $timesheetId, $request)
    {
        $timesheet = $this->getById($user, $timesheetId);

        if (!$this->authorize('update', $timesheet))
        {
            throw new AuthorizationException('You can not edit timesheet');
        }

        return $this->timesheetRepository->update($timesheetId, $request);
    }
}

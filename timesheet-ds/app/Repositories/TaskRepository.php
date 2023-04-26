<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface 
{
    public function __construct(protected Task $task)
    {
        $this->task = $task;
    }

    /**
     * Create a task
     */
    public function create(array $attibutes = [])
    {
       return $this->task->create($attibutes);
    }

    /**
     * Delete a task
     */
    public function destroy($id)
    {
        return $this->task->destroy($id);
    }

    /**
     * Get all Taskid by timesheet_id
     */
    public function getAllTaskIdBySheetId($sheetId)
    {
        return $this->task->where('timesheet_id', '=', $sheetId)->pluck('id')->toArray();
    }

    public function deleteAllBySheetId($ids)
    {
        return $this->task->whereIn('id',$ids)->delete();
    }
}
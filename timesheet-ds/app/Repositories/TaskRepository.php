<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface 
{
    private Task $task;
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function create(array $attibutes = [])
    {
       return $this->task->create($attibutes);
    }
}
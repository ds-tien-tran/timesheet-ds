<?php

namespace App\Services;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\Interfaces\TaskServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Exception;
use Illuminate\Support\Facades\File;

class TaskService  implements TaskServiceInterface
{
    public function __construct(protected TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * Delete a task
     */
    public function destroy($id)
    {
        return $this->taskRepository->destroy($id);
    }
}

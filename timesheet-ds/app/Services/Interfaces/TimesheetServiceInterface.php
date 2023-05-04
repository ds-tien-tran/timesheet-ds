<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface TimesheetServiceInterface
{
   public function store($request);
   public function getAllByUser($id, $request);
   public function getById(User $user, $id);
   public function update(User $user, $id, $request);
   public function changeStatus(User $user, $timesheetId, $request);
}

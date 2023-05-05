<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface TimesheetServiceInterface
{
   public function store($request);
   public function getAllByUser($id);
   public function getById(User $user, $id);
   public function update($timesheet, $id, $request);
   public function changeStatus(User $user, $timesheetId, $request);
   public function getAllByUserRoleAdmin($userId, $request);
   public function getTimesheetRegister($userId);
}

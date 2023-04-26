<?php

namespace App\Services\Interfaces;

interface TimesheetServiceInterface
{
   public function store($request);
   public function getAll();
   public function getById($id);
   public function update($id, $request);
}

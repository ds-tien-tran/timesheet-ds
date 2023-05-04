<?php

namespace App\Repositories\Interfaces;

interface TimesheetRepositoryInterface 
{
    public function create(array $attibutes = []);
    public function getAllByUser($id, $request);
    public function getById($id);
    public function update($id, $request);
}
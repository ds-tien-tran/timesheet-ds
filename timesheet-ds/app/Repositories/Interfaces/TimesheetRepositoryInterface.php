<?php

namespace App\Repositories\Interfaces;

interface TimesheetRepositoryInterface 
{
    public function create(array $attibutes = []);
    public function getAllByUser($id);
    public function getById($id);
    public function update($id, $request);
    public function getAllByUserRoleAdmin($id, $request);
}
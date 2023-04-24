<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface TimesheetRepositoryInterface 
{
    public function create(array $attibutes = []);
}
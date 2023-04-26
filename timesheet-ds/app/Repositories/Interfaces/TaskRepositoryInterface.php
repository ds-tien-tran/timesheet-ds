<?php

namespace App\Repositories\Interfaces;

interface TaskRepositoryInterface 
{
    public function create(array $attibutes = []);
    public function destroy($id);
    public function getAllTaskIdBySheetId($sheetId);
    public function deleteAllBySheetId($Ids);
}
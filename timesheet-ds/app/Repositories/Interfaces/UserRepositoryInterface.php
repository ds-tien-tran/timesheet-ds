<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface 
{
    public function getUserById($userId);
    public function getList();
    public function destroy($user);
    public function getListByManager($id);
}
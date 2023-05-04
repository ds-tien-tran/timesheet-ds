<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{
    public function show($id);
    public function update($id, $request);
    public function getList();
    public function destroy($user);
    public function changeRole($user, $request);
}

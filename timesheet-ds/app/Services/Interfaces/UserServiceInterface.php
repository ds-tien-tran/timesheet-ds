<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{
    public function show($id);
    public function update($id, $request);
}

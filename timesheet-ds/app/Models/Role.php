<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = ['name'];

    const  ROLE_USER = 1;
    const  ROLE_MANAGER = 2;
    const  ROLE_ADMIN = 3;
}

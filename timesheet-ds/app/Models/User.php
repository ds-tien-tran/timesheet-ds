<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'password',
        'description'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * The roles that belong to the user.
     */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role-user', 'user_id', 'role_id');
    }

    /**
     * Check user has role admin
     */
    public function isAdmin()
    {
        foreach ($this->roles as $role) {
            if ($role->name == 'admin')
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Check user has role admin
     */
    public function isManager()
    {
        foreach ($this->roles as $role) {
            if ($role->name == 'manager')
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Check user has role admin
     */
    public function isUser()
    {
        foreach ($this->roles as $role) {
            if ($role->name == 'user')
            {
                return true;
            }
        }

        return false;
    }
}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'company', 'username', 'level', 'telegram_user_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_by');
    }

    function myTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
}

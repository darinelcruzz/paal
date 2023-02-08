<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token'
    ];

    function company()
    {
        return $this->belongsTo(Company::class);
    }

    function store()
    {
        return $this->belongsTo(Store::class);
    }

    function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_by');
    }

    function myTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
}

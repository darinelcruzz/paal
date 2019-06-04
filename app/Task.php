<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    function tasker()
    {
    	return $this->belongsTo(User::class, 'assigned_by');
    }

    function user()
    {
    	return $this->belongsTo(User::class, 'assigned_to');
    }
}

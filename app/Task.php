<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Task extends Model
{
    use Notifiable;

    protected $guarded = [];

    function tasker()
    {
    	return $this->belongsTo(User::class, 'assigned_by');
    }

    function user()
    {
    	return $this->belongsTo(User::class, 'assigned_to');
    }

    function getOnTimeAttribute()
    {
    	return $this->assigned_at >= $this->completed_at;
    }

    function getStatusColorAttribute()
    {
        $colors = ['aceptada' => 'success', 'pendiente' => 'warning', 'terminada' => 'primary'];
        
        return $colors[$this->status];
    }
}

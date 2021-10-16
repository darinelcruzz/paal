<?php

namespace App;

use DateTimeInterface;
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
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    function getOnTimeAttribute()
    {
    	return $this->assigned_at >= $this->completed_at;
    }

    function getStatusColorAttribute()
    {
        $colors = ['aceptada' => 'success', 'no aceptada' => 'danger', 'pendiente' => 'warning', 'terminada' => 'primary', 'vencida' => 'danger'];
        
        return $colors[$this->status];
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = [];

    function provider()
    {
    	return $this->belongsTo(Provider::class);
    }

    function movements()
    {
        return $this->morphMany(Movement::class, 'movable');
    }

    function getColorAttribute()
    {
    	$colors = ['pagada' => 'success', 'cancelada' => 'danger', 'pendiente' => 'warning'];

    	return in_array($this->status, $colors) ? $colors[$this->status]: 'default';
    }
}

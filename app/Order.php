<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $guarded = [];
	
    function user()
    {
    	return $this->belongsTo(User::class);
    }
    
    function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    function purchases()
    {
        return $this->hasMany(Purchase::class);
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

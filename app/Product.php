<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
	use Notifiable;
	
    protected $guarded = [];

    function serial_numbers()
    {
    	return $this->hasMany(SerialNumber::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'address', 'postcode', 'city', 'state', 'rfc', 'credit', 'company'];

    function getCompleteAddressAttribute()
    {
    	$address = $this->address ? "$this->address, " : '';

    	return $address . "$this->city, $this->state";
    }
}

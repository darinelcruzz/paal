<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    function ingresses()
    {
        return $this->hasMany(Ingress::class);
    }

    function addresses()
    {
    	return $this->hasMany(Address::class);
    }

    function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    function getCompleteAddressAttribute()
    {
    	$address = $this->address ? "$this->address, " : '';

    	return $address . "$this->city, $this->state";
    }
}

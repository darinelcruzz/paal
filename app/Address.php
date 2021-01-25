<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
    	'business_name', 'contact', 'phone', 'street', 'street_number', 'street_number2',
     	'district', 'city', 'state', 'postcode', 'reference', 'client_id', 'status'
     ];

    function client()
    {
    	return $this->belongsTo(Client::class);
    }

    function getFullAddressAttribute()
    {
    	return "$this->street #$this->street_number, $this->district, $this->city";
    }
}

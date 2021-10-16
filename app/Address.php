<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [];

    function client()
    {
    	return $this->belongsTo(Client::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    function getFullAddressAttribute()
    {
    	return "$this->street #$this->street_number, $this->district, $this->city";
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SerialNumber extends Model
{
    protected $guarded = [];

    function product()
    {
    	return $this->belongsTo(Product::class);
    }

    function ingress()
    {
    	return $this->belongsTo(Ingress::class);
    }

    function purchase()
    {
    	return $this->belongsTo(Purchase::class);
    }

    function company()
    {
        return $this->belongsTo(Company::class);
    }

    function store()
    {
        return $this->belongsTo(Store::class);
    }
}

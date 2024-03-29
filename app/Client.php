<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    function tax_regime()
    {
        return $this->belongsTo(Variable::class, 'tax_regime_id');
    }

    function ingresses()
    {
        return $this->hasMany(Ingress::class);
    }

    function latest_ingresses()
    {
        return $this->hasMany(Ingress::class)->whereMonth('bought_at', (request('date') ? substr(request('date'), 5, 2): date('m')));
    }

    function addresses()
    {
    	return $this->hasMany(Address::class);
    }

    function shipping_address()
    {
        return $this->hasOne(Address::class)->where('type', 'envío');
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

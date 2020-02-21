<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = ['ingress_id', 'guide_number', 'company', 'status', 'delivered_at', 'shipped_at', 'address_id', 'observations'];

    function ingress()
    {
    	return $this->belongsTo(Ingress::class);
    }

    function address()
    {
        return $this->belongsTo(Address::class);
    }

    function getColorAttribute()
    {
    	$colors = ['pendiente' => 'default', 'en tránsito' => 'warning', 'entregado' => 'success', 'cancelado' => 'danger'];

    	return $colors[$this->status];
    }

    function scopeMonthly($query, $date, $company = 'coffee')
    {
        return $query->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->whereHas('ingress', function ($query) use ($company) {
                $query->where('company', $company);
            });
    }

}

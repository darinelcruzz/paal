<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = ['ingress_id', 'guide_number', 'company', 'status'];

    function ingress()
    {
    	return $this->belongsTo(Ingress::class);
    }

    function getColorAttribute()
    {
    	$colors = ['pendiente' => 'default', 'en tránsito' => 'warning', 'entregado' => 'success', 'error' => 'danger'];

    	return $colors[$this->status];
    }
}

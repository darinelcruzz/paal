<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['ingress_id', 'cash', 'transfer', 'check', 'debit_card', 'credit_card', 'type', 'reference'];

    function ingress()
    {
    	return $this->belongsTo(Ingress::class);
    }
}

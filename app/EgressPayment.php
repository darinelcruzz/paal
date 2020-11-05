<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EgressPayment extends Model
{
    protected $guarded = [];

    function egress()
    {
    	return $this->belongsTo(Egress::class);
    }
}

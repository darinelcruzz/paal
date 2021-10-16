<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class EgressPayment extends Model
{
    protected $guarded = [];

    function egress()
    {
    	return $this->belongsTo(Egress::class);
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

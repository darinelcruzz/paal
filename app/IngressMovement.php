<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngressMovement extends Model
{
    protected $guarded = [];

    function product()
    {
    	return $this->belongsTo(Product::class);
    }
}

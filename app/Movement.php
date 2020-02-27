<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = [
    	'product_id', 'movable_type', 'movable_id',
    	'price', 'quantity', 'discount', 'total', 'price'
    ];

    function movable()
    {
    	return $this->morphTo();
    }

    function product()
    {
        return $this->belongsTo(Product::class);
    }
}

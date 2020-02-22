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

    function scopeMonthly($query, $date, $company, $family)
    {
        return $query->whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->whereHas('product', function($query) use ($company, $family) {
                $query->where('company', $company)
                	->where('family', $family);
            });
    }
}

<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $guarded = [];

    function movable()
    {
    	return $this->morphTo();
    }

    function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    function getRealAmountAttribute()
    {
        return $this->total * (1 + $this->product->iva * 0.16);
    }

    function scopeMonthly($query, $date, $company, $family)
    {
        return $query->whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->where('movable_type', 'App\Ingress')
            ->whereHas('product', function($query) use ($company, $family) {
                $query->where('company', $company)
                    ->where('family', $family);
            });
    }
}

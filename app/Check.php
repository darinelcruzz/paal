<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    protected $guarded = [];

    function egresses()
    {
    	return $this->hasMany(Egress::class);
    }

    function getTotalAttribute()
    {
    	return $this->egresses->sum('amount');
    }

    function getIvaAttribute()
    {
        return $this->egresses->sum('iva');
    }

    function scopeFrom($query, $date, $field, $company = 'coffee')
    {
        return $query->where('company', $company)
        	->where('status', '!=', 'cancelado')
            ->whereYear($field, substr($date, 0, 4))
            ->whereMonth($field, substr($date, 5, 7));
    }
}

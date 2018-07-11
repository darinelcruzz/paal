<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = ['social', 'name', 'rfc', 'address', 'phone', 'email',
    	'contact', 'type', 'city', 'postcode', 'company', 'amount', 'bills', 'status'];


    function egresses()
    {
    	return $this->hasMany(Egress::class);
    }

    function getMonthlySumAttribute()
    {
        $date = date('Y-m');
    	return $this->egresses
                    ->where('emission', '>=', "$date-01")
                    ->where('emission', '<=', "$date-31")
                    ->sum('amount');
    }

    function getRemainingAttribute()
    {
        return $this->amount - $this->monthly_sum;
    }

    function getIsValidAttribute()
    {
        return $this->remaining > 0;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = ['social', 'name', 'rfc', 'address', 'phone', 'email',
    	'contact', 'type', 'city', 'postcode', 'company', 'amount', 'bills', 'status', 'xml_required'];


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

    function getCreatedBillsAttribute()
    {
        $date = date('Y-m');
        return $this->egresses
        ->where('emission', '>=', "$date-01")
        ->where('emission', '<=', "$date-31")
        ->count();
    }

    function scopeGeneral($query, $company = 'mbe')
    {
        return $query->where('company', '!=', $company)
            ->where('type', '!=', 'gr')
            ->where('type', '!=', 'cc')
            ->selectRaw('id, CONCAT(name, IF(xml_required = 1, "", "*")) as provider');
    }
}

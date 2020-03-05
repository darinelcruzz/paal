<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egress extends Model
{
    protected $fillable = [
    	'provider_id', 'buying_date', 'pdf_bill', 'pdf_payment',
    	'xml', 'emission', 'expiration', 'folio', 'observations', 'user',
    	'iva', 'amount', 'payment_date', 'status', 'company', 'pdf_complement',
    	'complement_date', 'complement_amount', 'mfolio', 'nfolio', 'second_method', 'method', 'second_payment_date',
        'check_id', 'provider_name', 'returned_to', 'type'
    ];

    function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    function check()
    {
        return $this->belongsTo(Check::class);
    }

    function receiver()
    {
        return $this->belongsTo(User::class, 'returned_to');
    }

    function getStatusLabelAttribute()
    {
        $colors = ['pendiente' => 'warning', 'pagado' => 'success', 'vencido' => 'danger'];

        if (date('Y-m-d') >= $this->expiration && !$this->payment_date) {
            $this->update(['status' => 'vencido']);
        }

        return "<span class=\"label label-{$colors[$this->status]}\">" . ucfirst($this->status) . "</span>";
    }

    function getReturnNameAttribute()
    {
        $names = ['EXTRA', 'TRASPASO', 'HÉCTOR'];

        return $names[$this->returned_to];
    }

    function scopeCompany($query, $company = 'coffee')
    {
        return $query->where('company', $company);
    }

    function scopeFrom($query, $date, $field, $company = 'coffee')
    {
        return $query->where('company', $company)
            ->whereYear($field, substr($date, 0, 4))
            ->whereMonth($field, substr($date, 5, 7));
    }

    function checkExpiration()
    {
        if (date('Y-m-d') >= $this->expiration && !$this->payment_date) {
            $this->update(['status' => 'vencido']);
        }
    }
}

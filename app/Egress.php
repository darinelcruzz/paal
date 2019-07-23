<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egress extends Model
{
    protected $fillable = [
    	'provider_id', 'buying_date', 'pdf_bill', 'pdf_payment',
    	'xml', 'emission', 'expiration', 'folio', 'observations', 'user',
    	'iva', 'amount', 'payment_date', 'status', 'company', 'pdf_complement',
    	'complement_date', 'complement_amount', 'mfolio', 'nfolio', 'second_method', 'method', 'second_payment_date'
    ];

    function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    function getStatusLabelAttribute()
    {
        $colors = ['pendiente' => 'warning', 'pagado' => 'success', 'vencido' => 'danger'];

        if (date('Y-m-d') >= $this->expiration && !$this->payment_date) {
            $this->update(['status' => 'vencido']);
        }

        return "<span class=\"label label-{$colors[$this->status]}\">" . ucfirst($this->status) . "</span>";
    }

    function scopeFrom($query, $date, $field)
    {
        return $query->where('company', 'coffee')
            ->whereYear($field, substr($date, 0, 4))
            ->whereMonth($field, substr($date, 5, 7));
    }
}

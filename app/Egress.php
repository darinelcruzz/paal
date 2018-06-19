<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egress extends Model
{
    protected $fillable = [
    	'provider_id', 'buying_date', 'pdf_bill', 'pdf_payment',
    	'xml', 'emission', 'expiration', 'folio', 'observations', 'user',
    	'iva', 'amount', 'payment_date', 'status', 'company', 'pdf_complement',
    	'complement_date', 'complement_amount'
    ];

    function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    function getStatusLabelAttribute()
    {
        $color = "warning";

        if ($this->payment_date) {
            $color = 'success';
            $this->update(['status' => 'pagado']);
        }

        if (date('Y-m-d') >= $this->expiration && !$this->payment_date) {
            $color = 'danger';
            $this->update(['status' => 'vencido']);
        }

        return "<span class=\"label label-$color\">" . ucfirst($this->status) . "</span>";
    }
}

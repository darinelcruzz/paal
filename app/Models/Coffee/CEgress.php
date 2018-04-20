<?php

namespace App\Models\Coffee;

use Illuminate\Database\Eloquent\Model;

class CEgress extends Model
{
    protected $fillable = [
    	'provider', 'buying_date', 'pdf_bill', 'pdf_payment',
    	'xml', 'emission', 'expiration', 'folio',
    	'iva', 'amount', 'payment_date', 'status'
    ];
}

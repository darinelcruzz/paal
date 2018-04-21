<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egress extends Model
{
    protected $fillable = [
    	'provider', 'buying_date', 'pdf_bill', 'pdf_payment',
    	'xml', 'emission', 'expiration', 'folio', 'observations', 'user',
    	'iva', 'amount', 'payment_date', 'status', 'company'
    ];
}

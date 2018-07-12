<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingress extends Model
{
    protected $fillable = [
    	'client_id', 'bought_at', 'products', 'company', 'amount',
    	'status', 'iva', 'paid_at', 'method', 'operation_number'
    ];

    function client()
    {
    	return $this->belongsTo(Client::class);
    }
    function getPayFormAttribute()
    {
        $methods = ['Efectivo', 'Transferencia', 'Cheque',
                    'Tarjeta de débito', 'Tarjeta de crédito'];
        return $methods[$this->method - 1];
    }
}

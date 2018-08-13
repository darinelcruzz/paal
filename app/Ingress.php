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

    function storeProducts($request)
    {
        $products = [];
        for ($i = 0; $i < count($request->products); $i++) {
            $product = [];
            $product['i'] =  $request->products[$i];
            $product['p'] =  $request->prices[$i];
            $product['q'] =  $request->quantities[$i];
            $product['t'] =  $request->subtotals[$i];
            array_push($products, $product);
        }

        $this->update([
            'products' => serialize($products),
            'bought_at' => date('Y-m-d'),
            'status' => 'pendiente',
        ]);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingress extends Model
{
    protected $fillable = [
    	'client_id', 'bought_at', 'products', 'company', 'amount', 'retained_at', 'retainer',
    	'status', 'iva', 'paid_at', 'method', 'reference', 'methodA', 'referenceA'
    ];

    function client()
    {
    	return $this->belongsTo(Client::class);
    }

    function getRetainerMethodAttribute()
    {
        $methods = ['Efectivo', 'T. Débito', 'T. Crédito', 'Cheque', 'Transferencia', 'Crédito'];
                    
        return $methods[$this->methodA];
    }

    function getPayFormAttribute()
    {
        $methods = ['Efectivo', 'T. Débito', 'T. Crédito', 'Cheque', 'Transferencia', 'Crédito'];
                    
        return $methods[$this->method];
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

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingress extends Model
{
    protected $fillable = [
    	'client_id', 'bought_at', 'products', 'company', 'amount', 'retained_at', 'retainer',
    	'status', 'iva', 'paid_at'
    ];

    function client()
    {
    	return $this->belongsTo(Client::class);
    }

    function payments()
    {
        return $this->hasMany(Payment::class);
    }

    function getDebtAttribute()
    {
        $payments_total = 0;

        foreach ($this->payments as $payment) {
            $payments_total += $payment->cash + $payment->transfer + $payment->check + $payment->debit_card + $payment->credit_card;
        }

        return $this->amount - $payments_total;
    }

    function getStatusColorAttribute()
    {
        $classes = ['pendiente' => 'warning', 'vencido' => 'danger', 'crédito' => 'default', 'pagado' => 'success'];

        return $classes[$this->status];
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

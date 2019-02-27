<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingress extends Model
{
    protected $fillable = [
    	'client_id', 'bought_at', 'products', 'company', 'amount', 'retained_at', 'retainer',
    	'status', 'iva', 'paid_at', 'user_id', 'invoice', 'invoice_id', 'folio', 'special_products', 'canceled_for', 'quotation_id'
    ];

    function client()
    {
        return $this->belongsTo(Client::class);
    }

    function quotation()
    {
    	return $this->belongsTo(Quotation::class);
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
        $classes = ['pendiente' => 'warning', 'vencido' => 'danger', 'crédito' => 'default', 'pagado' => 'success', 'cancelado' => 'danger'];

        return $classes[$this->status];
    }

    function getCfdiAttribute()
    {
        $descriptions = ['G01' => 'G01 Adquisición de mercancías', 'G03' => 'G03 Gastos en general', 'P01' => 'P01 Por definir'];

        return $descriptions[$this->invoice];
    }

    function getMethodAttribute()
    {
        $payment = array_slice($this->payments
                    // ->where('type', 'contado')
                    // ->orWhere('type', 'liquidación')
                    ->first()
                    ->toArray(), 3, 5);

        return array_search(max($payment), $payment);
    }

    function getMethodNameAttribute()
    {
        $methods = ['cash' => 'Efectivo', 'transfer' => 'Transferencia', 'check' => 'Cheque', 'debit_card' => 'T. Débito', 'credit_card' => 'T. Crédito'];

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

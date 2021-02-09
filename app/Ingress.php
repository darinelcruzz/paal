<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ingress extends Model
{
    protected $guarded = [];

    function client()
    {
        return $this->belongsTo(Client::class);
    }

    function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    function quotation()
    {
    	return $this->belongsTo(Quotation::class);
    }

    function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    function movements()
    {
        return $this->morphMany(Movement::class, 'movable');
    }

    function serial_numbers()
    {
        return $this->hasMany(SerialNumber::class);
    }

    function getIsShiftedAttribute()
    {
        return $this->created_at->format('Y-m-d') > $this->bought_at;
    }

    function getDebtAttribute()
    {
        $payments_total = 0;

        foreach ($this->payments as $payment) {
            $payments_total += $payment->cash + $payment->transfer + $payment->check + $payment->debit_card + $payment->credit_card;
        }

        return $this->amount - $payments_total;
    }

    function getDepositsSumAttribute()
    {
        $payments_total = 0;

        foreach ($this->payments as $payment) {
            if ($payment->type == 'abono') {
                $payments_total += $payment->cash + $payment->transfer + $payment->check + $payment->debit_card + $payment->credit_card;
            }
        }

        return $payments_total;
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

    function getInferredMethodAttribute()
    {
        if ($this->payments->first()) {

            if ($this->client_id == 55 && $this->payments->first()->debit_card > 0) {
                return 'debit_card';
            }

            if ($this->client_id == 55 && $this->payments->first()->credit_card > 0) {
                return 'credit_card';
            }

            $payment = array_slice($this->payments->first()->toArray(), 3, 5);

            return array_search(max($payment), $payment);
        }

        return 'undefined';
    }

    function getReferenceAttribute()
    {
        if ($this->payments->first()) {

            return $this->payments->first()->reference;
        }

        return 'undefined';
    }

    function getCashReferenceAttribute()
    {
        if ($this->payments->count() > 0) {

            return $this->payments->first()->cash_reference;
        }

        return 'undefined';
    }

    function getCashAttribute()
    {
        if ($this->payments->first()) {

            return $this->payments->first()->cash;
        }

        return 0;
    }

    function getMethodNameAttribute()
    {
        $methods = ['undefined' => '?', 'cash' => 'Efectivo', 'transfer' => 'Transferencia', 'check' => 'Cheque', 'debit_card' => 'T. Débito', 'credit_card' => 'T. Crédito'];

        return $methods[$this->inferred_method];
    }

    function getXmlAttribute()
    {
        if (Storage::exists("public/$this->company/invoices/$this->invoice_id.xml")) {
            return Storage::url("public/$this->company/invoices/$this->invoice_id.xml");
        }
        
        return false;
    }

    function getXmlComplementAttribute()
    {
        if (Storage::exists("public/$this->company/complements/$this->invoice_id.xml")) {
            return Storage::url("public/$this->company/complements/$this->invoice_id.xml");
        }
        
        return false;
    }

    function getRouteMethodAttribute()
    {
        if ($this->method == 'tarjeta crédito' || $this->method == 'tarjeta débito') {
            return 'tarjeta';
        } else if ($this->method == 'cheque' || $this->invoice != 'no') {
            return 'factura';
        } else {
            return $this->method;
        }
    }

    function getTypeLabelAttribute()
    {
        return ['insumos' => 'danger', 'equipo' => 'warning', 'proyecto' => 'primary'][$this->type];
    }

    function getAreSerialNumbersMissingAttribute()
    {
        if ($this->serial_numbers->count() > 0) {
            return false;
        }
        return $this->movements()->whereHas('product', function ($query) {$query->where('is_seriable', 1);})->count() > 0;
    }

    function scopeFrom($query, $date)
    {
        return $query->whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->where('retainer', 0);
    }

    function scopeMonthly($query, $date, $company = 'coffee')
    {
        return $query->where('company', $company)
            ->where('status', '!=', 'cancelado')
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->orderByDesc('id');
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

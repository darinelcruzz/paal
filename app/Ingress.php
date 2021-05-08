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
        return $this->hasMany(Payment::class);
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
        $debt = 0;

        foreach ($this->retainers as $retainer) {
            if ($this->id == $retainer->id) {
                break;
            }
            $debt += $retainer->amount;
        }
        return $this->quotation->amount - $debt;
    }

    function getRetainersAttribute()
    {
        return Ingress::where('type', 'anticipo')->where('quotation_id', $this->quotation_id)->get();
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
        $descriptions = ['G01' => 'G01 Adquisición de mercancías', 'G02' => 'G02 Devoluciones, descuentos o bonificaciones', 'G03' => 'G03 Gastos en general', 'P01' => 'P01 Por definir'];

        return $descriptions[$this->invoice];
    }

    function getPayMethodAttribute()
    {
        $methods = ['efectivo' => 0, 'cheque' => 0, 'transferencia' => 0, 'tarjeta débito' => 0, 'tarjeta crédito' => 0];

        foreach ($this->payments as $payment) {
            $methods['efectivo'] += $payment->cash;
            $methods['cheque'] += $payment->check;
            $methods['transferencia'] += $payment->transfer;
            $methods['tarjeta débito'] += $payment->debit_card;
            $methods['tarjeta crédito'] += $payment->credit_card;
        }

        return array_search(max($methods), $methods);
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

    function getPiXmlAttribute()
    {
        if (Storage::exists("public/$this->company/invoices/pi$this->pinvoice_id.xml")) {
            return Storage::url("public/$this->company/invoices/pi$this->pinvoice_id.xml");
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
        return ['insumos' => 'danger', 'equipo' => 'warning', 'proyecto' => 'primary', 'anticipo' => 'default', 'nota de crédito' => 'info'][$this->type];
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

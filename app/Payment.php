<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['ingress_id', 'cash', 'transfer', 'check', 'debit_card', 'credit_card', 'type', 'reference'];

    function ingress()
    {
    	return $this->belongsTo(Ingress::class);
    }

    function getMethodsAttribute()
    {
        return ($this->cash > 0 ? '$ ' . number_format($this->cash, 2) . ' (Efectivo) <br>': '') .
            ($this->transfer > 0 ? '$ ' . number_format($this->transfer, 2) . '(Transferencia)<br>': '') .
            ($this->check > 0 ? '$ ' . number_format($this->check, 2) . '(Cheque)<br>': '') .
            ($this->debit_card > 0 ? '$ ' . number_format($this->debit_card, 2) . '(T. Débito)<br>': '') .
            ($this->credit_card > 0 ? '$ ' . number_format($this->credit_card, 2) . '(T. Crédito)<br>': '');
    }

    function getTotalAttribute()
    {
    	return $this->cash + $this->transfer + $this->check + $this->debit_card + $this->credit_card;
    }
}

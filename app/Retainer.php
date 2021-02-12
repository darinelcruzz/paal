<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retainer extends Model
{
    protected $guarded = [];

    function client()
    {
        return $this->belongsTo(Client::class);
    }

    function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    function getMethodAttribute()
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
}

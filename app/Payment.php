<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    function ingress()
    {
        return $this->belongsTo(Payment::class);
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
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

    function getMethodAttribute()
    {
        $methods = array_slice($this->toArray(), 3, 5);

        return array_search(max($methods), $methods);
    }

    function scopeFrom($query, $date, $company = 'coffee')
    {
        return $query->whereDate('created_at', $date)
            ->whereHas('ingress', function($query) use ($company) {
                $query->where('status', '!=', 'cancelado')
                    ->where('company', $company);
            });
    }

    function scopeMonthly($query, $date, $company = 'coffee')
    {
        return $query->whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5));
            // ->whereHas('ingress', function($query) use ($company) {
            //     $query->where('status', '!=', 'cancelado')
            //         ->where('status', '!=', 'crédito')
            //         ->where('company', $company);
            // });
    }
}

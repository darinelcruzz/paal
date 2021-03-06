<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egress extends Model
{
    protected $guarded = [];

    function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    function check()
    {
        return $this->belongsTo(Check::class);
    }

    function receiver()
    {
        return $this->belongsTo(User::class, 'returned_to');
    }

    function payments()
    {
        return $this->hasMany(EgressPayment::class);
    }

    function getDebtAttribute()
    {
        return $this->amount - $this->payments->sum('amount');
    }

    function getStatusLabelAttribute()
    {
        $colors = ['pendiente' => 'warning', 'pagado' => 'success', 'vencido' => 'danger'];

        if (date('Y-m-d') >= $this->expiration && !$this->payment_date) {
            $this->update(['status' => 'vencido']);
        }

        return "<span class=\"label label-{$colors[$this->status]}\">" . ucfirst($this->status) . "</span>";
    }

    function getReturnNameAttribute()
    {
        $names = ['EXTRA', 'TRASPASO', 'HÉCTOR'];

        return $names[$this->returned_to];
    }

    function scopeCompany($query, $company = 'coffee')
    {
        return $query->where('company', $company);
    }

    function scopeFrom($query, $date, $field, $company = 'coffee')
    {
        return $query->where('company', $company)
            ->whereYear($field, substr($date, 0, 4))
            ->whereMonth($field, substr($date, 5, 7));
    }

    function checkExpiration()
    {
        if (date('Y-m-d') >= $this->expiration && !$this->payment_date) {
            $this->update(['status' => 'vencido']);
        }
    }
}

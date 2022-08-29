<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Egress extends Model
{
    protected $guarded = [];

    function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    function category()
    {
        return $this->belongsTo(Category::class);
    }

    function group()
    {
        return $this->belongsTo(Category::class, 'group_id');
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

    function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
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

    function getCategoryColorAttribute()
    {
        $colors = ['G. GENERALES' => 'success', 'REPOSICIONES' => 'warning', 'GASTOS EXTRA' => 'primary', 'CAJA CHICA' => 'danger'];

        return $colors[$this->category->name ?? 'default'] ?? 'NOHAY';
    }

    function getGroupColorAttribute()
    {
        $colors = [
            'IEPS' => 'default', 'ISH' => 'default', 'COSTO VENTA' => 'success', 'GASTOS FIJOS' => 'warning', 'GASTOS VARIABLES' => 'primary', 
            'GASTOS INTERNACIONALES' => 'danger', 'CRÉDITO' => 'info'
        ];

        return $colors[$this->group->name ?? 'defaultt'] ?? 'NOHAY';
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

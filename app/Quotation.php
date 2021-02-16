<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Quotation extends Model
{
    protected $guarded = [];

    function client()
    {
    	return $this->belongsTo(Client::class);
    }

    function user()
    {
    	return $this->belongsTo(User::class);
    }

    function sale()
    {
        return $this->hasOne(Ingress::class, 'quotation_id')->where('type', '!=', 'anticipo');
    }

    function retainers()
    {
        return $this->hasMany(Ingress::class, 'quotation_id')->where('type', 'anticipo');
    }

    function movements()
    {
        return $this->morphMany(Movement::class, 'movable');
    }

    function getDebtAttribute()
    {
        return $this->amount - $this->retainers->sum('amount');
    }

    function getProductsListAttribute()
    {
    	$products = [];

    	if ($this->products) {
            foreach (unserialize($this->products) as $product) {
                $pmodel = Product::find($product['i'])->toArray();
                $pmodel += ['amount' => $product['q'], 'discount' => $product['d'], 'price' => $product['p']];
                array_push($products, $pmodel);
            }
        }

        if ($this->products) {
            foreach (unserialize($this->special_products) as $product) {
        		$pmodel = Product::find($product['id'])->toArray();
        		$pmodel += ['amount' => $product['q'], 'discount' => $product['d'],
                    'special_description' => $product['i'], 'special_price' => $product['p']];
        		array_push($products, $pmodel);
        	}            
        }

        foreach ($this->movements as $movement) {
            $pmodel = $movement->product->toArray();
            $pmodel += ['amount' => $movement->quantity, 'discount' => $movement->discount, 'price' => $movement->price];
            array_push($products, $pmodel);
        }

    	return collect($products)->toJson();
    }

    function getIsCanceledAttribute()
    {
        $limit = 30 + 30 * $this->client->credit;

        $created_at = strtotime(Date::parse($this->created_at));
        $elapsed_time = round((time() - $created_at) / (60 * 60 * 24));

        return $elapsed_time > $limit;
    }

    function getTypeLabelAttribute()
    {
        return ['insumos' => 'danger', 'equipo' => 'warning', 'proyecto' => 'primary'][$this->type];
    }

    function getInternetTypeAttribute()
    {
        return [658 => 'formulario', 659 => 'campaña'][$this->client_id] ?? '';
    }

    function scopeMonthly($query, $company, $date, $type)
    {
        return $query->where('company', $company)
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->when($type, function ($query, $type) {
                return $query->where('client_id', $type == 'formularios' ? 658: 659);
            }, function ($query) {
                return $query->whereNull('client_name');
            })
            ->with('client', 'movements.product');
    }
}

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

    function sales()
    {
        return $this->hasMany(Ingress::class, 'quotation_id');
    }

    function movements()
    {
        return $this->morphMany(Movement::class, 'movable');
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

    function getIndexPageAttribute()
    {
        return route($this->company . '.quotation.' . ($this->client_name ? 'internet': 'index'));
    }

    function getTypeLabelAttribute()
    {
        return ['insumos' => 'danger', 'equipo' => 'warning', 'proyecto' => 'primary'][$this->type];
    }

    function scopeNormal($query, $company, $date)
    {
        return $query->where('company', $company)
            ->whereNull('client_name')
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->with('client');
    }

    function scopeInternet($query, $company, $date)
    {
        return $query->where('company', $company)
            ->whereNotNull('client_name')
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->with('client');
    }
}

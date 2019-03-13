<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = ['client_id', 'user_id', 'products', 'amount', 'company', 'iva', 'special_products', 'editions_count'];

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

    function getProductsListAttribute()
    {
    	$products = [];

    	foreach (unserialize($this->products) as $product) {
            $pmodel = Product::find($product['i'])->toArray();
            $pmodel += ['quantity' => $product['q'], 'discount' => $product['d']];
            array_push($products, $pmodel);
        }

        foreach (unserialize($this->special_products) as $product) {
    		$pmodel = Product::find($product['id'])->toArray();
    		$pmodel += ['quantity' => $product['q'], 'discount' => $product['d'],
                'special_description' => $product['i'], 'special_price' => $product['p']];
    		array_push($products, $pmodel);
    	}

    	return collect($products)->toJson();
    }
}

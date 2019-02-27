<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = ['client_id', 'user_id', 'products', 'amount', 'company', 'iva', 'special_products'];

    function client()
    {
    	return $this->belongsTo(Client::class);
    }

    function user()
    {
    	return $this->belongsTo(User::class);
    }

    function getProductsListAttribute()
    {
    	$products = [];

    	foreach (unserialize($this->products) as $product) {
    		array_push($products, Product::find($product['i']));
    	}

    	return collect($products)->toJson();
    }
}

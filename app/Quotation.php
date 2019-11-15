<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Quotation extends Model
{
    protected $fillable = [
        'client_id', 'user_id', 'products', 'amount', 'company',
        'iva', 'special_products', 'editions_count', 'type',
        'client_name', 'email'
    ];

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
            $pmodel += ['quantity' => $product['q'], 'discount' => $product['d'], 'price' => $product['p']];
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

    function getProductsListTypeAttribute()
    {
        foreach (unserialize($this->products) as $product) {
            $model = Product::find($product['i']);
            break;
        }

        return strtolower($model->category == 'EQUIPO' ? 'equipo': 'insumos');
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
        return route('coffee.quotation.' . ($this->client_name ? 'internet': 'index'));
    }
}

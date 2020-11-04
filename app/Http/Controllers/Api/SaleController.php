<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Ingress, Product};
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    function show(Ingress $ingress)
    {
    	if ($ingress->products) {
	        return [collect(unserialize($ingress->products))->map(function ($product) {
	        	$product['i'] = Product::find($product['i'])->description;
	        	return $product;
	        }), unserialize($ingress->special_products)];
    	}

    	return $ingress->movements;
    }
}
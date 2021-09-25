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

    function amount($date, $category)
    {
        if ($category != 'TOTAL') {
            $movements = Movement::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->whereHas('product', function ($query) use ($category) {
                return $query->where('category', $category);
            })
            ->get();
        } else {
            $movements = Movement::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->whereHas('product', function ($query) use ($category) {
                return $query->whereIn('category', ['INSUMOS', 'ACCESORIOS', 'VASOS', 'EQUIPO', 'REFACCIONES', 'BARRAS', 'CURSOS', 'OTROS']);
            })
            ->get();
        }

        return ['quantity' => $movements->sum('quantity'), 'amount' => number_format($movements->sum('total'), 2)];
    }
}
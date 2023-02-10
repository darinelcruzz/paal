<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Product, Movement, Ingress};
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    function coffee($keyword = '')
    {
        return Product::whereIn('company', ['COFFEE', 'SANSON'])
            ->where(function ($query) use ($keyword) {
                $query->where("description", "LIKE","%$keyword%")
                    ->orWhere("code", "LIKE", "%$keyword%")
                    ->orWhere("barcode", "LIKE", "%$keyword%")
                    ->orWhere("family", "LIKE", "%$keyword%");
            })
            ->where('status', 'activo')
            // ->orWhere('family', 'ENVÍOS')
            ->with('serial_numbers')
            ->paginate(5);
    }

    function sanson($keyword = '')
    {
        return Product::where('company', 'SANSON')
            ->where(function ($query) use ($keyword) {
                $query->where("description", "LIKE","%$keyword%")
                    ->orWhere("code", "LIKE", "%$keyword%")
                    ->orWhere("barcode", "LIKE", "%$keyword%")
                    ->orWhere("family", "LIKE", "%$keyword%");
            })
            ->where('status', 'activo')
            // ->orWhere('family', 'ENVÍOS')
            ->with('serial_numbers')
            ->paginate(5);
    }

    function mbe($keyword = '')
    {
        return Product::whereCompany('MBE')
            ->where(function ($query) use ($keyword) {
                $query->where("description", "LIKE","%$keyword%")
                    ->orWhere("code", "LIKE", "%$keyword%")
                    ->orWhere("barcode", "LIKE", "%$keyword%")
                    ->orWhere("family", "LIKE", "%$keyword%");
            })->paginate(5);
    }

    function seriable($company, $keyword = '')
    {
        return Product::where('company', '!=', 'mbe')
            ->where(function ($query) use ($keyword) {
                $query->where("description", "LIKE","%$keyword%")
                    ->orWhere("code", "LIKE", "%$keyword%")
                    ->orWhere("barcode", "LIKE", "%$keyword%")
                    ->orWhere("family", "LIKE", "%$keyword%");
            })
            ->where('is_seriable', 1)
            ->paginate(5);
    }

    function show(Product $product)
    {
        return $product;
    }

    function amount($date, $category)
    {
        $user = auth()->user();
        $movements = Movement::query()
            ->select('quantity', 'total', 'product_id')
            ->whereHasMorph('movable', Ingress::class, function ($query) use ($date, $user) {
                $query->whereYear('bought_at', substr($date, 0, 4))
                    ->whereMonth('bought_at', substr($date, 5, 2))
                    ->where('store_id', $user->store_id)
                    ->where('status', '!=', 'cancelado');
            })
            ->whereHas('product', function ($query) use ($category) {
                return $query->when($category != 'TOTAL', function ($query) use ($category) {
                        $query->where('category', $category);
                    });
            })
            ->with('product:id,category,family,description,iva')
            ->get();

        return ['quantity' => $movements->sum('quantity'), 'amount' => number_format($movements->sum(function ($i)
        {
            return $i->total * (1 + $i->product->iva * 0.16);
        }), 2)];
    }
}

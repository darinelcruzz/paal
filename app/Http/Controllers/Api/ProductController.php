<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Product, Movement, Ingress};
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    function coffee($keyword = '')
    {
        return Product::where('company', 'COFFEE')
            ->where(function ($query) use ($keyword) {
                $query->where("description", "LIKE","%$keyword%")
                    ->orWhere("code", "LIKE", "%$keyword%")
                    ->orWhere("barcode", "LIKE", "%$keyword%")
                    ->orWhere("family", "LIKE", "%$keyword%");
            })
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
        return Product::whereCompany(strtoupper($company))
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
        if ($category != 'TOTAL') {
            $movements = Movement::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->whereHasMorph('movable', Ingress::class, function ($query) {
                $query->where('company', 'coffee')
                    ->where('status', '!=', 'cancelado');
            })
            ->whereHas('product', function ($query) use ($category) {
                return $query->where('category', $category)
                    ->where('company', 'coffee');
            })
            ->get();
        } else {
            $movements = Movement::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->whereHasMorph('movable', Ingress::class, function ($query) {
                $query->where('company', 'coffee')
                    ->where('status', '!=', 'cancelado');
            })
            ->whereHas('product', function ($query) use ($category) {
                return $query->whereIn('category', ['INSUMOS', 'ACCESORIOS', 'VASOS', 'EQUIPO', 'REFACCIONES', 'BARRAS', 'CURSOS', 'OTROS']);
            })
            ->get();
        }

        return ['quantity' => $movements->sum('quantity'), 'amount' => number_format($movements->sum('total'), 2)];
    }
}

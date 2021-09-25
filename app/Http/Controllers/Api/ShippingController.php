<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Ingress, Product};
use App\Http\Controllers\Controller;

class ShippingController extends Controller
{
    function amount($date, $company)
    {
        if ($category != 'TOTAL') {
            $movements = Ingress::whereYear('created_at', substr($date, 0, 4))
                ->whereMonth('created_at', substr($date, 5, 2))
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
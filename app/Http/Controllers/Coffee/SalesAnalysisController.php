<?php

namespace App\Http\Controllers\Coffee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Ingress, Movement};

class SalesAnalysisController extends Controller
{
    function index(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $ingresses = Ingress::whereYear('bought_at', substr($date, 0, 4))
            ->whereMonth('bought_at', substr($date, 5, 2))
            ->where('company', '!=', 'mbe')
            ->where('status', '!=', 'cancelado')
            ->get();

        $ingresses2 = Ingress::whereYear('bought_at', substr($date, 0, 4))
            ->whereMonth('bought_at', substr($date, 5, 2) - 1)
            ->where('company', '!=', 'mbe')
            ->where('status', '!=', 'cancelado')
            ->get();

        $ingresses3 = Ingress::whereYear('bought_at', substr($date, 0, 4))
            ->whereMonth('bought_at', '!=', substr($date, 5, 2))
            ->where('company', '!=', 'mbe')
            ->where('status', '!=', 'cancelado')
            ->get();

        $topProducts = Movement::where('movable_type', 'App\Ingress')
            ->whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->with('product')
            ->whereHasMorph('movable', Ingress::class, function ($query) {
                $query->where('company', '!=', 'mbe');
            })
            ->get()
            ->groupBy('product.description')
            ->sortByDesc(function ($product, $key) {
                return $product->sum('quantity');
            })
            ->transform(function ($item, $key) {
                return ['quantity' => $item->sum('quantity'), 'amount' => $item->sum('total')];
            })
            ->take(5);

        $topSales = $ingresses->sortByDesc('amount')->take(5);

        return view('coffee.analyses.index', compact('ingresses3', 'ingresses2', 'ingresses', 'topProducts', 'topSales', 'date'));
    }

    function create()
    {
        //
    }

    function store(Request $request)
    {
        //
    }

    function show($date)
    {
        $ingresses = Ingress::whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->whereCompany('coffee')
            ->where('invoice', 'no')
            ->where('method', 'efectivo')
            ->pluck('id');

        $movements = Movement::whereIn('movable_id', $ingresses)
            ->where('movable_type', 'App\Ingress')
            ->with('product')
            ->get()
            ->groupBy(['product.description', function ($item, $key) {
                return (string) $item['price'];
            }], $preserveKeys = true);

        return view('coffee.analyses.show', compact('movements'));
    }

    function edit($id)
    {
        //
    }

    function update(Request $request, $id)
    {
        //
    }

    function destroy($id)
    {
        //
    }
}

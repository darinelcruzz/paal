<?php

namespace App\Http\Controllers\Coffee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Ingress, Movement};

class SalesAnalysisController extends Controller
{
    function index()
    {
        $ingresses = Ingress::whereYear('bought_at', date('Y'))
            ->whereMonth('bought_at', date('m'))
            ->where('company', '!=', 'mbe')
            ->where('status', '!=', 'cancelado')
            ->get();

        $ingresses2 = Ingress::whereYear('bought_at', date('Y'))
            ->whereMonth('bought_at', date('m') - 1)
            ->where('company', '!=', 'mbe')
            ->where('status', '!=', 'cancelado')
            ->get();

        $ingresses3 = Ingress::whereYear('bought_at', date('Y'))
            ->whereMonth('bought_at', '!=', date('m'))
            ->where('company', '!=', 'mbe')
            ->where('status', '!=', 'cancelado')
            ->get();

        $topProducts = Movement::where('movable_type', 'App\Ingress')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
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

        return view('coffee.analyses.index', compact('ingresses3', 'ingresses2', 'ingresses', 'topProducts', 'topSales'));
    }

    function create()
    {
        //
    }

    function store(Request $request)
    {
        //
    }

    function show($id)
    {
        //
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

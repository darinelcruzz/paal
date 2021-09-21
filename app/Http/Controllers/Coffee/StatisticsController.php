<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Client, Ingress, Quotation, Movement};

class StatisticsController extends Controller
{
    function sales(Request $request, $category = 'total')
    {
        $date = $request->date ?? date('Y-m');
        $category = strtoupper($category);

        $groups = Movement::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->whereHas('product', function ($query) use ($category) {
                return $query->when($category == 'TOTAL', function ($query) {
                    $query->whereIn('category', ['INSUMOS', 'ACCESORIOS', 'VASOS', 'EQUIPO', 'REFACCIONES', 'BARRAS', 'CURSOS', 'OTROS']);
                }, function ($query) use ($category) {
                    $query->where('category', $category);
                });
            })
            ->with('product')
            ->get()
            ->groupBy($category == 'TOTAL' ? 'product.category': 'product.family')
            ->transform(function ($item, $key) {
                return ['quantity' => $item->sum('quantity'), 'amount' => $item->sum('total')];
            })
            ->sortByDesc('quantity');

        $topProducts = Movement::where('movable_type', 'App\Ingress')
            ->whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->with('product')
            ->get()
            ->groupBy('product.description')
            ->sortByDesc(function ($product, $key) {
                return $product->sum('quantity');
            })
            ->transform(function ($item, $key) {
                return ['quantity' => $item->sum('quantity'), 'amount' => $item->sum('total')];
            })
            ->take(5);

        // dd($groups);
        return view('coffee.statistics.sales', compact('date', 'category', 'groups', 'topProducts'));
    }

    function index(Request $request)
    {
        $date = $request->date ?? date('Y-m');

        $clientsTotal = Client::where('company', 'coffee')->count();

        $clientsOfThisMonth = Client::where('company', 'coffee')->whereHas('ingresses', function ($query) use ($date) {
            $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', substr($date, 5, 2));
        })->count();

        $clientsOfLastTwoMonths = Client::where('company', 'coffee')->whereHas('ingresses', function ($query) use ($date) {
            $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', substr($date, 5, 2));
        })->whereHas('ingresses', function ($query) use ($date) {
            $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', substr($date, 5, 2) - 1);
        })->count();

        $newClients = Client::whereCompany('coffee')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->whereHas('ingresses', function ($query) use ($date) {
                $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', substr($date, 5, 2));
            })->count();

        $topClients = Client::where('company', 'coffee')
            ->where('name', '!=', 'VENTA MOSTRADOR')
            ->where('name', '!=', 'MOSTRADOR  (DEPOSITO)')
            ->with('ingresses')
            ->get()
            ->sortByDesc(function ($client, $key) use ($date) {
                return $client->ingresses()->whereYear('bought_at', substr($date, 0, 4))
                    ->whereMonth('bought_at', '>=', substr($date, 5, 2) - 1)
                    ->sum('amount');
            })
            ->transform(function ($client, $key) use ($date) {
                return [
                    'id' => $client->id, 
                    'name' => $client->name, 
                    'amount' => $client->ingresses()
                        ->whereYear('bought_at', substr($date, 0, 4))
                        ->whereMonth('bought_at', '>=', substr($date, 5, 2) - 1)
                        ->sum('amount'), 
                    'quantity' => $client->ingresses->count()];
            })
            ->take(5);

        $quotations = Quotation::whereCompany('coffee')
            ->whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->get();

        $quotationsTotal = $quotations->count();
        $equipmentQuotations = $quotations->where('type', 'equipo')->count();
        $campaigns = $quotations->where('client_id', 659)->count();
        $salesFromQuotations = Quotation::whereCompany('coffee')
            ->whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->whereHas('sale')
            ->count();

        $topProducts = Movement::where('movable_type', 'App\Ingress')
            ->whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->with('product')
            ->get()
            ->groupBy('product.description')
            ->sortByDesc(function ($product, $key) {
                return $product->sum('quantity');
            })
            ->transform(function ($item, $key) {
                return ['quantity' => $item->sum('quantity'), 'amount' => $item->sum('total')];
            })
            ->take(5);

        // dd($topProducts);
        
        return view('coffee.statistics.index', compact('clientsTotal', 'clientsOfThisMonth', 'clientsOfLastTwoMonths', 'newClients', 'topClients', 'quotationsTotal', 'equipmentQuotations', 'campaigns', 'salesFromQuotations', 'topProducts'));
    }
}

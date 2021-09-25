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
            ->whereHas('product', function ($query) use ($category) {
                return $query->when($category == 'TOTAL', function ($query) {
                    $query->whereIn('category', ['INSUMOS', 'ACCESORIOS', 'VASOS', 'EQUIPO', 'REFACCIONES', 'BARRAS', 'CURSOS', 'OTROS']);
                }, function ($query) use ($category) {
                    $query->where('category', $category);
                });
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

        // dd($groups);
        return view('coffee.statistics.sales', compact('date', 'category', 'groups', 'topProducts'));
    }

    function clients(Request $request)
    {
        $date = $request->date ?? date('Y-m');

        $usualClients = Client::where('company', 'coffee')->whereHas('ingresses', function ($query) use ($date) {
            $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', '>=', substr($date, 5, 2) - 2);
        })->get();

        $unusualClients = Client::where('company', 'coffee')->whereDoesntHave('ingresses', function ($query) use ($date) {
            $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', '>=', substr($date, 5, 2) - 2);
        })->get();

        $clientsComingBack = Client::where('company', 'coffee')
            ->whereYear('created_at', '!=', date('Y'))
            ->whereMonth('created_at', '!=', date('m'))
            ->whereHas('ingresses', function ($query) use ($date) {
                $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', substr($date, 5, 2));
            })->whereHas('ingresses', function ($query) use ($date) {
                $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', '!=', substr($date, 5, 2) - 1);
            })->whereHas('ingresses', function ($query) use ($date) {
                $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', '!=', substr($date, 5, 2) - 2);
            })
            ->get()
            ->transform(function ($client, $key) {
                $ingresses = $client->ingresses->where('bought_at', '>=', date('Y-m') . '-01');
                return ['id' => $client->id, 'name' => $client->name, 'quantity' => $ingresses->count(), 'amount' => $ingresses->sum('amount')];
            })
            ->sortByDesc('amount');

        // dd($clientsComingBack);

        $newClients = Client::whereCompany('coffee')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->with('ingresses')
            ->whereHas('ingresses', function ($query) use ($date) {
                $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', substr($date, 5, 2));
            })
            ->get()
            ->transform(function ($client, $key) {
                return ['id' => $client->id, 'name' => $client->name, 'quantity' => $client->ingresses->count(), 'amount' => $client->ingresses->sum('amount')];
            })
            ->sortByDesc('amount');;

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
        
        return view('coffee.statistics.clients', compact('usualClients', 'unusualClients', 'clientsComingBack', 'newClients', 'topClients'));
    }

    function shippings(Request $request)
    {
        return "ENVÍOS";
    }
}

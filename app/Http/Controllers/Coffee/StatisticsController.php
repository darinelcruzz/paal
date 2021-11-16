<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Client, Ingress, Quotation, Movement, Shipping};

class StatisticsController extends Controller
{
    function sales(Request $request, $category = 'total', $date = null)
    {
        $date = $date ?? ($request->date ?? date('Y-m'));
        $category = strtoupper($category);

        $groups = Movement::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->whereHasMorph('movable', Ingress::class, function ($query) {
                $query->where('company', 'coffee')
                    ->where('status', '!=', 'cancelado');
            })
            ->whereHas('product', function ($query) use ($category) {
                return $query->when($category == 'TOTAL', function ($query) {
                    $query->whereIn('category', ['INSUMOS', 'ACCESORIOS', 'VASOS', 'EQUIPO', 'REFACCIONES', 'BARRAS', 'CURSOS', 'OTROS'])
                        ->where('company', 'COFFEE');
                }, function ($query) use ($category) {
                    $query->where('category', $category)
                        ->where('company', 'COFFEE');
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
            ->whereHasMorph('movable', Ingress::class, function ($query) {
                $query->where('company', 'coffee');
            })
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

        $usualClients = Client::where('company', 'coffee')
            ->whereNotIn('id', [55, 333, 532, 568])
            ->whereHas('ingresses', function ($query) use ($date) {
                $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', '>=', substr($date, 5, 2) - 2);
            })
            ->pluck('id');
        
        $clientsComingBack = Client::where('company', 'coffee')
            ->whereNotIn('id', [55, 333, 532, 568])
            ->whereHas('ingresses', function ($query) use ($date) {
                $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', substr($date, 5, 2));
            })->whereHas('ingresses', function ($query) use ($date) {
                $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', '!=', substr($date, 5, 2) - 1);
            })->whereHas('ingresses', function ($query) use ($date) {
                $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', '!=', substr($date, 5, 2) - 2);
            })
            ->with('latest_ingresses')
            ->get()
            ->transform(function ($client, $key) {
                $ingresses = $client->latest_ingresses->where('company', 'coffee');
                return ['id' => $client->id, 'name' => $client->name, 'quantity' => $ingresses->count(), 'amount' => $ingresses->sum('amount')];
                // return ['id' => $client->id, 'name' => $client->name, 'quantity' => 100, 'amount' => 200];
            })
            ->sortByDesc('amount');

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
            ->sortByDesc('amount');

        // dd($usualClients, $newClients, $clientsComingBack);

        $unusualClients = Client::where('company', 'coffee')
            ->whereNotIn('id', [55, 333, 532, 568])
            ->whereDoesntHave('ingresses', function ($query) use ($date) {
                $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', '>=', substr($date, 5, 2) - 3);
            })
            ->count();

        $newUnusualClients = Client::where('company', 'coffee')
            ->whereNotIn('id', [55, 333, 532, 568])
            ->with('ingresses:id,amount,bought_at')
            ->whereHas('ingresses', function ($query) use ($date) {
                $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', '>=', substr($date, 5, 2) - 3);
            })->whereDoesntHave('ingresses', function ($query) use ($date) {
                $query->whereYear('bought_at', substr($date, 0, 4))->whereMonth('bought_at', '>=', substr($date, 5, 2));
            })
            ->get()
            ->transform(function ($client, $key) {
                return ['id' => $client->id, 'name' => $client->name, 'quantity' => $client->ingresses->count(), 'amount' => $client->ingresses->sum('amount')];
            })
            ->sortByDesc('amount');

        $topClients = Ingress::whereCompany('coffee')
            ->whereYear('bought_at', substr($date, 0, 4))
            ->whereMonth('bought_at', substr($date, 5, 2))
            ->whereNotIn('client_id', [55, 333, 532, 568])
            ->with('client:id,name')
            ->get()
            ->groupBy('client.name')
            ->sortByDesc(function ($ingresses, $key) {
                return $ingresses->sum('amount');
            })
            ->take(5);
        
        return view('coffee.statistics.clients', compact('usualClients', 'unusualClients', 'newUnusualClients', 'clientsComingBack', 'newClients', 'topClients', 'date'));
    }

    function shippings(Request $request, $company = null, $date = null)
    {
        $date = $date ?? ($request->date ?? date('Y-m'));

        $shippings = Shipping::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->where('company', ($company == null ? '!=': '='), $company)
            ->whereHas('address')
            ->with('ingress:id,amount', 'address:id,city,state')
            ->get();

        $total = Shipping::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->whereNotNull('company')
            ->with('ingress:id,amount')
            ->get();

        $shippingsByCompany = Shipping::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->whereNotNull('company')
            ->whereHas('address')
            ->with('ingress:id,amount', 'address:id,city,state')
            ->get()
            ->groupBy('company')->transform(function ($company, $key) {
                return ['quantity' => $company->count(), 'amount' => $company->sum(function ($item) {
                    return $item->ingress->amount;
            })];
        });

        $shippingsByState = $shippings->groupBy(function ($shipping) {return strtoupper($shipping->address->state);});

        $topPlaces = $shippings->groupBy(function ($shipping) {return strtoupper($shipping->address->city);})
            ->sortByDesc(function ($city, $key) {
                return $city->count();
            })
            ->take(5);

        $color = ['mbe etc' => 'danger', 'business express' => 'warning', 'pack service' => 'primary', 'paquete express' => 'info', 'estafeta' => 'default'][$company] ?? 'success';

        return view('coffee.statistics.shippings', compact('shippings', 'shippingsByCompany', 'shippingsByState', 'topPlaces', 'date', 'color', 'company', 'total'));
    }

    function places(Request $request)
    {
        $date = $request->date ?? date('Y-m');

        $ingresses = Ingress::whereYear('bought_at', substr($date, 0, 4))
            ->whereMonth('bought_at', substr($date, 5, 2))
            ->whereHas('client')
            ->with('client.shipping_address')
            ->get();


        $ingressesByState = $ingresses->groupBy(function ($ingress) {
                if ($ingress->client->shipping_address) {
                    return strtoupper($ingress->client->shipping_address->state);
                }
            });

        $topPlaces = $ingresses->groupBy(function ($ingress) {
                if ($ingress->client->shipping_address) {
                    return strtoupper($ingress->client->shipping_address->city);
                }
            })
            ->sortByDesc(function ($city, $key) {
                return $city->count();
            })
            ->take(5);

        return view('coffee.statistics.places', compact('ingressesByState', 'topPlaces', 'date'));
    }
}

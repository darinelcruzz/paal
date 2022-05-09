<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Product, Client, Quotation, State, Variable};
use App\Exports\ClientsExport;
use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{
    function index()
    {
        $clients = Client::where('company', 'coffee')
            ->with('addresses')
            ->get();
        return view('coffee.clients.index', compact('clients'));
    }

    function create()
    {
        $states = State::selectRaw('UPPER(name) as uppercase, name')->pluck('uppercase', 'name')->toArray();
        $regimes = Variable::where('id', '>', 3)
            ->selectRaw('CONCAT(value, " - ", description) as name, id')
            ->pluck('name', 'id')
            ->toArray();
        return view('coffee.clients.create', compact('states', 'regimes'));
    }

    function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'rfc' => 'required',
        ]);

        $client = Client::create($request->except('items', 'shipping_address', 'businessname', 'contact'));

        foreach ($request->items as $item) {
            $client->addresses()->create($item + [
                'business_name' => $request->businessname,
                'contact' => $request->contact,
                'phone' => $request->phone,
                'type' => 'facturación'
            ]);
        }

        if ($request->shipping_address == "0") {
            $client->addresses()->create($item + [
                'business_name' => $request->businessname,
                'contact' => $request->contact,
                'phone' => $request->phone,
                'type' => 'envío'
            ]);
        }

        return redirect(route('coffee.client.index'));
    }

    function show(Request $request, Client $client, $model = 'ventas')
    {
        $spanish = $model;
        $model = ['ventas' => 'App\Ingress', 'cotizaciones' => 'App\Quotation'][$model];
        $collection = $model::whereClientId($client->id)
            ->whereCompany('coffee')
            ->whereBetween($spanish == 'cotizaciones' ? 'created_at': 'bought_at', [$request->start ?? date('Y-m-d', time() - 60*60*24*30), $request->end ?? date('Y-m-d')])
            ->with('movements.product')
            ->get();
        $first = $collection->first();
        $name = $first->client_name ?? $first->client->name;
        return view('coffee.clients.show', compact('client', 'collection', 'model', 'spanish', 'name'));
    }

    public function export() 
    {
        return Excel::download(new ClientsExport, 'CLIENTES_' . date('d-m-y_his') . '.xlsx');
    }

    public function import(Request $request) 
    {
        Excel::import(new ClientsImport, $request->file('clients'));
        return redirect(route('coffee.client.index'));
    }

    function edit(Client $client)
    {
        $regimes = Variable::where('id', '>', 3)
            ->selectRaw('CONCAT(value, " - ", description) as name, id')
            ->pluck('name', 'id')
            ->toArray();
        return view('coffee.clients.edit', compact('client', 'regimes'));
    }

    function update(Request $request, Client $client)
    {
        $this->validate($request, [
            'name' => 'required',
            'rfc' => 'required',
            'tax_regime_id' => 'required',
        ]);

        $client->update($request->all());

        return redirect(route('coffee.client.index'));
    }
}

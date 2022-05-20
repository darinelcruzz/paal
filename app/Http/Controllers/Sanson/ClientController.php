<?php

namespace App\Http\Controllers\Sanson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Product, Client, Variable};

class ClientController extends Controller
{
    function index()
    {
        $clients = Client::where('company', 'sanson')->get();
        return view('sanson.clients.index', compact('clients'));
    }

    function create()
    {
        $regimes = Variable::where('id', '>', 3)
            ->selectRaw('CONCAT(value, " - ", description) as name, id')
            ->pluck('name', 'id')
            ->toArray();
        return view('sanson.clients.create', compact('regimes'));
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'rfc' => 'required',
            'tax_regime_id' => 'required'
        ]);

        Client::create($request->all() + ['company' => 'sanson']);

        return redirect(route('sanson.client.index'));
    }

    function show(Request $request, Client $client, $model = 'ventas')
    {
        $spanish = $model;
        $model = ['ventas' => 'App\Ingress', 'cotizaciones' => 'App\Quotation'][$model];
        $collection = $model::whereClientId($client->id)
            ->whereCompany('sanson')
            ->whereBetween($spanish == 'cotizaciones' ? 'created_at': 'bought_at', [$request->start ?? date('Y-m-d', time() - 60*60*24*30), $request->end ?? date('Y-m-d')])
            ->with('movements.product')
            ->get();
        $first = $collection->first();
        $name = $first->client_name ?? $first->client->name;
        return view('sanson.clients.show', compact('client', 'collection', 'model', 'spanish', 'name'));
    }

    function edit(Client $client)
    {
        $regimes = Variable::where('id', '>', 3)
            ->selectRaw('CONCAT(value, " - ", description) as name, id')
            ->pluck('name', 'id')
            ->toArray();
        return view('sanson.clients.edit', compact('client', 'regimes'));
    }

    function update(Request $request, Client $client)
    {
        $this->validate($request, [
            'name' => 'required',
            'rfc' => 'required',
        ]);

        $client->update($request->all());

        return redirect(route('sanson.client.index'));
    }
}

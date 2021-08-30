<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Product, Client, Quotation};
use App\Exports\ClientsExport;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{
    function index()
    {
        $clients = Client::where('company', 'coffee')->get();
        return view('coffee.clients.index', compact('clients'));
    }

    function create()
    {
        return view('coffee.clients.create');
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'rfc' => 'required',
        ]);

        Client::create($request->all() + ['company' => 'coffee']);

        return redirect(route('coffee.client.index'));
    }

    function show(Request $request, Client $client)
    {
        $quotations = Quotation::whereClientId($client->id)
            ->whereBetween('created_at', [$request->start ?? date('Y-m-d', time() - 60*60*24*30), $request->end ?? date('Y-m-d')])
            ->get();
        return view('coffee.clients.show', compact('client', 'quotations'));
    }

    public function export() 
    {
        return Excel::download(new ClientsExport, 'CLIENTES_' . date('d-m-y_his') . '.xlsx');
    }

    function edit(Client $client)
    {
        return view('coffee.clients.edit', compact('client'));
    }

    function update(Request $request, Client $client)
    {
        $this->validate($request, [
            'name' => 'required',
            'rfc' => 'required',
        ]);

        $client->update($request->all());

        return redirect(route('coffee.client.index'));
    }
}

<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Product, Client, Quotation, State};
use App\Exports\ClientsExport;
use App\Imports\ClientsImport;
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
        $states = State::selectRaw('UPPER(name) as uppercase, name')->pluck('uppercase', 'name')->toArray();
        return view('coffee.clients.create', compact('states'));
    }

    function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'rfc' => 'required',
        ]);

        $client = Client::create($request->except('items', 'shipping_address', 'businessname', 'contact'));

        foreach ($request->items as $item) {
            $client->addresses()->create($item + [
                'business_name' => $request->businessname,
                'contact' => $request->contact,
                'phone' => $request->phone,
                'status' => 'facturación'
            ]);
        }

        if ($request->shipping_address == "0") {
            $client->addresses()->create($item + [
                'business_name' => $request->businessname,
                'contact' => $request->contact,
                'phone' => $request->phone,
                'status' => 'envío'
            ]);
        }

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

    public function import(Request $request) 
    {
        Excel::import(new ClientsImport, $request->file('clients'));
        return redirect(route('coffee.client.index'));
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

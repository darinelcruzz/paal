<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Product, Client};

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

        Client::create([
            'name' => $request->name,
            'address' => ' ',
            'postcode' => ' ',
            'city' => ' ',
            'state' => ' ',
            'rfc' => $request->rfc,
            'phone' => ' ',
            'email' => $request->email,
            'company' => 'coffee',
        ]);

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

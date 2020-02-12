<?php

namespace App\Http\Controllers\Sanson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Product, Client};

class ClientController extends Controller
{
    function index()
    {
        $clients = Client::where('company', 'sanson')->get();
        return view('sanson.clients.index', compact('clients'));
    }

    function create()
    {
        return view('sanson.clients.create');
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'rfc' => 'required',
        ]);

        Client::create($request->all() + ['company' => 'sanson']);

        return redirect(route('sanson.client.index'));
    }

    function edit(Client $client)
    {
        return view('sanson.clients.edit', compact('client'));
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

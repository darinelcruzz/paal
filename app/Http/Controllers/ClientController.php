<?php

namespace App\Http\Controllers;

use App\{Client, Variable};
use Illuminate\Http\Request;

class ClientController extends Controller
{
    function index()
    {
        $clients = Client::all();
        return view('paal.clients.index', compact('clients'));
    }

    function create()
    {
        $regimes = Variable::where('id', '>', 3)
            ->selectRaw('CONCAT(value, " - ", description) as name, id')
            ->pluck('name', 'id');
        return view('paal.clients.create', compact('regimes'));
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'rfc' => 'required',
            'email' => 'required',
        ]);

        Client::create($request->all());

        return redirect(route('paal.client.index'));
    }

    function show(Client $client)
    {
        return;
    }

    function edit(Client $client)
    {
        return view('paal.clients.edit', compact('client'));
    }

    function update(Request $request, Client $client)
    {
        $this->validate($request, [
            'name' => 'required',
            'rfc' => 'required',
            'email' => 'required',
        ]);

        $client->update($request->all());

        return redirect(route('paal.client.index'));
    }

    function destroy(Client $client)
    {
        return;
    }
}

<?php

namespace App\Http\Controllers\Mailboxes;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    function index()
    {
        $clients = Client::where('company', 'mbe')->get();
        return view('mbe.eclients.index', compact('clients'));
    }

    function create()
    {
        return view('mbe.eclients.create');
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'rfc' => 'required',
            'company' => 'required',
        ]);

        Client::create($request->all());

        return redirect(route('mbe.client.index'));
    }

    function edit(Client $client)
    {
        return view('mbe.eclients.edit', compact('client'));
    }

    function update(Request $request, Client $client)
    {
        $this->validate($request, [
            'name' => 'required',
            'rfc' => 'required',
        ]);

        $client->update($request->all());

        return redirect(route('mbe.client.index'));
    }
}

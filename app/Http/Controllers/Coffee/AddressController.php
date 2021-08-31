<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Client, Address, State};

class AddressController extends Controller
{
    function create(Client $client)
    {
        $states = State::selectRaw('UPPER(name) as uppercase, name')->pluck('uppercase', 'name')->toArray();
        return view('coffee.addresses.create', compact('client', 'states'));
    }

    function store(Request $request, Client $client)
    {
        $client->addresses()->create($request->all());

        return redirect(route('coffee.client.index'));
    }

    function edit(Address $address)
    {
        return view('coffee.addresses.edit', compact('address'));
    }

    function update(Request $request, Address $address)
    {
    	$address->update($request->all());

        return redirect(route('coffee.client.index'));
    }
}

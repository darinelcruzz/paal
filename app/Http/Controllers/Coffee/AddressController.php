<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Client, Address};

class AddressController extends Controller
{
    function create(Client $client)
    {
        return view('coffee.addresses.create', compact('client'));
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

<?php

namespace App\Http\Controllers\Sanson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Client, Address};

class AddressController extends Controller
{
    function create(Client $client)
    {
        return view('sanson.addresses.create', compact('client'));
    }

    function store(Request $request, Client $client)
    {
        $client->addresses()->create($request->all());

        return redirect(route('sanson.client.index'));
    }

    function edit(Address $address)
    {
        return view('sanson.addresses.edit', compact('address'));
    }

    function update(Request $request, Address $address)
    {
    	$address->update($request->all());

        return redirect(route('sanson.client.index'));
    }
}

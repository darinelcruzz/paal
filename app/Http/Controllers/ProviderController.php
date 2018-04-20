<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    function index()
    {
        $providers = Provider::all();
        return view('paal.providers.index', compact('providers'));
    }

    function create()
    {
        return view('paal.providers.create');
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'social' => 'required',
            'name' => 'required',
            'rfc' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'type' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'company' => 'required',
            'amount' => 'required',
            'bills' => 'required'
        ]);

        Provider::create($request->all());

        return redirect(route('paal.provider.index'));
    }

    function show(Provider $provider)
    {
        // todo
    }

    function edit(Provider $provider)
    {
        // todo
    }

    function update(Request $request, Provider $provider)
    {
        // todo
    }

    function destroy(Provider $provider)
    {
        // todo
    }
}

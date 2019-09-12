<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    function index()
    {
        $providers = Provider::where('status','activo')->get();
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
            'group' => 'required',
            'type' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'company' => 'required',
            'amount' => 'required',
            'bills' => 'required',
            'xml_required' => 'required'
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
        return view('paal.providers.edit', compact('provider'));
    }

    function update(Request $request, Provider $provider)
    {
        $provider->update($request->all());

        return redirect(route('paal.provider.index'));
    }

    function destroy(Provider $provider)
    {
        $provider->update(['status'=>'cancelado']);
        return back();
    }
}

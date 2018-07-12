<?php

namespace App\Http\Controllers;

use App\{Ingress, Client};
use Illuminate\Http\Request;

class IngressController extends Controller
{
    function index()
    {
        $coffee = Ingress::where('company', 'coffee')->get();
        $mbe = Ingress::where('company', 'mbe')->get();
        return view('paal.ingresses.index', compact('coffee', 'mbe'));
    }

    function create($company)
    {
        $clients = Client::pluck('name', 'id')->toArray();
        return view('paal.ingresses.create', compact('clients', 'company'));
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required',
            'bought_at' => 'required',
            'paid_at' => 'required',
            'amount' => 'required',
            'iva' => 'required|lt:amount',
            'method' => 'required',
        ],[
            'iva.lt' => 'No puede ser mayor que total'
        ]);

        Ingress::create($request->all());

        return redirect(route('paal.ingress.index'));
    }

    function show(Ingress $ingress)
    {
        //
    }

    function edit(Ingress $ingress)
    {
        //
    }

    function update(Request $request, Ingress $ingress)
    {
        //
    }

    function destroy(Ingress $ingress)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\{Ingress, Client};
use Illuminate\Http\Request;

class IngressController extends Controller
{
    function index()
    {
        $ingresses = Ingress::all();
        return view('paal.ingresses.index', compact('ingresses'));
    }

    function create()
    {
        $clients = Client::pluck('name', 'id')->toArray();
        return view('paal.ingresses.create', compact('clients'));
    }

    function store(Request $request)
    {
        //
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

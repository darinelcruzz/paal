<?php

namespace App\Http\Controllers;

use App\{Ingress, Client, Product};
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
        $clients = Client::where('company', $company)->orWhere('company', 'both')->pluck('name', 'id')->toArray();
        $products = Product::all();
        return view('paal.ingresses.create', compact('clients', 'company', 'products'));
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

    function futureStore(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required',
            'amount' => 'required',
        ]);

        $products = [];

        for ($i=0; $i < count($request->items); $i++) { 
            array_push($products, [
                'i' => $request->items[$i],
                'q' => $request->quantities[$i],
                'p' => $request->prices[$i],
                't' => $request->subtotals[$i],
            ]);
        }

        $ingress = Ingress::create([
            'client_id' => $request->client_id,
            'amount' => $request->amount,
            'iva' => $request->iva,
            'company' => 'coffee',
            'products' => serialize($products),
            'bought_at' => date('Y-m-d'),
            'paid_at' => date('Y-m-d'),
            'status' => 'pagada',
        ]);

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

    function print(Request $request)
    {
        $info = $request->all();
        return view('paal.ingresses.print', compact('info'));
    }

    function destroy(Ingress $ingress)
    {
        //
    }
}

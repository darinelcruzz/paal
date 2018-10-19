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
        $validated = $this->validate($request, [
            'client_id' => 'required',
            'amount' => 'required',
            'iva' => 'required',
            'company' => 'required',
            'bought_at' => 'required',
            'method' => 'sometimes|required',
            'reference' => 'sometimes|required',
            'methodA' => 'sometimes|required',
            'referenceA' => 'sometimes|required',
            'retainer' => 'sometimes|required',
        ]);

        $ingress = Ingress::create($validated);

        $products = [];

        for ($i=0; $i < count($request->items); $i++) { 
            array_push($products, [
                'i' => $request->items[$i],
                'q' => $request->quantities[$i],
                'p' => $request->prices[$i],
                'd' => $request->discounts[$i],
                't' => $request->subtotals[$i],
            ]);
        }

        if (isset($request->methodA)) {
            $ingress->update([
                'products' => serialize($products),
                'retained_at' => date('Y-m-d'),
                'status' => 'pendiente'
            ]);
        } else {
            $ingress->update([
                'products' => serialize($products),
                'paid_at' => date('Y-m-d'),
                'status' => $request->method == 5 ? 'crédito' :'pendiente'
            ]);
        }

        return redirect(route('paal.ingress.index'));
    }

    function show(Ingress $ingress)
    {
        return view('paal.ingresses.show', compact('ingress'));
    }

    function charge(Ingress $ingress)
    {
        return view('paal.ingresses.charge',compact('ingress'));
    }

    function pay(Request $request, Ingress $ingress)
    {
        $validated = $this->validate($request, [
            'method' => 'required',
            'reference' => 'sometimes|required'
        ]);

        $ingress->update($validated);
        $ingress->update([
            'status' => 'pagado',
            'paid_at' => date('Y-m-d')
        ]);

        return redirect(route('paal.ingress.index'));
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

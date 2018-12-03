<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Product, Client};

class IngressController extends Controller
{
    function index()
    {
        $ingresses = Ingress::where('company', 'coffee')
                        ->where('status', '!=', 'cancelado')
                        ->get();
        return view('coffee.ingresses.index', compact('ingresses'));
    }

    function create()
    {
        $clients = Client::where('company', '!=', 'mbe')->pluck('name', 'id')->toArray();
        $products = Product::all();
        return view('coffee.ingresses.create', compact('clients', 'products'));
    }

    function store(Request $request)
    {
        // dd($request->all());
        $validated = $this->validate($request, [
            'client_id' => 'required',
            'amount' => 'required',
            'iva' => 'required',
            'bought_at' => 'required',
            'company' => 'required',
            'method' => 'required',
            'items' => 'required|array|min:1',
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
                'status' => $request->method == 5 ? 'crédito' :'pagado'
            ]);
        }

        return redirect(route('coffee.ingress.index'));
    }

    function show(Ingress $ingress)
    {
        return view('coffee.ingresses.show', compact('ingress'));
    }

    function pay(Ingress $ingress)
    {
        return view('coffee.ingresses.pay', compact('ingress'));
    }

    function settle(Request $request)
    {
        $this->validate($request, [
            'pdf_payment' => 'required',
            'payment_date' => 'required',
            'method' => 'required',
            'mfolio' => 'sometimes|required',
        ]);

        $ingress = Ingress::find($request->id);

        $path_to_pdf = Storage::putFileAs(
            "public/coffee/payments", $request->file("pdf_payment"), $ingress->payment_date . "_" . $ingress->id . ".pdf"
        );

        $ingress->update($request->only(['payment_date', 'method', 'mfolio']));

        $ingress->update([
            'pdf_payment' => $path_to_pdf,
            'status' => 'pagado',
        ]);

        return redirect(route('coffee.ingress.index'));
    }
}

<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Product, Client, Payment};

class IngressController extends Controller
{
    function index()
    {
        $ingresses = Ingress::where('company', 'coffee')
                        ->where('status', '!=', 'cancelado')
                        ->orderByDesc('id')
                        ->get();
        return view('coffee.ingresses.index', compact('ingresses'));
    }

    function create()
    {
        $clients = Client::where('company', '!=', 'mbe')->get(['id', 'name'])->toJson();
        $products = Product::all();
        return view('coffee.ingresses.create', compact('clients', 'products'));
    }

    function store(Request $request)
    {
        $validated = $this->validate($request, [
            'client_id' => 'required',
            'amount' => 'required',
            'invoice' => 'required',
            'iva' => 'required',
            'company' => 'required',
            'bought_at' => 'required',
        ]);

        $total = $request->cash + $request->transfer + $request->check
            + $request->debit_card + $request->credit_card;

        $ingress = Ingress::create([
            'client_id' => $request->client_id,
            'user_id' => $request->user_id,
            'invoice' => $request->invoice,
            'amount' => $request->amount,
            'iva' => $request->iva,
            'company' => $request->company,
            'bought_at' => $request->bought_at,
            'retainer' => $request->type == 'anticipo' ? $total: 0,
        ]);

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

        if ($request->type == 'anticipo') {
            $ingress->update([
                'products' => serialize($products),
                'retained_at' => date('Y-m-d'),
                'status' => 'pendiente'
            ]);
        } else {
            $ingress->update([
                'products' => serialize($products),
                'paid_at' => date('Y-m-d'),
                // 'status' => $request->method == 5 ? 'crédito' :'pendiente'
                'status' => 'pagado'
            ]);
        }

        $payment = Payment::create([
            'ingress_id' => $ingress->id,
            'type' => $request->type,
            'cash' => $request->cash,
            'transfer' => $request->transfer,
            'check' => $request->check,
            'debit_card' => $request->debit_card,
            'credit_card' => $request->credit_card,
            'reference' => $request->reference,
        ]);

        return redirect(route('coffee.ingress.index'));
    }

    function show(Ingress $ingress)
    {
        return view('coffee.ingresses.show', compact('ingress'));
    }

    function charge(Ingress $ingress)
    {
        return view('coffee.ingresses.charge', compact('ingress'));
    }

    function ticket(Ingress $ingress)
    {
        $payment = $ingress->payments->first();
        return view('coffee.ingresses.ticket', compact('ingress', 'payment'));
    }

    function pay(Request $request, Ingress $ingress)
    {
        $this->validate($request, [
            'cash' => 'required',
            'transfer' => 'required',
            'check' => 'required',
            'debit_card' => 'required',
            'credit_card' => 'required',
            'type' => 'required'
        ]);

        $payment = Payment::create($request->all());

        if ($ingress->debt == 0) {
            $ingress->update([
                'status' => 'pagado',
                'paid_at' => date('Y-m-d')
            ]);

            $payment->update([
                'type' => 'liquidación'
            ]);
        }

        return view('coffee.ingresses.show', compact('ingress'));
    }
}

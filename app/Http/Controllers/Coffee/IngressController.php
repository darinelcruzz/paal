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
                        ->get();
        return view('coffee.ingresses.index', compact('ingresses'));
    }

    function create()
    {
        $clients = Client::where('company', '!=', 'mbe')->get(['id', 'name'])->toJson();
        // dd($clients);
        $products = Product::all();
        return view('coffee.ingresses.create', compact('clients', 'products'));
    }

    function store(Request $request)
    {
        $validated = $this->validate($request, [
            'client_id' => 'required',
            'amount' => 'required',
            'iva' => 'required',
            'company' => 'required',
            'bought_at' => 'required',
        ]);

        $total = $request->cash + $request->transfer + $request->check
            + $request->debit_card + $request->credit_card;

        $ingress = Ingress::create([
            'client_id' => $request->client_id,
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

    function pay(Ingress $ingress)
    {
        return view('coffee.ingresses.pay', compact('ingress'));
    }

    function ticket(Ingress $ingress)
    {
        return view('coffee.ingresses.ticket');
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

<?php

namespace App\Http\Controllers\Sanson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Product, Client, Payment};
use Alert;

class IngressController extends Controller
{
    function index()
    {
        $date = dateFromRequest('Y-m');

        $ingresses = Ingress::where('company', 'sanson')
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->orderByDesc('id')
            ->with('client', 'movements.product', 'payments')
            ->get();

        return view('sanson.ingresses.index', compact('ingresses', 'date'));
    }

    function create($type)
    {
        $last_sale = Ingress::where('company', 'sanson')->get()->last();
        $last_folio = $last_sale ? $last_sale->folio + 1: 1;
        return view('sanson.ingresses.create', compact('last_folio', 'type'));
    }

    function store(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'client_id' => 'required',
            'user_id' => 'required',
            'quotation_id' => 'sometimes|required',
            'amount' => 'required',
            'invoice' => 'required',
            'iva' => 'required',
            'company' => 'required',
            'type' => 'required',
            'bought_at' => 'required',
            'rounding' => 'required',
            'folio' => 'required'
        ]);

        if ($request->folio != Ingress::where('company', 'sanson')->get()->last()->folio) {

            $last_sale = Ingress::where('company', 'sanson')->get()->last();
            $validated['folio'] = $last_sale ? $last_sale->folio + 1: 1;

            $ingress = Ingress::create($validated);

            $ingress->payments()->create($request->only('cash', 'transfer', 'check', 'debit_card', 'credit_card') + [
                'type' => $request->method,
                'reference' => isset($request->reference) ? $request->reference: null,
                'card_number' => isset($request->card_number) ? $request->card_number: null,
            ]);

            $ingress->update(['method' => $ingress->pay_method]);

            if ($ingress->areSerialNumbersMissing) {
                return redirect(route('sanson.ingress.update', $ingress));
            }
        }

        return redirect(route('sanson.ingress.index'));
    }

    function show(Ingress $ingress)
    {
        return view('sanson.ingresses.show', compact('ingress'));
    }

    function update(Ingress $ingress)
    {
        return view('sanson.ingresses.update', compact('ingress'));
    }

    function ticket(Ingress $ingress)
    {
        $payment = $ingress->payments->first();
        return view('sanson.ingresses.ticket', compact('ingress', 'payment'));
    }

    function destroy(Ingress $ingress, $reason)
    {
        Alert::success('Venta cancelada', "La venta $ingress->folio se ha cancelado exitosamente")->persistent('Cerrar');

        $ingress->update([
            'status' => 'cancelado',
            'canceled_for' => $reason
        ]);

        if ($ingress->shipping) {
            $ingress->shipping->update(['status' => 'cancelado']);
        }

        return back();
    }
}

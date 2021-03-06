<?php

namespace App\Http\Controllers\Coffee;

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

        $ingresses = Ingress::where('company', 'coffee')
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->orderByDesc('id')
            ->with('client', 'movements.product', 'payments')
            ->get();     

        return view('coffee.ingresses.index', compact('ingresses', 'date'));
    }

    function create()
    {
        $clients = Client::where('company', '!=', 'mbe')->get(['id', 'name', 'rfc'])->toJson();
        $last_sale = Ingress::where('company', 'coffee')->get()->last();
        $last_folio = $last_sale ? $last_sale->folio + 1: 1;
        return view('coffee.ingresses.create', compact('clients', 'last_folio'));
    }

    function store(Request $request)
    {
        // dd($request->all());
        $validated = $this->validate($request, [
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
       ]);

        if ($request->folio != Ingress::where('company', 'coffee')->get()->last()->folio) {

            $last_sale = Ingress::where('company', 'coffee')->get()->last();
            $last_folio = $last_sale ? $last_sale->folio + 1: 1;

            $total = $request->cash + $request->transfer + $request->check
                + $request->debit_card + $request->credit_card;

            $ingress = Ingress::create($validated + [
                'folio' => $last_folio,
                'retainer' => $request->method == 'anticipo' ? $total: 0,
            ]);

            $ingress->update([
                'retained_at' => $request->method == 'anticipo' ? date('Y-m-d'): null,
                'paid_at' => $request->method == 'anticipo' ? null: date('Y-m-d'),
                'status' => $request->method == 'anticipo' ? 'pendiente': 'pagado'
            ]);

            $ingress->payments()->create($request->only('cash', 'transfer', 'check', 'debit_card', 'credit_card') + [
                'type' => $request->method,
                'reference' => isset($request->reference) ? $request->reference: null,
                'card_number' => isset($request->card_number) ? $request->card_number: null,
            ]);

            $methods = ['undefined' => null, 'cash' => 'efectivo', 'transfer' => 'transferencia', 'check' => 'cheque', 'debit_card' => 'tarjeta débito', 'credit_card' => 'tarjeta crédito'];
            $ingress->update(['method' => $methods[$ingress->inferred_method]]);

            if ($ingress->areSerialNumbersMissing) {
                return redirect(route('coffee.ingress.update', $ingress));
            }
        }

        return redirect(route('coffee.ingress.index'));
    }

    function show(Ingress $ingress)
    {
        return view('coffee.ingresses.show', compact('ingress'));
    }

    function update(Ingress $ingress)
    {
        return view('coffee.ingresses.update', compact('ingress'));
    }

    function ticket(Ingress $ingress)
    {
        $payment = $ingress->payments->first();
        return view('coffee.ingresses.ticket', compact('ingress', 'payment'));
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

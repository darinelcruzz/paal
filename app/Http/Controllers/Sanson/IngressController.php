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
            'folio' => 'required'
        ]);

        $total = $request->payment['cash'] + $request->payment['transfer'] + $request->payment['check']
                + $request->payment['debit_card'] + $request->payment['credit_card'];

        $ingress = Ingress::create($validated + [
            'retainer' => $request->method == 'anticipo' ? $total: 0,
            'retained_at' => $request->method == 'anticipo' ? date('Y-m-d'): null,
            'paid_at' => $request->method == 'anticipo' ? null: date('Y-m-d'),
            'status' => $request->method == 'anticipo' ? 'pendiente': 'pagado'
        ]);

        $methods = ['undefined' => null, 'cash' => 'efectivo', 'transfer' => 'transferencia', 'check' => 'cheque', 'debit_card' => 'tarjeta débito', 'credit_card' => 'tarjeta crédito'];
        $ingress->update(['method' => $methods[$ingress->inferred_method]]);

        return redirect(route('sanson.ingress.index'));
    }

    function show(Ingress $ingress)
    {
        return view('sanson.ingresses.show', compact('ingress'));
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

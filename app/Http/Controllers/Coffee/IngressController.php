<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Product, Client, Payment, Log, Variable, Movement};
use Alert;

class IngressController extends Controller
{
    function index()
    {
        $date = dateFromRequest('Y-m');

        $ingresses = Ingress::query()
            ->select('id', 'folio', 'client_id', 'bought_at', 'invoice', 'status', 'amount', 'iva', 'company', 'created_at', 'quotation_id', 'method', 'type', 'rounding', 'sae')
            ->whereStoreId(auth()->user()->store_id)
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->orderByDesc('id')
            ->with('client:id,name', 'quotation:id', 'quotation.retainers:id,amount', 'retainers:id,folio')
            ->get();

        return view('coffee.ingresses.index', compact('ingresses', 'date', 'user'));
    }

    function create($type = null)
    {
        $user = auth()->user();
        $last_sale = Ingress::query()
            ->whereStoreId($user->store_id)
            ->latest()
            ->first();

        $last_folio = $last_sale ? $last_sale->folio + 1: 1;
        $exchange = Variable::find(1)->value;
        $promo = Variable::find(2)->value;
        return view('coffee.ingresses.create', compact('last_folio', 'type', 'exchange', 'promo', 'user'));
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
            'company_id' => 'required',
            'store_id' => 'required',
            'type' => 'required',
            'bought_at' => 'required',
            'rounding' => 'required',
            'folio' => 'required',
       ]);

        $last_sale = Ingress::whereStoreId($request->store_id)->latest()->first();
        $validated['folio'] = $last_sale ? $last_sale->folio + 1: 1;

        $ingress = Ingress::create($validated);

        $ingress->payments()->create($request->only('cash', 'transfer', 'check', 'debit_card', 'credit_card') + [
            'type' => $request->method,
            'reference' => isset($request->reference) ? $request->reference: null,
            'card_number' => isset($request->card_number) ? $request->card_number: null,
        ]);
        
        $ingress->update(['method' => $ingress->pay_method]);

        if ($ingress->areSerialNumbersMissing) {
            return redirect(route('coffee.ingress.update', $ingress));
        }

        return redirect(route('coffee.ingress.index'));
    }

    function show(Ingress $ingress)
    {
        return view('coffee.ingresses.show', compact('ingress'));
    }

    function update(Request $request, Ingress $ingress)
    {
        return view('coffee.ingresses.update', compact('ingress'));
    }

    function updateSAE(Request $request, Ingress $ingress)
    {
        $validated = $request->validate([
            'sae' => 'required'
        ]);

        $ingress->update($validated);

        return redirect(route('coffee.ingress.index'));
    }

    function ticket(Ingress $ingress)
    {
        $payment = $ingress->payments->first();
        return view('coffee.ingresses.ticket', compact('ingress', 'payment'));
    }

    function destroy(Ingress $ingress, $reason)
    {
        $ingress->update([
            'status' => 'cancelado',
            'canceled_for' => $reason
        ]);

        if ($ingress->shipping) {
            $ingress->shipping->update(['status' => 'cancelado']);
        }

        return redirect(route('coffee.ingress.index'));
    }

}

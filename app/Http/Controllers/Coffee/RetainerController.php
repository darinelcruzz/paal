<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Retainer, Ingress, Quotation};

class RetainerController extends Controller
{
    function create(Quotation $quotation)
    {
        $user = auth()->user();
        
        $last_sale = Ingress::query()
            ->whereStoreId($user->store_id)
            ->latest()
            ->first();

        $last_folio = $last_sale ? $last_sale->folio + 1: 1;
        return view('coffee.retainers.create', compact('quotation', 'last_folio', 'user'));
    }

    function store(Request $request, Quotation $quotation)
    {
        // dd($request->all());

        $attributes = $request->validate([
            'amount' => 'required',
            'paid_at' => 'required',
        ]);

        $ingress = Ingress::create($request->except('cash', 'check', 'credit_card', 'debit_card', 'transfer', 'reference', 'card_number'));

        $ingress->payments()->create([
            'type' => 'anticipo',
            'cash' => $request->cash,
            'check' => $request->check,
            'credit_card' => $request->credit_card,
            'debit_card' => $request->debit_card,
            'transfer' => $request->transfer,
            'reference' => $request->reference,
            'card_number' => $request->card_number,
            'created_at' => $request->paid_at,
        ]);

        $ingress->update(['method' => $ingress->pay_method]);

        return redirect(route('coffee.ingress.index'));
    }
}

<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Retainer, Ingress, Quotation};

class RetainerController extends Controller
{
    function create(Quotation $quotation)
    {
        $last_sale = Ingress::where('company', 'coffee')->get()->last();
        $last_folio = $last_sale ? $last_sale->folio + 1: 1;
        return view('coffee.retainers.create', compact('quotation', 'last_folio'));
    }

    function store(Request $request, Quotation $quotation)
    {
        $attributes = $request->validate([
            'amount' => 'required',
            'invoice_id' => 'required',
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

        return redirect(route('coffee.ingress.index'));
    }
}

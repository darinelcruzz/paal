<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Retainer, Ingress};

class RetainerController extends Controller
{
    function index()
    {
        $retainers = Retainer::with('client')->get();
        return view('coffee.retainers.index', compact('retainers'));
    }

    function create()
    {
        return view('coffee.retainers.create');
    }

    function store(Request $request)
    {
        // dd($request->all());
        $attributes = $request->validate([
            'amount' => 'required',
            'folio' => 'required',
            'client_id' => 'required',
            'retained_at' => 'required',
            'company' => 'required',
            'user_id' => 'required',
        ]);

        $retainer = Retainer::create($attributes);

        $retainer->payments()->create([
            'type' => 'contado',
            'cash' => $request->cash,
            'check' => $request->check,
            'credit_card' => $request->credit_card,
            'debit_card' => $request->debit_card,
            'transfer' => $request->transfer,
            'reference' => $request->reference,
            'paid_at' => $request->retained_at,
        ]);

        return redirect(route('coffee.retainer.index'));
    }

    function show(Retainer $retainer)
    {
        return view('coffee.retainers.show', compact('retainer'));
    }

    function transform(Retainer $retainer)
    {
        $last_sale = Ingress::where('company', 'coffee')->get()->last();
        $last_folio = $last_sale ? $last_sale->folio + 1: 1;
        return view('coffee.retainers.transform', compact('retainer', 'last_folio'));
    }

    function deposit(Request $request, Retainer $retainer)
    {
        if (isset($request->cash)) {
            $request->validate([
                'amount' => 'required',
            ]);

            $retainer->payments()->create([
                'type' => 'abono',
                'cash' => $request->cash,
                'check' => $request->check,
                'credit_card' => $request->credit_card,
                'debit_card' => $request->debit_card,
                'transfer' => $request->transfer,
                'reference' => $request->reference,
                'paid_at' => date('Y-m-d'),
            ]);

            $retainer->update([
                'amount' => $retainer->amount + $request->amount
            ]);

            return redirect(route('coffee.retainer.index'));
        }

        return view('coffee.retainers.deposit', compact('retainer'));
    }

    function update(Request $request, Retainer $retainer)
    {
        //
    }

    function destroy(Retainer $retainer)
    {
        //
    }
}

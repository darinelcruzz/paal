<?php

namespace App\Http\Controllers\Sanson;

use App\{Payment, Ingress};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    function create(Ingress $ingress)
    {
        return view('sanson.payments.create', compact('ingress'));
    }

    function store(Request $request, Ingress $ingress)
    {
        $this->validate($request, [
            'cash' => 'required',
            'transfer' => 'required',
            'check' => 'required',
            'debit_card' => 'required',
            'credit_card' => 'required',
            'type' => 'required'
        ]);

        $ingress->payments()->create($request->all());

        if ($ingress->debt == 0) {
            $ingress->update([
                'status' => 'pagado',
                'paid_at' => date('Y-m-d')
            ]);

            $ingress->payments->last()->update([
                'type' => 'liquidación'
            ]);
        }

        return view('sanson.ingresses.show', compact('ingress'));
    }

    function edit(Ingress $ingress)
    {
        $payment = $ingress->payments->first();
        $total = $ingress->amount;
        return view('sanson.payments.edit', compact('payment', 'total'));
    }

    function update(Request $request, Payment $payment)
    {
        // dd($request->all());
        $attributes = $request->validate([
            'cash' => 'required',
            'transfer' => 'required',
            'check' => 'required',
            'debit_card' => 'required',
            'credit_card' => 'required',
            'reference' => 'sometimes|required',
            'card_number' => 'sometimes|required',
        ]);

        $payment->update($attributes);

        return redirect(route('sanson.ingress.index'));
    }

    function print(Ingress $ingress)
    {
        return view('sanson.payments.print', compact('ingress'));
    }
}

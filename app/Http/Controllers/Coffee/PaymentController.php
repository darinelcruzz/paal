<?php

namespace App\Http\Controllers\Coffee;

use App\{Payment, Ingress};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    function index(Ingress $ingress)
    {
        $payments = $ingress->payments;
        return view('coffee.payments', compact('payments'));
    }

    function create()
    {
        //
    }

    function store(Request $request)
    {
        //
    }

    function show(Payment $payment)
    {
        //
    }

    function edit(Payment $payment)
    {
        //
    }

    function update(Request $request, Payment $payment)
    {
        //
    }

    function destroy(Payment $payment)
    {
        //
    }
}

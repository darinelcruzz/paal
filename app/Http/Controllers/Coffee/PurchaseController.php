<?php

namespace App\Http\Controllers\Coffee;

use App\Purchase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    function index()
    {
        $purchases = Purchase::whereCompany('coffee')->get();
        return view('coffee.purchases.index', compact('purchases'));
    }

    function create()
    {
        //
    }

    function store(Request $request)
    {
        $attributes = $request->validate([
            'provider_id' => 'required',
            'purchased_at' => 'required',
            'company' => 'required',
            'user_id' => 'required',
            'order_id' => 'required',
            'amount' => 'required',
            'folio' => 'required',
        ]);

        Purchase::create($attributes);

        return redirect(route('coffee.purchase.index'));
    }

    function show(Purchase $purchase)
    {
        return view('coffee.purchases.show', compact('purchase'));
    }

    function edit(Purchase $purchase)
    {
        //
    }

    function update(Request $request, Purchase $purchase)
    {
        //
    }

    function destroy(Purchase $purchase)
    {
        //
    }
}

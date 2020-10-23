<?php

namespace App\Http\Controllers\Coffee;

use App\{Order, Provider, Purchase};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function index()
    {
        $orders = Order::whereCompany('coffee')->get();
        return view('coffee.orders.index', compact('orders'));
    }

    function create()
    {
        $providers = Provider::whereCompany('coffee')->pluck('name', 'id')->toArray();
        return view('coffee.orders.create', compact('providers'));
    }

    function store(Request $request)
    {
        $attributes = $request->validate([
            'provider_id' => 'required',
            'ordered_at' => 'required',
            'company' => 'required',
            'user_id' => 'required',
            'amount' => 'required',
        ]);

        Order::create($attributes);

        return redirect(route('coffee.order.index'));
    }

    function show(Order $order)
    {
        return view('coffee.orders.show', compact('order'));
    }

    function edit(Order $order)
    {
        //
    }

    function update(Request $request, Order $order)
    {
        //
    }

    function transform(Order $order)
    {
        $last_purchase = Purchase::where('company', 'coffee')->get()->last();
        $last_folio = $last_purchase ? $last_purchase->folio + 1: 1;
        return view('coffee.orders.transform', compact('order', 'last_folio'));
    }

    function destroy(Order $order)
    {
        //
    }
}

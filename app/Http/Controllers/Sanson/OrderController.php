<?php

namespace App\Http\Controllers\Sanson;

use App\{Order, Provider, Purchase};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function index()
    {
        $orders = Order::whereCompany('sanson')->get();
        return view('sanson.orders.index', compact('orders'));
    }

    function create()
    {
        $providers = Provider::whereCompany('sanson')->pluck('name', 'id')->toArray();
        return view('sanson.orders.create', compact('providers'));
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

        return redirect(route('sanson.order.index'));
    }

    function show(Order $order)
    {
        return view('sanson.orders.show', compact('order'));
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
        $last_purchase = Purchase::where('company', 'sanson')->get()->last();
        $last_folio = $last_purchase ? $last_purchase->folio + 1: 1;
        return view('sanson.orders.transform', compact('order', 'last_folio'));
    }

    function print(Order $order)
    {
        return view('sanson.orders.print', compact('order'));
    }

    function destroy(Order $order)
    {
        //
    }
}

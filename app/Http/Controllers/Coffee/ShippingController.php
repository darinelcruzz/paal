<?php

namespace App\Http\Controllers\Coffee;

use App\Shipping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingController extends Controller
{
    function index()
    {
        $shippings = Shipping::all();

        return view('coffee.shippings.index', compact('shippings'));
    }

    function create()
    {
        //
    }

    function store(Request $request)
    {
        //
    }

    function show(Shipping $shipping)
    {
        //
    }

    function edit(Shipping $shipping, $status)
    {
        $shipping->update(['status' => $status]);

        return back();
    }

    function update(Request $request, Shipping $shipping)
    {
        $shipping->update($request->validate(['guide_number' => 'required']));

        return redirect(route('coffee.shipping.index'));
    }

    function destroy(Shipping $shipping)
    {
        //
    }
}

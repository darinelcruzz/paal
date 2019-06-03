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

    function print(Shipping $shipping)
    {
        return view('coffee.shippings.print', compact('shipping'));
    }

    function edit(Shipping $shipping, $status)
    {
        $shipping->update(['status' => $status]);

        return back();
    }

    function update(Request $request, Shipping $shipping)
    {
        $shipping->update($request->validate(['guide_number' => 'required']));
        
        $shipping->update(['status' => 'en tránsito']);

        return redirect(route('coffee.shipping.index'));
    }

    function destroy(Shipping $shipping)
    {
        //
    }
}

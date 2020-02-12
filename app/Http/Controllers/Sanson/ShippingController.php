<?php

namespace App\Http\Controllers\Sanson;

use App\{Shipping, Address};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingController extends Controller
{
    function index(Request $request, $status)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $shippings = Shipping::whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->where('status', $status == 'todos' ? '!=': '=', $status)
            ->orderByDesc('id')
            ->get();

        return view('sanson.shippings.index', compact('shippings', 'date', 'status'));
    }

    function monthly(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $shippings = Shipping::whereYear('shipped_at', substr($date, 0, 4))
            ->whereMonth('shipped_at', substr($date, 5))
            ->get();

        return view('sanson.shippings.monthly', compact('shippings', 'date'));
    }

    function addInfo(Shipping $shipping)
    {
        $addresses = Address::where('client_id', $shipping->ingress->client_id)
            ->where('status', 'active')
            ->selectRaw("id, CONCAT(street,' ', street_number,' ', district,' C.P. ', postcode,' ', city,' ', state) AS address")
            ->pluck('address', 'id')
            ->toArray();

        return view('sanson.shippings.addInfo', compact('addresses', 'shipping'));
    }

    function print(Shipping $shipping)
    {
        return view('sanson.shippings.print', compact('shipping'));
    }

    function edit(Shipping $shipping)
    {
        return view('sanson.shippings.edit', compact('shipping'));
    }

    function update(Request $request, Shipping $shipping)
    {
        $attributes = $request->validate([
            'guide_number' => 'sometimes|required', 
            'company' => 'sometimes|required', 
            'address_id' => 'sometimes|required',
            'observations' => 'sometimes|required',
            'shipped_at' => 'sometimes|required',
            'delivered_at' => 'sometimes|required',
            'status' => 'required',
        ]);
        
        $shipping->update($attributes);

        return redirect(route('sanson.shipping.index'));
    }
}

<?php

namespace App\Http\Controllers\Coffee;

use App\{Shipping, Address};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingController extends Controller
{
    function index(Request $request, $status)
    {
        $user = auth()->user();
        $date = isset($request->date) ? $request->date: date('Y-m');
        $shippings = Shipping::monthly($date, $user->store_id)
            ->where('status', $status == 'todos' ? '!=': '=', $status)
            ->orderByDesc('id')
            ->get();
        return view('coffee.shippings.index', compact('shippings', 'date', 'status'));
    }

    function monthly(Request $request)
    {
        $user = auth()->user();
        $date = isset($request->date) ? $request->date: date('Y-m');
        $shippings = Shipping::monthly($date, $user->store_id)->get();
        return view('coffee.shippings.monthly', compact('shippings', 'date'));
    }

    function addInfo(Shipping $shipping)
    {
        $addresses = Address::where('client_id', $shipping->ingress->client_id)
            ->where('status', 'active')
            ->selectRaw("id, CONCAT(street,' ', street_number,' ', district,' C.P. ', postcode,' ', city,' ', state) AS address")
            ->pluck('address', 'id')
            ->toArray();

        return view('coffee.shippings.addInfo', compact('addresses', 'shipping'));
    }

    function print(Shipping $shipping)
    {
        return view('coffee.shippings.print', compact('shipping'));
    }

    function edit(Shipping $shipping)
    {
        return view('coffee.shippings.edit', compact('shipping'));
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

        return redirect(route('coffee.shipping.index', 'todos'));
    }
}

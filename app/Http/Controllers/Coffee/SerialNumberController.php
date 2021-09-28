<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{SerialNumber, Product, Ingress};

class SerialNumberController extends Controller
{
    function index()
    {
        $serial_numbers = SerialNumber::whereHas('product', function ($query) {
            $query->where('company', 'COFFEE');
        })
        ->orderBy('purchased_at', 'asc')
        ->get();

        return view('coffee.serial_numbers.index', compact('serial_numbers'));
    }

    function create()
    {
        return view('coffee.serial_numbers.create');       
    }

    function store(Request $request)
    {
        $request->validate([
            'purchased_at' => 'required',
            'purchase_id' => 'required',
            'items' => 'required|array|min:1',
        ]);

        foreach ($request->items as $item) {
            SerialNumber::create([
                'product_id' => $item['product_id'],
                'purchase_id' => $request->purchase_id,
                'number' => $item['number'],
                'purchased_at' => $request->purchased_at,
            ]);
        }

        return redirect(route('coffee.serial_number.index'));
    }

    function show(SerialNumber $serialNumber)
    {
        //
    }

    function edit(SerialNumber $serialNumber)
    {
        //
    }

    function update(Request $request, Ingress $ingress)
    {
        foreach (SerialNumber::find($request->numbers) as $number) {
            $number->update(['ingress_id' => $ingress->id]);
        }

        return redirect(route('coffee.ingress.index'));
    }

    function release(SerialNumber $serialNumber)
    {
        $serialNumber->update($request->validate(['released_at' => 'required']));

        return redirect(route('coffee.serial_number.index'));
    }

    function destroy(SerialNumber $serialNumber)
    {
        //
    }
}

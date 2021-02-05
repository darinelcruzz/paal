<?php

namespace App\Http\Controllers\Coffee;

use App\{SerialNumber, Product, Ingress};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SerialNumberController extends Controller
{
    function index()
    {
        $serial_numbers = SerialNumber::whereHas('ingress', function ($query) {
            $query->where('company', 'COFFEE');
        })->get();

        return view('coffee.serial_numbers.index', compact('serial_numbers'));
    }

    function create(Product $product = null)
    {
        if ($product == null) {
            $product = Product::where('company', 'COFFEE')->where('category', 'EQUIPO')->pluck('description', 'id')->toArray();
        }

        return view('coffee.serial_numbers.create', compact('product'));       
    }

    function store(Request $request, Product $product = null)
    {
        $request->validate([
            'product_id' => 'required',
            'purchase_id' => 'required',
            'numbers' => 'required|array|min:1',
        ]);

        foreach ($request->numbers as $number) {
            SerialNumber::create([
                'product_id' => $request->product_id,
                'purchase_id' => $request->purchase_id,
                'number' => $number,
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
        $i = 0;

        foreach (SerialNumber::find($request->items) as $number) {
            $number->update([
                'number' => $request->numbers[$i],
                'status' => 'vendido'
            ]);
            $i += 1;
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

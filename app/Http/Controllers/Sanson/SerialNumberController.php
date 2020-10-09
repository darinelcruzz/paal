<?php

namespace App\Http\Controllers\Sanson;

use App\{SerialNumber, Product};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SerialNumberController extends Controller
{
    function index()
    {
        $serial_numbers = SerialNumber::all();
        return view('sanson.serial_numbers.index', compact('serial_numbers'));
    }

    function create(Product $product = null)
    {
        if ($product == null) {
            $product = Product::where('company', 'SANSON')->pluck('description', 'id')->toArray();
        }

        return view('sanson.serial_numbers.create', compact('product'));       
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

        return redirect(route('sanson.serial_number.index'));
    }

    function show(SerialNumber $serialNumber)
    {
        //
    }

    function edit(SerialNumber $serialNumber)
    {
        //
    }

    function update(Request $request, SerialNumber $serialNumber)
    {
        //
    }

    function destroy(SerialNumber $serialNumber)
    {
        //
    }
}

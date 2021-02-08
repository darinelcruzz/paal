<?php

namespace App\Http\Controllers\Coffee;

use App\{SerialNumber, Product, Ingress};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SerialNumberController extends Controller
{
    function index()
    {
        $serial_numbers = SerialNumber::whereHas('product', function ($query) {
            $query->where('company', 'COFFEE');
        })->get();

        return view('coffee.serial_numbers.index', compact('serial_numbers'));
    }

    function create()
    {
        return view('coffee.serial_numbers.create');       
    }

    function store(Request $request)
    {
        dd($request->all());
        
        $request->validate([
            'purchased_at' => 'required',
            'items' => 'required|array|min:1',
        ]);

        SerialNumber::createMany($request->items);

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

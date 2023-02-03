<?php

namespace App\Http\Controllers;

use App\SerialNumber;
use Illuminate\Http\Request;

class SerialNumberController extends Controller
{
    function index()
    {
        $serial_numbers = SerialNumber::latest()->orderByDesc('status', 'desc')
            ->get();
        return view('sanson.serial_numbers.index', compact('serial_numbers'));
    }

    function create(Product $product)
    {
        if ($product) {
            $product = Product::where('company', 'SANSON')->pluck('description', 'id')->toArray();
        }

        return view('sanson.serial_numbers.create', compact('product'));       
    }

    function store(Request $request, Product $product == null)
    {
        //
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

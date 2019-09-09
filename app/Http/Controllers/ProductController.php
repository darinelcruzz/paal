<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index($company = 'coffee')
    {
        $conditional = $company == 'coffee' ? '!=': '=';
        $products = Product::where('category', $conditional, 'MBE')->get();
        return view('paal.products.index', compact('products', 'company'));
    }

    function create()
    {
        $families = Product::where('category', '!=', 'MBE')->groupBy('family')->pluck('family', 'family')->toArray();
        return view('paal.products.create', compact('families'));
    }

    function add()
    {
        $families = Product::where('category', 'MBE')->groupBy('family')->pluck('family', 'family')->toArray();
        return view('paal.products.add', compact('families'));
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
            'code' => 'sometimes|required',
            'barcode' => 'sometimes|required',
            'family' => 'required',
            'retail_price' => 'sometimes|required',
            'wholesale_price' => 'sometimes|required|lt:retail_price',
            'wholesale_quantity' => 'sometimes|required',
            'iva' => 'sometimes|required',
        ],[
            'wholesale_price.lt' => 'Precio de mayoreo debe ser menor al de menudeo'
        ]);

        $product = Product::create($request->all());

        switch ($request->options) {
            case 1:
                $product->update([
                    'dollars' => 1,
                    'is_variable' => 1,
                    'iva' => 1,
                ]);
                break;
            
            case 2:
                $product->update([
                    'is_variable' => 1,
                ]);
                break;
        }

        if ($product->category == 'MBE') {
            return redirect(route('paal.product.index', 'mbe'));
        }

        return redirect(route('paal.product.index'));
    }

    function show(Product $product)
    {
        //
    }

    function edit(Product $product)
    {
        $conditional = $product->category == 'MBE' ? '=': '!=';
        $families = Product::where('category', $conditional, 'MBE')->groupBy('family')->pluck('family', 'family')->toArray();
        return view('paal.products.edit', compact('product', 'families'));
    }

    function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'description' => 'required',
            'code' => 'sometimes|required',
            'barcode' => 'sometimes|required',
            'family' => 'required',
            'retail_price' => 'sometimes|required',
            'wholesale_price' => 'sometimes|required|lt:retail_price',
            'wholesale_quantity' => 'sometimes|required',
            'iva' => 'sometimes|required',
        ], [
            'wholesale_price.lt' => 'Precio de mayoreo debe ser menor al de menudeo'
        ]);

        $product->update($request->all());

        if ($product->category == 'MBE') {
            return redirect(route('paal.product.index', 'mbe'));
        }

        return redirect(route('paal.product.index'));
    }

    function axios(Product $product)
    {
        return response($product, 200);
    }

    function destroy(Product $product)
    {
        //
    }
}

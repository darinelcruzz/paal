<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index()
    {
        $products = Product::all();
        return view('paal.products.index', compact('products'));
    }

    function create()
    {
        return view('paal.products.create');
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
            'code' => 'required',
            'family' => 'required',
            'retail_price' => 'required',
            'wholesale_price' => 'required|lt:retail_price',
            'wholesale_quantity' => 'required',
        ],[
            'wholesale_price.lt' => 'Precio de mayoreo debe ser menor al de menudeo'
        ]);

        $product = Product::create($request->all());

        return redirect(route('paal.product.index'));
    }

    function show(Product $product)
    {
        //
    }

    function edit(Product $product)
    {
        return view('paal.products.edit', compact('product'));
    }

    function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'description' => 'required',
            'code' => 'required',
            'family' => 'required',
            'retail_price' => 'required',
            'wholesale_price' => 'required|lt:retail_price',
            'wholesale_quantity' => 'required',
        ], [
            'wholesale_price.lt' => 'Precio de mayoreo debe ser menor al de menudeo'
        ]);

        $product->update($request->all());

        return redirect(route('paal.product.index'));
    }

    function axios()
    {
        $products = Product::orderBy('description')->get();
        return response($products, 200);
    }

    function destroy(Product $product)
    {
        //
    }
}

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
            'retail_price' => 'required',
            'wholesale_price' => 'required',
            'wholesale_quantity' => 'required',
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
            'retail_price' => 'required',
            'wholesale_price' => 'required',
            'wholesale_quantity' => 'required',
        ]);

        $product->update($request->all());

        return redirect(route('paal.product.index'));
    }

    function destroy(Product $product)
    {
        //
    }
}

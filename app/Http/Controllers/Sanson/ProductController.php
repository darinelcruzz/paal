<?php

namespace App\Http\Controllers\Sanson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Alert;
use App\Notifications\ProductPriceChanged;

class ProductController extends Controller
{
    function index()
    {
        $products = Product::whereCompany('sanson')->get();
        return view('sanson.products.index', compact('products'));
    }

    function create()
    {
        return view('sanson.products.create');
    }

    function store(Request $request)
    {
        $attributes = $request->validate([
            'description' => 'required',
            'code' => 'required',
            'barcode' => 'required',
            'family' => 'required',
            'iva' => 'required',
            'retail_price' => 'required',
            'dollars' => 'required',
            'company' => 'required',
        ]);

        $product = Product::create($attributes);

        return redirect(route('sanson.product.index'));
    }

    function edit(Product $product)
    {
        return view('sanson.products.edit', compact('product'));
    }

    function update(Request $request, Product $product)
    {
        $attributes = $request->validate([
            'description' => 'required',
            'code' => 'required',
            'barcode' => 'required',
            'family' => 'required',
            'iva' => 'required',
            'retail_price' => 'required',
            'dollars' => 'required',
            'company' => 'required',
        ]);

        $product->update($attributes);

        return redirect(route('sanson.product.index'));
    }
}

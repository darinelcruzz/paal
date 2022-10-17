<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Alert;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\ProductPriceChanged;

class ProductController extends Controller
{
    function index()
    {
        $products = Product::query()
            ->select('id', 'description', 'type', 'code', 'category', 'family', 'dollars', 'retail_price', 'wholesale_price')
            ->where('company', '!=', 'mbe')
            ->where('status', 'activo')
            ->get();
        return view('coffee.products.index', compact('products'));
    }

    function create()
    {
        $categories = Product::where('company', '!=', 'mbe')->groupBy('category')->pluck('category', 'category')->toArray();
        $families = Product::where('company', '!=', 'mbe')->get()->groupBy(['category', 'family']);
        // dd($families['ACCESORIOS']);
        return view('coffee.products.create', compact('families', 'categories'));
    }

    function store(Request $request)
    {
        $attributes = $request->validate([
            'description' => 'required',
            'code' => 'required',
            'barcode' => 'required',
            'family' => 'required',
            'category' => 'required',
            'iva' => 'required',
            'retail_price' => 'required',
            'wholesale_price' => 'sometimes|required',
            'wholesale_quantity' => 'sometimes|required',
            'dollars' => 'required',
            'is_variable' => 'required',
            'company' => 'required',
            'type' => 'required',
        ]);


        $product = Product::create($attributes);
        $wsp = $product->wholesale_price == 0 ? $product->retail_price: $product->wholesale_price;
        $product->update(['wholesale_price' => $wsp]);

        return redirect(route('coffee.product.index'));
    }

    function edit(Product $product)
    {
        return view('coffee.products.edit', compact('product'));
    }

    function export() 
    {
        return Excel::download(new ProductsExport('coffee'), 'PRODUCTOS_' . date('d-m-y_his') . '.xlsx');
    }

    function import(Request $request) 
    {
        Excel::import(new ProductsImport, $request->file('products'));
        return redirect(route('coffee.product.index'));
    }

    function serialize(Product $product)
    {
        $product->update(['is_seriable' => 1]);

        return back();
    }

    function update(Request $request, Product $product)
    {
        $request->validate([
            'retail_price' => 'required',
            'wholesale_price' => 'sometimes|required',
        ]);

        $wsp = $request->wholesale_price == 0 ? $request->retail_price: $request->wholesale_price;

        $product->update($request->all() + ['wholesale_price' => $wsp]);

        return redirect(route('coffee.product.index'));
    }
}

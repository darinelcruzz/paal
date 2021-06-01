<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Product, Purchase, Movement};

class PureMixController extends Controller
{
    function index()
    {
        $products = Product::whereCompany('coffee')->where('description', 'like', 'PURE%')->get();
        return view('coffee.products.puremix.index', compact('products'));
    }

    function store(Request $request)
    {
        $attributes = $request->validate([
            'provider_id' => 'required',
            'purchased_at' => 'required',
            'company' => 'required',
            'user_id' => 'required',
            'order_id' => 'required',
            'amount' => 'required',
            'folio' => 'required',
        ]);

        Purchase::create($attributes);

        return redirect(route('coffee.product.puremix.index'));
    }

    function search(Request $request)
    {
        $attributes = $request->validate([
            'product_id' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);

        $from = $request->from;
        $to = $request->to;
        $product_id = $request->product_id;


        $sproduct = Product::find($product_id);

        $count = Movement::where('product_id', $product_id)
            ->where('movable_type', 'App\Ingress')
            ->whereBetween('created_at', [$from, $to])
            ->count();

        $products = Product::whereCompany('coffee')->where('description', 'like', 'PURE%')->get();
        return view('coffee.products.puremix.index', compact('products', 'count', 'from', 'to', 'sproduct'));
    }
}

<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Product, Purchase};

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
}

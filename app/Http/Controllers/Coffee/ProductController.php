<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Alert;

class ProductController extends Controller
{
    function index()
    {
        $products = Product::all();
        return view('coffee.products.index', compact('products'));
    }

    function edit(Product $product)
    {
        return view('coffee.products.edit', compact('product'));
    }

    function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'retail_price' => 'required',
            'wholesale_price' => 'sometimes|required',
        ]);

        if (isset($request->wholesale_price)) {
            
            $r_old = $product->retail_price;
            $w_old = $product->wholesale_price;
            
            $product->update($validated);

            Alert::success( 
                "Precio menudeo de $" . number_format($r_old, 2) . " a $" . number_format($product->retail_price, 2) . ".\n Precio mayoreo de $" . number_format($w_old, 2) . " a $" . number_format($product->wholesale_price, 2),
                'Precios modificados')
                ->persistent('Cerrar');

        } else {
            
            $old = $product->retail_price;
            $product->update($validated + ['wholesale_price' => $request->retail_price]);
            
            Alert::success("El precio se cambió de $" . number_format($old, 2) . " a $" . number_format($product->retail_price, 2), 'Precio modificado')->persistent('Cerrar');
        }


        return redirect(route('coffee.product.edit', $product));
    }
}

<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Alert;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\ProductPriceChanged;

class ProductController extends Controller
{
    function index()
    {
        $products = Product::whereCompany('coffee')->get();
        return view('coffee.products.index', compact('products'));
    }

    function create()
    {
        $categories = Product::where('company', 'COFFEE')->groupBy('category')->pluck('category', 'category')->toArray();
        $families = Product::where('company', 'COFFEE')->get()->groupBy(['category', 'family']);
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
        ]);

        $product = Product::create($attributes);

        if ($product->iva == 1) {
            $product->update([
                'retail_price' => $product->retail_price * 1.16,
                'wholesale_price' => $product->wholesale_price * 1.16,
            ]);
        }

        return redirect(route('coffee.product.index'));
    }

    function edit(Product $product)
    {
        return view('coffee.products.edit', compact('product'));
    }

    public function export() 
    {
        return Excel::download(new ProductsExport, 'PRODUCTOS_' . date('d-m-y_his') . '.xlsx');
    }

    function serialize(Product $product)
    {
        $product->update(['is_seriable' => 1]);

        return back();
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

            // $product->notify(new ProductPriceChanged(auth()->user()->name, [$r_old, $w_old]));

        } else {
            
            $old = $product->retail_price;
            $product->update($validated + ['wholesale_price' => $request->retail_price]);
            
            Alert::success("El precio se cambió de $" . number_format($old, 2) . " a $" . number_format($product->retail_price, 2), 'Precio modificado')->persistent('Cerrar');
            
            // $product->notify(new ProductPriceChanged(auth()->user()->name, $old));
        }



        return redirect(route('coffee.product.edit', $product));
    }
}

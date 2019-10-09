<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Ingress;

class InvoiceController extends Controller 
{
	function create(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required',
            'xml' => 'required'
        ]);
        
        $path = Storage::putFileAs(
            "public/coffee/invoices", $request->file('xml'), "$request->invoice_id.xml"
        );
        
        foreach (Ingress::find($request->sales) as $sale) {
            $sale->update($request->only('invoice_id'));
        }

        return redirect(route('coffee.admin.daily', $sale->route_method));
    }
}
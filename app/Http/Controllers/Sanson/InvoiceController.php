<?php

namespace App\Http\Controllers\Sanson;

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
            'sales' => 'required',
            // 'xml' => 'required'
        ]);

        if ($request->file('xml')) {
            $path = Storage::putFileAs(
                "public/coffee/invoices", $request->file('xml'), "$request->invoice_id.xml"
            );
        }
        
        foreach (Ingress::find($request->sales) as $sale) {
            $sale->update($request->only('invoice_id'));
        }

        return redirect(route('sanson.admin.daily', [$sale->route_method, $request->thisDate]));
    }
}
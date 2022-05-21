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
        // dd($request->all());
        $validated = $request->validate([
            'invoice_id' => 'required_if:pinvoice_id,null',
            'pinvoice_id' => 'required_if:invoice_id,null',
            // 'xml' => 'required_with:invoice_id',
            // 'pi_xml' => 'required_with:pinvoice_id'
        ]);
        
        if ($request->file('xml')) {
            Storage::putFileAs(
                "public/coffee/invoices", $request->file('xml'), "$request->invoice_id.xml"
            );
        }

        if ($request->file('pi_xml')) {
            Storage::putFileAs(
                "public/coffee/invoices", $request->file('pi_xml'), "pi_$request->pinvoice_id.xml"
            );
        }
        
        foreach (Ingress::find($request->sales) as $sale) {
            $sale->update($request->only('invoice_id', 'pinvoice_id', 'pi_amount'));
        }

        return redirect(route('coffee.admin.daily', [$sale->route_method, $request->thisDate]));
    }
}

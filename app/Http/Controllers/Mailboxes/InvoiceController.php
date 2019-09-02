<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\{Ingress, Payment};

class InvoiceController extends Controller 
{
    function index(Request $request)
    {
        return view('mbe.coming_soon');
        $date = dateFromRequest();

        $total = Payment::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->whereNull('cash_reference')
            ->whereHas('ingress', function($query) {
                $query->where('status', '!=', 'cancelado')
                    ->where('company', 'coffee')
                    ->where('invoice_id', '!=', null);
            })
            ->sum('cash');

        $invoices = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->where('company', 'mbe')
            ->get()
            ->groupBy('invoice_id');

        $canceled = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $date)
            ->where('status', 'cancelado')
            ->where('company', 'mbe')
            ->get()
            ->groupBy('invoice_id');

        return view('mbe.invoices.index', compact('invoices', 'date', 'total', 'canceled'));
    }

	function create(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required',
            'xml' => 'required'
        ]);
        
        $path = Storage::putFileAs(
            "public/mbe/invoices", $request->file('xml'), "$request->invoice_id.xml"
        );
        
        foreach (Ingress::find($request->sales) as $sale) {
            $sale->update($request->only('invoice_id'));
        }

        return redirect(route('mbe.ingress.index', 'factura'))->with('redirected', session('date'));
    }
}
<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\{Ingress, Payment};

class InvoiceController extends Controller 
{
    function index(Request $request, $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest(): $thisDate;

        $total = Payment::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->whereNull('cash_reference')
            ->whereHas('ingress', function($query) {
                $query->where('status', '!=', 'cancelado')
                    ->where('company', 'mbe')
                    ->where('invoice_id', '!=', null);
            })
            ->sum('cash');

        $invoices = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $date)
            ->where('company', 'mbe')
            ->get()
            ->groupBy('invoice_id');

        return view('mbe.invoices.index', compact('invoices', 'date', 'total'));
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

        return redirect(route('mbe.ingress.daily', [$sale->route_method, $request->thisDate]));
    }

    function print($date)
    {
        $invoices = Ingress::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->where('invoice_id', '!=', null)
            ->where('status', '!=', 'cancelado')
            ->where('company', 'mbe')
            ->whereHas('payments', function($query) {
                $query->whereNull('cash_reference');
            })
            ->selectRaw('id, client_id, iva, amount, invoice_id, DATE_FORMAT(created_at, "%Y-%m-%d") as date')
            ->with(['client:id,name', 'payments'])
            ->get()
            ->groupBy('date');

        return view('mbe.invoices.print', compact('invoices'));
    }
}
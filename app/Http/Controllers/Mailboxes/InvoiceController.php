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

        $deposit = Payment::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->where('cash', '>', 0)
            ->where('cash_reference', '0000')
            ->whereHas('ingress', function ($query)
            {
                $query->where('status', '!=', 'cancelado')
                    ->where('company', 'mbe');
            })
            ->sum('cash');


        $cash_invoices = Ingress::where('invoice_id', '!=', null)
            ->whereDate('bought_at', $date)
            ->where('company', 'mbe')
            ->where('method', 'efectivo')
            ->where('status', '!=', 'cancelado')
            ->get()
            ->groupBy('invoice_id');

        $invoices = Ingress::where('invoice_id', '!=', null)
            ->whereDate('invoiced_at', $date)
            ->where('company', 'mbe')
            ->where('method', '!=', 'efectivo')
            ->where('status', '!=', 'cancelado')
            ->get()
            ->groupBy('invoice_id');

        return view('mbe.invoices.index', compact('cash_invoices', 'invoices', 'date', 'deposit'));
    }

    function pending()
    {
        $invoices = Ingress::where('invoice_id', '!=', null)
            ->where('company', 'mbe')
            ->where('client_id', '>', 627)
            ->where('complement', null)
            ->get()
            ->groupBy('invoice_id');

        $completed = Ingress::where('invoice_id', '!=', null)
            ->where('company', 'mbe')
            ->where('client_id', '>', 627)
            ->where('complement', '!=', null)
            ->get()
            ->groupBy('invoice_id');

        return view('mbe.invoices.pending', compact('invoices', 'completed'));
    }

    function update(Request $request, Ingress $ingress)
    {
        $validated = $request->validate([
            'xml' => 'required',
        ]);

        $path = Storage::putFileAs(
            "public/mbe/invoices", $request->file('xml'), "$ingress->invoice_id.xml"
        );

        $ingress->payments()->update(['cash_reference' => '0000']);

        return redirect(route('mbe.ingress.daily', [$ingress->route_method, $request->thisDate]));
    }

    function complement(Request $request)
    {
        $validated = $request->validate([
            'xml' => 'required',
        ]);

        $path = Storage::putFileAs(
            "public/mbe/complements", $request->file('xml'), "$request->invoice_id.xml"
        );

        foreach (Ingress::find($request->sales) as $sale) {
            $sale->update(['complement' => $path]);
        }

        return redirect(route('mbe.invoice.pending'));
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
        $invoices = Ingress::whereYear('bought_at', substr($date, 0, 4))
            ->whereMonth('bought_at', substr($date, 5))
            ->where('invoice_id', '!=', null)
            ->where('status', '!=', 'cancelado')
            ->where('company', 'mbe')
            ->whereHas('payments', function($query) {
                $query->where('cash_reference', '0000')
                    ->orWhere('cash_reference', null);
            })
            ->selectRaw('id, client_id, iva, amount, invoice_id, DATE_FORMAT(bought_at, "%Y-%m-%d") as date')
            ->with(['client:id,name', 'payments'])
            ->get()
            ->groupBy('date');

        return view('mbe.invoices.print', compact('invoices'));
    }
}

<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Ingress, Payment};

class AdminController extends Controller
{
    function index(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m-d');

        $payments = Payment::whereDate('created_at', $date)
            ->whereHas('ingress', function($query) {
                $query->where('status', '!=', 'cancelado');
            });

        $deposits = Payment::whereDate('created_at', $date)
            ->whereHas('ingress', function($query) {
                $query->where('status', '!=', 'cancelado');
            })
            ->where('type', '!=', 'contado')->get();

        $month = Payment::whereMonth('created_at', substr($date, 5, 2))
            ->whereHas('ingress', function($query) {
                $query->where('status', '!=', 'cancelado');
            });

        $invoiced = Ingress::whereDate('created_at', $date)
            ->where('invoice', '!=', 'no')
            ->where('status', '!=', 'cancelado')
            ->where('retainer', 0)
            ->get();

        $paid = Ingress::whereDate('created_at', $date)
            ->where('invoice', 'no')
            ->where('status', '!=', 'cancelado')
            ->where('retainer', 0)
            ->get();

        return view('coffee.admin.index', compact('payments', 'paid', 'invoiced', 'deposits', 'date', 'month'));
    }

    function monthly(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $month = Payment::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->whereHas('ingress', function($query) {
                $query->where('status', '!=', 'cancelado');
            });

        $pending = Payment::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->whereNull('reference')
            ->whereHas('ingress', function($query) {
                $query->where('status', '!=', 'cancelado');
            });

        return view('coffee.admin.monthly', compact('date', 'month', 'pending'));
    }

    function invoices(Request $request)
    {
        // $date = isset($request->date) ? $request->date: date('Y-m');

        $invoices = Ingress::where('invoice_id', '!=', null)
            // ->whereMonth('created_at', substr($date, 5))
            // ->whereYear('created_at', substr($date, 0, 4))
            ->get()
            ->groupBy('invoice_id');

        // return view('coffee.admin.invoices', compact('invoices', 'date'));
        return view('coffee.admin.invoices', compact('invoices'));
    }

    function reference(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required',
        ]);
        
        foreach (Ingress::find($request->sales) as $sale) {            
            $payment = Payment::where('ingress_id', $sale->id)->first();
            $payment->update($request->only('reference'));
        }

        return redirect(route('coffee.admin.invoices'));
    }
}

<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\{Ingress, Payment, Shipping};
use App\Exports\DailyPendingExport;

class AdminController extends Controller
{
    function index(Request $request)
    {
        if (session('redirected')) {
            $date = session('redirected');
        } else {
            $date = isset($request->date) ? $request->date: date('Y-m-d');
            session()->put('date', $date);
        }

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

        $working_days = $month->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date')->get()->groupBy('date')->count();

        $pending = Payment::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->whereNull('cash_reference')
            ->whereHas('ingress', function($query) {
                $query->where('status', '!=', 'cancelado');
            })
            ->sum('cash');

        $shippings = Shipping::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->count();

        return view('coffee.admin.monthly', compact('date', 'month', 'pending', 'working_days', 'shippings'));
    }

    function invoices(Request $request)
    {
        if (session('redirected')) {
            $date = session('redirected');
        } else {
            $date = isset($request->date) ? $request->date: date('Y-m-d');
            session()->put('date', $date);
        }

        $total = Payment::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->whereNull('cash_reference')
            ->whereHas('ingress', function($query) {
                $query->where('status', '!=', 'cancelado')
                    ->where('invoice_id', '!=', null);
            })
            ->sum('cash');

        $invoices = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $date)
            ->get()
            ->groupBy('invoice_id');

        return view('coffee.admin.invoices', compact('invoices', 'date', 'total'));
    }

    function reference(Request $request)
    {
        $validated = $request->validate([
            'cash_reference' => 'required',
        ]);
        
        foreach (Ingress::find($request->sales) as $sale) {            
            $payment = Payment::where('ingress_id', $sale->id)->first();
            $payment->update($request->only('cash_reference'));
        }

        return redirect(route('coffee.admin.invoices'))->with('redirected', session('date'));
    }

    function downloadExcel($date)
    {
        return Excel::download(new DailyPendingExport($date), "PENDIENTE_$date.xlsx");
    }

    function printDeposits($date)
    {        
        $invoices = Ingress::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->where('invoice_id', '!=', null)
            ->whereHas('payments', function($query) {
                $query->whereNull('cash_reference');
            })
            ->selectRaw('id, client_id, iva, amount, invoice_id, DATE_FORMAT(created_at, "%Y-%m-%d") as date')
            ->with(['client:id,name', 'payments'])
            ->get()
            ->groupBy('date');

        return view('coffee.admin.invoices_print', compact('invoices'));
    }
}

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
        $date = $this->getDate();

        $payments = Payment::from($date);

        $deposits = Payment::from($date)->where('type', '!=', 'contado')->get();

        $invoiced = Ingress::from($date)->where('invoice', '!=', 'no')->get();

        $paid = Ingress::from($date)->where('invoice', 'no')->get();

        return view('coffee.admin.index', compact('payments', 'paid', 'invoiced', 'deposits', 'date'));
    }

    function monthly(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $shippings = Shipping::monthly($date);

        $month = Payment::monthly($date);

        $working_days = $month->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date')->get()->groupBy('date')->count();

        $pending = Payment::monthly($date)->whereNull('cash_reference')->sum('cash');

        return view('coffee.admin.monthly', compact('date', 'month', 'pending', 'working_days', 'shippings'));
    }

    function invoices(Request $request)
    {
        $date = $this->getDate();

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

    function getDate()
    {
        if (session('redirected')) {
            return session('redirected');
        } else {
            $date = null !== request('date') ? request('date'): date('Y-m-d');
            session()->put('date', $date);
            return $date;
        }
    }
}

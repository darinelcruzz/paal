<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\{Ingress, Payment, Shipping};
use App\Exports\DailyPendingExport;

class AdminController extends Controller
{
    function daily(Request $request, $status = 'factura')
    {
        $date = dateFromRequest();

        $ingresses = Ingress::whereDate('created_at', $date)
            ->whereCompany('coffee')
            ->where($this->getConditions($status))
            ->get();

        $payments = Payment::from($date);

        $color = ['factura' => 'primary', 'efectivo' => 'success', 'tarjeta' => 'warning', 'transferencia' => 'info'][$status];

        return view('coffee.admin.daily', compact('date', 'ingresses', 'status', 'color', 'payments'));
    }

    function index(Request $request)
    {
        $date = $this->getDate();

        $payments = Payment::from($date);

        $deposits = Payment::from($date)->where('type', '!=', 'contado')->get();

        $invoiced = Ingress::from($date)->whereCompany('coffee')->where('invoice', '!=', 'no')->get();

        $paid = Ingress::from($date)->whereCompany('coffee')->where('invoice', 'no')->get();

        return view('coffee.admin.index', compact('payments', 'paid', 'invoiced', 'deposits', 'date'));
    }

    function monthly(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $shippings = Shipping::monthly($date);

        $month = Payment::monthly($date);

        $working_days = $month->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date')->get()->groupBy('date')->count();

        $working_days = $working_days == 0 ? 1: $working_days;

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
                    ->where('company', 'coffee')
                    ->where('invoice_id', '!=', null);
            })
            ->sum('cash');

        $invoices = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->where('company', 'coffee')
            ->get()
            ->groupBy('invoice_id');

        $canceled = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $date)
            ->where('status', 'cancelado')
            ->where('company', 'coffee')
            ->get()
            ->groupBy('invoice_id');

        return view('coffee.admin.invoices', compact('invoices', 'date', 'total', 'canceled'));
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
            ->where('status', '!=', 'cancelado')
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

    function getConditions($value)
    {
        if ($value == 'factura') {
            return [
                ['invoice', '!=', 'no']
            ];
        } else {
            return [
                ['invoice', '=', 'no'],
                ['method', 'LIKE', "%$value%"]
            ];
        }
    }
}

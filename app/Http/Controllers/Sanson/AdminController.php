<?php

namespace App\Http\Controllers\Sanson;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\{Ingress, Payment, Shipping, Movement};
use App\Exports\DailyPendingExport;

class AdminController extends Controller
{
    function daily(Request $request, $status = 'factura', $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest(): $thisDate;

        $ingresses = Ingress::whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->whereCompany('sanson')
            ->when($status == 'factura', function ($query) {
                $query->where('invoice', '!=', 'no');
            }, function ($query) use ($status) {
                $query->where('invoice', 'no')->where('method', 'like', "%$status%");
            })
            ->with('payments', 'movements.product')
            ->get();

        $payments = Ingress::whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->whereCompany('sanson')
            ->with('payments')
            ->get();

        $color = ['factura' => 'primary', 'efectivo' => 'success', 'tarjeta' => 'warning', 'transferencia' => 'info'][$status];

        return view('sanson.admin.daily', compact('date', 'ingresses', 'status', 'color', 'payments'));
    }

    function index(Request $request)
    {
        $date = $this->getDate();

        $payments = Payment::from($date);

        $deposits = Payment::from($date)->where('type', '!=', 'contado')->get();

        $invoiced = Ingress::from($date)->whereCompany('sanson')->where('invoice', '!=', 'no')->get();

        $paid = Ingress::from($date)->whereCompany('sanson')->where('invoice', 'no')->get();

        return view('sanson.admin.index', compact('payments', 'paid', 'invoiced', 'deposits', 'date'));
    }

    // function monthly(Request $request)
    // {
    //     $date = isset($request->date) ? $request->date: date('Y-m');

    //     $shippings = Shipping::monthly($date, 'sanson');

    //     $month = Payment::monthly($date, 'sanson');

    //     $working_days = $month->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date')->get()->groupBy('date')->count();

    //     $working_days = $working_days == 0 ? 1: $working_days;

    //     $pending = Payment::monthly($date, 'sanson')->whereNull('cash_reference')->sum('cash');

    //     $project = Ingress::monthly($date, 'sanson')->where('type', 'proyecto')->sum('amount');
    //     $equipment = Ingress::monthly($date, 'sanson')->where('type', 'equipo')->sum('amount');
        
    //     $imbera = Movement::monthly($date, 'sanson', 'IMBERA')->sum('total');
    //     $rhino = Movement::monthly($date, 'sanson', 'RHINO')->sum('total');
    //     $sanson_equipment = Movement::monthly($date, 'sanson', 'EQUIPOS SANSON')->sum('total');
    //     $refactions = Movement::monthly($date, 'sanson', 'REFACCIONES SANSON')->sum('total');

    //     return view('sanson.admin.monthly', compact('date', 'month', 'pending', 'working_days', 'shippings', 'project', 'equipment', 'imbera', 'rhino', 'sanson_equipment', 'refactions'));
    // }

    function monthly(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $ingresses = Ingress::where('company', 'sanson')
            ->where('status', '!=', 'cancelado')
            ->whereMonth('bought_at', substr($date, 5, 7))
            ->whereYear('bought_at', substr($date, 0, 4))
            ->with('payments', 'movements.product')
            ->get();

        $shippings = Shipping::monthly($date)->count();

        $imbera = Movement::monthly($date, 'sanson', 'IMBERA')->sum('total');
        $rhino = Movement::monthly($date, 'sanson', 'RHINO')->sum('total');
        $equipment = Movement::monthly($date, 'sanson', 'EQUIPOS SANSON')->sum('total');
        $refactions = Movement::monthly($date, 'sanson', 'REFACCIONES SANSON')->sum('total');

        return view('sanson.admin.monthly', compact('date', 'ingresses', 'shippings', 'imbera', 'rhino', 'equipment', 'refactions'));
    }

    function invoices(Request $request, $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest(): $thisDate;

        $invoices = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->where('company', 'sanson')
            ->with('payments', 'movements.product')
            ->get();

        $deposits = Ingress::where('company', 'sanson')
            ->where('status', '!=', 'cancelado')
            ->whereMonth('created_at', substr($date, 5, 2))
            ->whereYear('created_at', substr($date, 0, 4))
            ->with('payments')
            ->get()
            ->sum(function ($item)
            {
                return $item->payments->where('cash_reference', null)->sum('cash');
            });

        $canceled = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $date)
            ->where('status', 'cancelado')
            ->where('company', 'sanson')
            ->get()
            ->groupBy('invoice_id');

        return view('sanson.admin.invoices', compact('invoices', 'date', 'deposits', 'canceled'));
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

        return redirect(route('sanson.admin.invoices', $request->thisDate));
    }

    function downloadExcel($date)
    {
        return Excel::download(new DailyPendingExport($date), "PENDIENTE_$date.xlsx");
    }

    function printDeposits($date)
    {
        $invoices = Ingress::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5, 2))
            ->where('invoice_id', '!=', null)
            ->where('status', '!=', 'cancelado')
            ->where('company', 'sanson')
            ->whereHas('payments', function($query) {
                $query->whereNull('cash_reference');
            })
            ->selectRaw('id, client_id, iva, amount, invoice_id, DATE_FORMAT(created_at, "%Y-%m-%d") as date')
            ->with(['client:id,name', 'payments'])
            ->get()
            ->groupBy('date');

        return view('sanson.admin.invoices_print', compact('invoices'));
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

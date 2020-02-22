<?php

namespace App\Http\Controllers\Sanson;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\{Ingress, Payment, Shipping, IngressMovement};
use App\Exports\DailyPendingExport;

class AdminController extends Controller
{
    function daily(Request $request, $status = 'factura', $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest(): $thisDate;

        $ingresses = Ingress::whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->whereCompany('sanson')
            ->where($this->getConditions($status))
            ->get();

        $payments = Payment::from($date, 'sanson');

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

    function monthly(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $shippings = Shipping::monthly($date, 'sanson');

        $month = Payment::monthly($date, 'sanson');

        $working_days = $month->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date')->get()->groupBy('date')->count();

        $working_days = $working_days == 0 ? 1: $working_days;

        $pending = Payment::monthly($date, 'sanson')->whereNull('cash_reference')->sum('cash');

        $project = Ingress::monthly($date, 'sanson')->where('type', 'proyecto')->sum('amount');
        $equipment = Ingress::monthly($date, 'sanson')->where('type', 'equipo')->sum('amount');
        
        $imbera = IngressMovement::monthly($date, 'sanson', 'IMBERA')->sum('total');
        $rhino = IngressMovement::monthly($date, 'sanson', 'RHINO')->sum('total');
        $sanson_equipment = IngressMovement::monthly($date, 'sanson', 'EQUIPOS SANSON')->sum('total');
        $refactions = IngressMovement::monthly($date, 'sanson', 'REFACCIONES SANSON')->sum('total');

        return view('sanson.admin.monthly', compact('date', 'month', 'pending', 'working_days', 'shippings', 'project', 'equipment', 'imbera', 'rhino', 'sanson_equipment', 'refactions'));
    }

    function invoices(Request $request, $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest(): $thisDate;

        $total = Payment::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->whereNull('cash_reference')
            ->whereHas('ingress', function($query) {
                $query->where('status', '!=', 'cancelado')
                    ->where('company', 'sanson')
                    ->where('invoice_id', '!=', null);
            })
            ->sum('cash');

        $invoices = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->where('company', 'sanson')
            ->get()
            ->groupBy('invoice_id');

        $canceled = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $date)
            ->where('status', 'cancelado')
            ->where('company', 'sanson')
            ->get()
            ->groupBy('invoice_id');

        return view('sanson.admin.invoices', compact('invoices', 'date', 'total', 'canceled'));
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
            ->whereMonth('created_at', substr($date, 5))
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

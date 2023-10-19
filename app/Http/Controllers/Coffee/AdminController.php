<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\{Ingress, Payment, Shipping};
use App\Exports\DailyPendingExport;

class AdminController extends Controller
{
    function daily(Request $request, $status = 'factura', $thisDate = null)
    {
        $user = auth()->user();
        $date = $thisDate == null ? dateFromRequest(): $thisDate;

        $ingresses = Ingress::whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->whereStoreId($user->store_id)
            ->when($status == 'factura', function ($query) {
                $query->where('invoice', '!=', 'no');
            }, function ($query) use ($status) {
                $query->where('invoice', 'no')->where('method', 'like', "%$status%");
            })
            ->with('payments', 'movements.product')
            ->get();

        $payments = Ingress::whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->whereStoreId($user->store_id)
            ->with('payments')
            ->get();

        $notes = $ingresses->where('invoice', 'G02')->sum('amount');

        $color = ['factura' => 'primary', 'efectivo' => 'success', 'tarjeta' => 'warning', 'transferencia' => 'info'][$status];

        return view('coffee.admin.daily', compact('date', 'ingresses', 'status', 'color', 'payments', 'notes'));
    }

    function index(Request $request)
    {
        $user = auth()->user();
        $date = $this->getDate();

        $payments = Payment::from($date);

        $deposits = Payment::from($date)->where('type', '!=', 'contado')->get();

        $invoiced = Ingress::from($date)->whereStoreId($user->store_id)->where('invoice', '!=', 'no')->get();

        $paid = Ingress::from($date)->whereStoreId($user->store_id)->where('invoice', 'no')->get();

        return view('coffee.admin.index', compact('payments', 'paid', 'invoiced', 'deposits', 'date'));
    }

    function monthly(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');
        return view('coffee.admin.monthly', compact('date'));
    }

    function invoices(Request $request, $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest(): $thisDate;
        $user = auth()->user();

        $invoices = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->whereStoreId($user->store_id)
            ->with('payments', 'movements.product')
            ->get();


        $pinvoices = Ingress::where('pinvoice_id', '!=', null)
            ->where('invoice_id', null)
            ->whereDate('created_at', $date)
            ->where('status', '!=', 'cancelado')
            ->whereStoreId($user->store_id)
            ->with('payments', 'movements.product')
            ->get();

        $deposits = Ingress::whereStoreId($user->store_id)
            ->where('status', '!=', 'cancelado')
            ->whereMonth('created_at', substr($date, 5, 2))
            ->whereYear('created_at', substr($date, 0, 4))
            // ->where('invoice_id', null)
            ->with('payments')
            ->get()
            ->sum(function ($item)
            {
                return $item->payments->where('cash_reference', null)->sum('cash');
            });

        $canceled = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $date)
            ->where('status', 'cancelado')
            ->whereStoreId($user->store_id)
            ->get()
            ->groupBy('invoice_id');

        return view('coffee.admin.invoices', compact('pinvoices', 'invoices', 'date', 'canceled', 'deposits'));
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

        return redirect(route('coffee.admin.invoices', $request->thisDate));
    }

    function downloadExcel($date)
    {
        return Excel::download(new DailyPendingExport($date), "PENDIENTE_$date.xlsx");
    }

    function printDeposits($date)
    {
        $user = auth()->user();

        $invoices = Ingress::where(function ($query) use ($date, $user) {
                $query->whereYear('created_at', substr($date, 0, 4))
                ->whereMonth('created_at', substr($date, 5, 2))
                ->where('invoice_id', '!=', null)
                ->where('status', '!=', 'cancelado')
                ->whereStoreId($user->store_id)
                ->whereHas('payments', function($query) {
                    $query->whereNull('cash_reference');
                });
            })
            ->orWhere(function ($query) use ($date, $user) {
                $query->whereYear('created_at', substr($date, 0, 4))
                ->whereMonth('created_at', substr($date, 5, 2))
                ->where('pinvoice_id', '!=', null)
                ->where('status', '!=', 'cancelado')
                ->whereStoreId($user->store_id)
                ->whereHas('payments', function($query) {
                    $query->whereNull('cash_reference');
                });
            })
            ->selectRaw('id, client_id, iva, amount, DATE_FORMAT(created_at, "%Y-%m-%d") as date')
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

<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Client, Payment, Product};

class AdminController extends Controller
{
	function daily(Request $request, $status = 'factura', $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest(): $thisDate;

        $ingresses = Ingress::whereDate('bought_at', $date)
            ->whereCompany('mbe')
			->where('status', '!=', 'cancelado')
            ->where('status', '!=', 'crédito')
            ->where($this->getConditions($status))
            ->get();

        $ingresses_to_filter = Ingress::whereDate('bought_at', $date)
            ->where('status', '!=', 'crédito')
            ->where('status', '!=', 'cancelado')
            ->whereCompany('mbe')->get();

        $color = 'success';

        return view('mbe.admin.daily', compact('date', 'ingresses', 'status', 'color', 'ingresses_to_filter'));
    }

    function monthly(Request $request)
    {
        $date = dateFromRequest('Y-m');

        $ingresses = Ingress::where('company', 'mbe')
            ->where('status', '!=', 'cancelado')
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->with('payments')
            ->get();

        $shippings = $this->getShippingsTotal($date);

        $checkout = $ingresses->where('status', 'pagado')->where('invoiced_at', null)->sum('amount');
        $credit = $ingresses->where('status', 'crédito')->where('invoiced_at', null)->sum('amount');
        $invoiced = $ingresses->where('invoiced_at', '!=', null)->sum('amount');
        $paid = $ingresses->where('paid_at', '!=', null)->sum('amount');

        $pending = $ingresses->where('invoice_id', '!=', null)->sum(function ($ingress) { return $ingress->payments->where('cash_reference', '0000')->sum('cash');});

        return view('mbe.admin.monthly', compact('date', 'ingresses', 'shippings', 'pending', 'checkout', 'credit', 'paid', 'invoiced'));
    }

    function companies()
    {
    	$companies = $this->getShippings(request('date'));
    	$colors = ['teal', 'green', 'blue', 'yellow', 'red', 'purple', 'navy', 'gray', 'aqua', 'black', 'maroon'];
    	return view('mbe.admin.companies', compact('companies', 'colors'));
    }

    function reference(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'cash_reference' => 'sometimes|required',
            'reference' => 'sometimes|required',
        ]);

        foreach (Ingress::find($request->sales) as $sale) {
            $sale->update(['status' => 'pagado', 'paid_at' => $request->thisDate]);
            Payment::where('ingress_id', $sale->id)->update($validated);
        }

        return redirect(route('mbe.invoice.index', $request->thisDate));
    }

    function printDeposits($date)
    {
        $invoices = Ingress::whereYear('created_at', substr($date, 0, 4))
            ->whereMonth('created_at', substr($date, 5))
            ->where('invoice_id', '!=', null)
            ->where('company', 'mbe')
            ->where('status', '!=', 'cancelado')
            ->whereHas('payments', function($query) {
                $query->whereNull('cash_reference');
            })
            ->selectRaw('id, client_id, iva, amount, invoice_id, DATE_FORMAT(created_at, "%Y-%m-%d") as date')
            ->with(['client:id,name', 'payments'])
            ->get()
            ->groupBy('date');

        return view('mbe.admin.invoices_print', compact('invoices'));
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

    function getShippings($date)
    {
        $shippings = Ingress::monthly($date, 'mbe')->get();

        $families = [];

        foreach ($shippings as $shipping) {
            foreach (unserialize($shipping->products) as $product) {
                $p = Product::find($product['i']);

                if (isset($families[$p->family][$p->description])) {
                    $families[$p->family][$p->description] += $product['q'];
                } else {
                    $families[$p->family][$p->description] = 0 + $product['q'];
                }
            }
        }

        return $families;
    }

    function getShippingsTotal($date)
    {
        $shippings = Ingress::monthly($date, 'mbe')->get();

        $total = 0;

        foreach ($shippings as $shipping) {
            foreach (unserialize($shipping->products) as $product) {
                $total += $product['q'];
            }
        }

        return $total;
    }
}

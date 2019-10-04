<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Client, Payment, Product};

class AdminController extends Controller
{
	function daily(Request $request, $status)
    {
        $date = dateFromRequest();

        $ingresses = Ingress::whereDate('created_at', $date)
            ->whereCompany('mbe')
            ->where($this->getConditions($status))
            ->get();
            
        $ingresses_to_filter = Ingress::whereDate('created_at', $date)
            ->whereCompany('mbe')->get();

        $color = ['factura' => 'primary', 'efectivo' => 'success', 'tarjeta' => 'warning', 'transferencia' => 'info'][$status];

        return view('mbe.admin.daily', compact('date', 'ingresses', 'status', 'color', 'ingresses_to_filter'));
    }

    function monthly(Request $request)
    {
        $date = dateFromRequest('Y-m');

        $month = Payment::monthly($date, 'mbe');

        $working_days = $month->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date')->get()->groupBy('date')->count();

        $shippings = $this->getShippingsTotal($date);

        $credit_total = Ingress::monthly($date, 'mbe')->whereStatus('crédito')->sum('amount');

        $working_days = $working_days == 0 ? 1: $working_days;

        $pending = Payment::monthly($date, 'mbe')->whereNull('cash_reference')->sum('cash');

        return view('mbe.admin.monthly', compact('date', 'month', 'pending', 'working_days', 'credit_total', 'shippings'));
    }

    function companies()
    {
    	$companies = $this->getShippings(request('date'));
    	$colors = ['green', 'blue', 'yellow', 'red', 'purple'];
    	return view('mbe.admin.companies', compact('companies', 'colors'));
    }

    function getConditions($value)
    {
        if ($value == 'factura') {
            return [
                ['invoice', '=', 'otro']
            ];
        } else {
            return [
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
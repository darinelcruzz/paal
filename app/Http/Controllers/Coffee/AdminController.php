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

    function invoices(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m-d');

        $invoices = Ingress::whereDate('created_at', $date)
            ->where('invoice_id', '!=', null)
            ->get()
            ->groupBy('invoice_id');

        return view('coffee.admin.invoices', compact('invoices', 'date'));
    }

    function reference(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required'
        ]);
    }

    function references(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required'
        ]);
    }

    function edit($id)
    {
        //
    }

    function update(Request $request, $id)
    {
        //
    }

    function destroy($id)
    {
        //
    }
}

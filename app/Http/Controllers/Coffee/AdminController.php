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

    function create()
    {
        
    }

    function store(Request $request)
    {
        //
    }

    function show($id)
    {
        //
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

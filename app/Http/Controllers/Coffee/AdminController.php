<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Ingress, Payment};

class AdminController extends Controller
{
    function index()
    {
        $payments = Payment::whereDate('created_at', date('Y-m-d'));

        $deposits = $payments->where('type', '!=', 'contado')->get();

        $invoiced = Ingress::whereDate('created_at', date('Y-m-d'))
            ->where('invoice', '!=', 'no')
            ->where('retainer', 0)
            ->get();

        $paid = Ingress::whereDate('created_at', date('Y-m-d'))
            ->where('invoice', 'no')
            ->where('retainer', 0)
            ->get();

        return view('coffee.admin.index', compact('payments', 'paid', 'invoiced', 'deposits'));
    }

    function create()
    {
        //
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

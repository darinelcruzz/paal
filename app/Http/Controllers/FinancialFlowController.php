<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Ingress, Egress};

class FinancialFlowController extends Controller
{
    function index()
    {
        $egresses = Egress::whereYear('emission', date('Y'))
            ->whereMonth('emission', date('m'))
            ->get();

        $ingresses = Ingress::whereYear('bought_at', date('Y'))
            ->whereMonth('bought_at', date('m'))
            ->get();

        return view('paal.financial-flows.index', compact('egresses', 'ingresses'));
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

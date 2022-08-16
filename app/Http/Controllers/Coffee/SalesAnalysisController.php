<?php

namespace App\Http\Controllers\Coffee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ingress;

class SalesAnalysisController extends Controller
{
    function index()
    {
        $ingresses = Ingress::whereYear('bought_at', date('Y'))
            ->whereMonth('bought_at', date('m'))
            ->where('company', '!=', 'mbe')
            ->where('status', '!=', 'cancelado')
            ->get();

        $ingresses2 = Ingress::whereYear('bought_at', date('Y'))
            ->whereMonth('bought_at', date('m') - 1)
            ->where('company', '!=', 'mbe')
            ->where('status', '!=', 'cancelado')
            ->get();

        $ingresses3 = Ingress::whereYear('bought_at', date('Y'))
            ->whereMonth('bought_at', '!=', date('m'))
            ->where('company', '!=', 'mbe')
            ->where('status', '!=', 'cancelado')
            ->get();

        return view('coffee.analyses.index', compact('ingresses3', 'ingresses2', 'ingresses'));
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

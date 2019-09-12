<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Ingress, Client, Payment, Product};

class IngressController extends Controller
{
    function index($company = 'coffee')
    {
        $date = dateFromRequest('Y-m');
        $ingresses = Ingress::monthly($date, $company)->get();
        return view('paal.ingresses.index', compact('date', 'ingresses', 'company'));
    }

    function show(Ingress $ingress)
    {
        return view('paal.ingresses.show', compact('ingress'));
    }

    function edit(Ingress $ingress)
    {
        //
    }

    function update(Request $request, Ingress $ingress)
    {
        //
    }

    function destroy(Ingress $ingress)
    {
        //
    }
}

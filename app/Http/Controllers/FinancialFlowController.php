<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Ingress, Egress};

class FinancialFlowController extends Controller
{
    function iva()
    {
        $egresses = Egress::whereYear('emission', date('Y'))
            ->whereMonth('emission', date('m'))
            ->get();

        $ingresses = Ingress::whereYear('bought_at', date('Y'))
            ->whereMonth('bought_at', date('m'))
            ->get();

        return view('paal.financial-flows.iva', compact('egresses', 'ingresses'));
    }

    function subtotal()
    {
        $egresses = Egress::whereYear('emission', date('Y'))
            ->whereMonth('emission', date('m'))
            ->with('category', 'group')
            ->get();
        
        $categories = $egresses->groupBy('category.name');
        
        $groups = $egresses->groupBy('group.name');

        // dd($categories, $groups);

        $ingresses = Ingress::whereYear('bought_at', date('Y'))
            ->whereMonth('bought_at', date('m'))
            ->get();

        return view('paal.financial-flows.subtotal', compact('egresses', 'categories', 'groups', 'ingresses'));
    }
}

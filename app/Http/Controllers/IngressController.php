<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingress;

class IngressController extends Controller
{
    function index(Request $request, $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest('Y-m'): $thisDate;
        // dd($thisDate);

        $ingresses = Ingress::whereYear('bought_at', substr($date, 0, 4))
            ->whereMonth('bought_at', substr($date, 5, 7))
            ->with('payments')
            ->get();

        return view('paal.ingresses.index', compact('date', 'ingresses'));
    }
}

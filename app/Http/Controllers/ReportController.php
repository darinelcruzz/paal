<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{EgressesByDateExport, PaidByProviderExport};

class ReportController extends Controller
{
    public function index()
    {
        return view('exports.index');
    }
    
    function pending(Request $request)
    {
        $filename = date('Y-m-d');
        return Excel::download(new EgressesByDateExport($request->from, $request->to), "{$filename}_EGR.xlsx");
    }

    function paid(Request $request)
    {
    	$filename = date('Y-m-d');
    	return Excel::download(new PaidByProviderExport($request->from, $request->to), "{$filename}_PGD.xlsx");
    }
}

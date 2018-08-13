<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{EgressesByDateExport, PaidByProviderExport, ProviderByDateExport};
use App\{Provider, Product};

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

    function providers(Request $request)
    {
        $this->validate($request, [
            'provider_id' => 'required'
        ]);

    	$filename = date('Y-m-d');
        $provider = Provider::find($request->provider_id)->name;
        $fullname = explode(' ', trim($provider));
    	return Excel::download(
            new ProviderByDateExport(
                $request->from,
                $request->to, 
                $request->provider_id
            ), 
            "{$filename}_" . strtoupper($fullname[0]) . ".xlsx"
        );
    }
}

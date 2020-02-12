<?php

namespace App\Http\Controllers\Sanson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EgressRequest;
use Illuminate\Support\Facades\Storage;
use App\{Egress, Provider};

class GeneralEgressController extends Controller
{
    function create()
    {
        return view('sanson.egresses.general.create');
    }

    function store(EgressRequest $request)
    {
        // dd($request->all());
        $provider = Provider::find($request->provider_id);

        $is_allowed = $provider->checkAmountAndInvoices();

        if($is_allowed[0]) {
            return redirect()->back()->with('message', $is_allowed[1]);
        }

        $expiration = strtotime($request->emission) + ($request->expiration * 86400);

        $egress = Egress::create($request->except(['pdf_bill', 'xml', 'pdf_complement', 'complement', 'expiration']));

        $egress->update([
            'pdf_bill' => saveSansonFile($request->file("pdf_bill")),
            'pdf_complement' => saveSansonFile($request->file("pdf_complement"), 'complements'),
            'xml' => saveSansonFile($request->file("xml")),
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('sanson.egress.index', 'pagado'));
    }
}

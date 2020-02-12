<?php

namespace App\Http\Controllers\Sanson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EgressRequest;
use App\{Egress, Provider, Check};

class CashRegisterController extends Controller
{
    function index()
    {
        $checks = Check::where('status', 'cobrado')->where('company', 'sanson')->orderByDesc('charged_at')->get();

        $last_folio = $this->getLastFolio();

        return view('sanson.egresses.register.index', compact('checks', 'last_folio'));
    }

    function create(Check $check)
    {
        return view('sanson.egresses.register.create', compact('check'));
    }

    function store(EgressRequest $request, Check $check)
    {
        $provider = Provider::find($request->provider_id);

        $is_allowed = $provider->checkAmountAndInvoices();

        if($is_allowed[0]) {
            return redirect()->back()->with('message', $is_allowed[1]);
        }

        $expiration = strtotime($request->emission) + ($request->expiration * 86400);

        $egress = $check->egresses()->create($request->except(['pdf_bill', 'xml', 'expiration']));

        $egress->update([
            'pdf_bill' => saveSansonFile($request->file('pdf_bill')),
            'xml' => saveSansonFile($request->file('xml')),
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('sanson.egress.register.index'));
    }

    function getLastFolio()
    {
        $check = Check::whereCompany('sanson')->get()->last();

        return $check ? $check->folio: 0;
    }
}
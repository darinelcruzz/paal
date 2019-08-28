<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EgressRequest;
use App\{Egress, Provider, Check};

class CashRegisterController extends Controller
{
    function index()
    {
        $checks = Check::where('status', 'cobrado')->where('company', 'mbe')->orderByDesc('charged_at')->get();

        $last_folio = $this->getLastFolio();

        return view('mbe.egresses.register.index', compact('checks', 'last_folio'));
    }

    function create(Check $check)
    {
        return view('mbe.egresses.register.create', compact('check'));
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
            'pdf_bill' => saveMbeFile($request->file('pdf_bill')),
            'xml' => saveMbeFile($request->file('xml')),
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('mbe.egress.register.index'));
    }

    function getLastFolio()
    {
        $check = Check::all()->last();

        return $check ? $check->folio: 0;
    }
}
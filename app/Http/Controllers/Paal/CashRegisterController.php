<?php

namespace App\Http\Controllers\Paal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EgressRequest;
use App\{Egress, Provider, Check, Category};

class CashRegisterController extends Controller
{
    function index()
    {
        $checks = Check::where('status', 'cobrado')->orderByDesc('charged_at')->get();

        $last_folio = $this->getLastFolio();

        return view('paal.egresses.register.index', compact('checks', 'last_folio'));
    }

    function create(Check $check)
    {
        $categories = Category::whereType('egresos')->pluck('name', 'id')->toArray();
        $groups = Category::whereType('gastos')->pluck('name', 'id')->toArray();
        return view('paal.egresses.register.create', compact('check', 'categories', 'groups'));
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
            'pdf_bill' => saveCoffeeFile($request->file('pdf_bill')),
            'xml' => saveCoffeeFile($request->file('xml')),
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('paal.egress.register.index'));
    }

    function getLastFolio()
    {
        $check = Check::all()->last();

        return $check ? $check->folio: 0;
    }
}
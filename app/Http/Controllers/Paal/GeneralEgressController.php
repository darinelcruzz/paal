<?php

namespace App\Http\Controllers\Paal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EgressRequest;
use Illuminate\Support\Facades\Storage;
use App\{Egress, Provider, Category};

class GeneralEgressController extends Controller
{
    function create()
    {
        $providers = Provider::general()->pluck('provider', 'id')->toArray();
        $categories = Category::whereType('egresos')->pluck('name', 'id')->toArray();
        $groups = Category::whereType('gastos')->pluck('name', 'id')->toArray();

        return view('paal.egresses.general.create', compact('providers', 'categories', 'groups'));
    }

    function store(EgressRequest $request)
    {
        $provider = Provider::find($request->provider_id);

        $is_allowed = $provider->checkAmountAndInvoices();

        if($is_allowed[0]) {
            return redirect()->back()->with('message', $is_allowed[1]);
        }

        $expiration = strtotime($request->emission) + ($request->expiration * 86400);

        $egress = Egress::create($request->except(['pdf_bill', 'xml', 'pdf_complement', 'complement', 'expiration']));

        $egress->update([
            'pdf_bill' => saveCoffeeFile($request->file("pdf_bill")),
            'pdf_complement' => saveCoffeeFile($request->file("pdf_complement"), 'complements'),
            'xml' => saveCoffeeFile($request->file("xml")),
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('paal.egress.index', 'pagado'));
    }
}

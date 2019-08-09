<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EgressRequest;
use Illuminate\Support\Facades\Storage;
use App\{User, Egress, Provider};

class ReturnsController extends Controller
{
    function create()
    {
        $providers = Provider::general()->pluck('provider', 'id')->toArray();

        $users = User::whereId(2)->pluck('name', 'id')->toArray();

        return view('coffee.egresses.returns.create', compact('providers', 'users'));
    }

    function store(EgressRequest $request)
    {
        $provider = Provider::find($request->provider_id);

        $is_allowed = $provider->checkAmountAndInvoices();

        if($is_allowed[0]) {
            return redirect()->back()->with('message', $is_allowed[1]);
        }

        $expiration = strtotime($request->emission) + ($request->expiration * 86400);

        $egress = Egress::create($request->except(['pdf_bill', 'xml', 'expiration']));

        $egress->update([
            'pdf_bill' => saveCoffeeFile($request->file('pdf_bill')),
            'xml' => saveCoffeeFile($request->file('xml')),
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('coffee.egress.index'));
    }
}
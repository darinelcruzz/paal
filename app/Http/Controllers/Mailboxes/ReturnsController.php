<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EgressRequest;
use Illuminate\Support\Facades\Storage;
use App\{User, Egress, Provider};

class ReturnsController extends Controller
{
    function create()
    {
        $provider = Provider::whereIn('company', ['mbe', 'both'])->where('group', 'rp')->first();

        $users = User::whereId(2)->pluck('name', 'id')->toArray();

        return view('mbe.egresses.returns.create', compact('provider', 'users'));
    }

    function store(EgressRequest $request)
    {
        $expiration = strtotime($request->emission) + ($request->expiration * 86400);

        $egress = Egress::create($request->except(['pdf_bill', 'xml', 'expiration']));

        $egress->update([
            'pdf_bill' => saveMbeFile($request->file('pdf_bill')),
            'xml' => saveMbeFile($request->file('xml')),
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('mbe.egress.index', 'pendiente'));
    }

    function make()
    {
        $provider = Provider::whereIn('company', ['mbe', 'both'])->where('group', 'ex')->first();

        return view('mbe.egresses.returns.make', compact('provider'));
    }

    function save(EgressRequest $request)
    {
        $expiration = strtotime($request->emission) + ($request->expiration * 86400);

        $egress = Egress::create($request->except(['pdf_bill', 'xml', 'expiration']));

        $egress->update([
            'pdf_bill' => saveCoffeeFile($request->file('pdf_bill')),
            'xml' => saveCoffeeFile($request->file('xml')),
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('mbe.egress.index', 'pagado'));
    }
}
<?php

namespace App\Http\Controllers\Sanson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EgressRequest;
use Illuminate\Support\Facades\Storage;
use App\{User, Egress, Provider};

class ReturnsController extends Controller
{
    function create()
    {
        $provider = Provider::whereIn('company', ['sanson', 'both'])->where('group', 'rp')->first();

        $users = User::whereIn('id', [2, 4, 8])->pluck('name', 'id')->toArray();

        return view('sanson.egresses.returns.create', compact('provider', 'users'));
    }

    function store(EgressRequest $request)
    {
        $expiration = strtotime($request->emission) + ($request->expiration * 86400);

        $egress = Egress::create($request->except(['pdf_bill', 'xml', 'expiration']));

        $egress->update([
            'pdf_bill' => saveSansonFile($request->file('pdf_bill')),
            'xml' => saveSansonFile($request->file('xml')),
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('sanson.egress.index', 'pendiente'));
    }

    function make()
    {
        $provider = Provider::whereIn('company', ['sanson', 'both'])->where('group', 'ex')->first();

        return view('sanson.egresses.returns.make', compact('provider'));
    }

    function save(EgressRequest $request)
    {
        $expiration = strtotime($request->emission) + ($request->expiration * 86400);

        $egress = Egress::create($request->except(['pdf_bill', 'xml', 'expiration']));

        $egress->update([
            'pdf_bill' => saveSansonFile($request->file('pdf_bill')),
            'xml' => saveSansonFile($request->file('xml')),
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('sanson.egress.index', 'pagado'));
    }
}
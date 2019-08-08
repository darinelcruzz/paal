<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    function store(Request $request)
    {
        $this->validate($request, [
            'provider_id' => 'required',
            'returned_to' => 'required',
            'provider_name' => 'sometimes|required',
            'folio' => 'required',
            'pdf_bill' => 'required',
            'xml' => 'required',
            'expiration' => 'required',
            'amount' => 'required|gt:iva',
            'iva' => 'required',
        ],[
            'amount.gt' => 'No puede ser menor que IVA',
        ]);

        $provider = Provider::find($request->provider_id);

        if ($provider->remaining < $request->amount) {
            $message = "$provider->name tiene un monto máximo mensual de $provider->amount solamente le quedan $ $provider->remaining";
            return redirect()->back()->with('message', $message);
        } elseif ($provider->bills <= $provider->created_bills) {
            $message = "$provider->name tiene una cantidad máxima mensual de $provider->bills facturas";
            return redirect()->back()->with('message', $message);
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
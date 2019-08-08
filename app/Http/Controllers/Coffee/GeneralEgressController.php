<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Egress, Provider};

class GeneralEgressController extends Controller
{
    function create()
    {
        $providers = Provider::general()->pluck('provider', 'id')->toArray();

        return view('coffee.egresses.general.create', compact('providers'));
    }

    function store(Request $request)
    {
        // dd($request->file("xml")->getClientOriginalExtension());
        $this->validate($request, [
            'provider_id' => 'required',
            'folio' => 'required',
            'pdf_bill' => 'required',
            'expiration' => 'required',
            'amount' => 'required|gt:iva',
            'iva' => 'required',
            'pdf_complement' => 'sometimes|required',
            'complement_amount' => 'sometimes|required|lt:amount',
            'complement_date' => 'sometimes|required',
        ],[
            'amount.gt' => 'No puede ser menor que IVA',
            'complement_amount.lt' => 'No puede ser mayor que el total',
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

        $egress = Egress::create($request->except(['pdf_bill', 'xml', 'pdf_complement', 'complement', 'expiration']));

        $egress->update([
            'pdf_bill' => $this->saveFile($request->file("pdf_bill")),
            'pdf_complement' => $this->saveFile($request->file("pdf_complement"), 'complements'),
            'xml' => $this->saveFile($request->file("xml")),
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('coffee.egress.index'));
    }

    function saveFile($file, $folder = 'bills')
    {
        if ($file) {
            return Storage::putFileAs("public/coffee/$folder", $file, str_random(15) . '.' . $file->getClientOriginalExtension());
        }

        return null;
    }
}

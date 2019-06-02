<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Egress, Provider};

class EgressController extends Controller
{
    function index()
    {
        $egresses = Egress::where('company', 'coffee')
                        ->where('status', '!=', 'cancelado')
                        ->get();
        return view('coffee.egresses.index', compact('egresses'));
    }

    function create()
    {
        $providers = Provider::where('company', '!=', 'mbe')->pluck('name', 'id')->toArray();
        return view('coffee.egresses.create', compact('providers'));
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'provider_id' => 'required',
            'folio' => 'required',
            'pdf_bill' => 'required',
            'xml' => 'required',
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

        $path_to_pdf = Storage::putFileAs(
            "public/coffee/bills", $request->file("pdf_bill"), $egress->emission . "_" . $egress->id . ".pdf"
        );

        $path_to_xml = Storage::putFileAs(
            "public/coffee/bills", $request->file("xml"), $egress->emission . "_" . $egress->id . ".xml"
        );

        $path_to_complement = $request->file("pdf_complement") ? Storage::putFileAs(
            "public/coffee/complements", $request->file("pdf_complement"), $egress->complement_date . "_" . $egress->id . ".pdf") : null;

        $egress->update([
            'pdf_bill' => $path_to_pdf,
            'pdf_complement' => $path_to_complement,
            'xml' => $path_to_xml,
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('coffee.egress.index'));
    }

    function pay(Egress $egress)
    {
        return view('coffee.egresses.pay', compact('egress'));
    }

    function replace(Egress $egress)
    {
        return view('coffee.egresses.replace', compact('egress'));
    }

    function upload(Request $request, Egress $egress)
    {
        $this->validate($request, [
            'pdf_bill' => 'required'
        ]);

        $path_to_pdf = Storage::putFileAs(
            "public/coffee/bills", $request->file("pdf_bill"), $egress->payment_date . "_" . $egress->id . ".pdf"
        );

        $egress->update([
            'pdf_bill' => $path_to_pdf,
        ]);

        return redirect(route('coffee.egress.index'));
    }

    function settle(Request $request)
    {
        $this->validate($request, [
            'pdf_payment' => 'sometimes|required',
            'payment_date' => 'required',
            'method' => 'required',
            'mfolio' => 'sometimes|required',
        ]);

        $egress = Egress::find($request->id);

        if ($request->pdf_payment) {
            $path_to_pdf = Storage::putFileAs(
                "public/coffee/payments", $request->file("pdf_payment"), $egress->payment_date . "_" . $egress->id . ".pdf"
            );
        } else {
            $path_to_pdf = null;
        }

        $egress->update($request->only(['payment_date', 'method', 'mfolio']));

        $egress->update([
            'pdf_payment' => $path_to_pdf,
            'status' => 'pagado',
        ]);

        return redirect(route('coffee.egress.index'));
    }

    function edit(Egress $egress)
    {
        return view('coffee.egresses.edit', compact('egress'));
    }

    function update(Request $request, Egress $egress)
    {
        $egress->update($request->validate(['folio' => 'required']));

        return redirect(route('coffee.egress.index'));
    }
}

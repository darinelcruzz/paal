<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Egress, Provider};

class EgressController extends Controller
{
    function index()
    {
        $egresses = Egress::where('company', 'mbe')
                        ->where('status', '!=', 'cancelado')
                        ->get();
        return view('mailboxes.egresses.index', compact('egresses'));
    }

    function create()
    {
        $providers = Provider::where('company', '!=', 'coffee')->pluck('name', 'id')->toArray();
        return view('mailboxes.egresses.create', compact('providers'));
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
        }

        $expiration = strtotime($request->emission) + ($request->expiration * 86400);

        $egress = Egress::create($request->except(['pdf_bill', 'xml', 'pdf_complement', 'complement', 'expiration']));

        $path_to_pdf = Storage::putFileAs(
            "public/mailboxes/bills", $request->file("pdf_bill"), $egress->emission . "_" . $egress->id . ".pdf"
        );

        $path_to_xml = Storage::putFileAs(
            "public/mailboxes/bills", $request->file("xml"), $egress->emission . "_" . $egress->id . ".xml"
        );

        $path_to_complement = $request->file("pdf_complement") ? Storage::putFileAs(
            "public/coffee/complements", $request->file("pdf_complement"), $egress->complement_date . "_" . $egress->id . ".pdf") : null;

        $egress->update([
            'pdf_bill' => $path_to_pdf,
            'pdf_complement' => $path_to_complement,
            'xml' => $path_to_xml,
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('mbe.egress.index'));
    }

    function pay(Egress $egress)
    {
        return view('mailboxes.egresses.pay', compact('egress'));
    }

    function settle(Request $request)
    {
        $this->validate($request, [
            'pdf_payment' => 'required',
            'payment_date' => 'required',
            'method' => 'required',
            'mfolio' => 'sometimes|required',
        ]);

        $egress = Egress::find($request->id);

        $path_to_pdf = Storage::putFileAs(
            "public/mailboxes/payments", $request->file("pdf_payment"), $egress->payment_date . "_" . $egress->id . ".pdf"
        );

        $egress->update($request->only(['payment_date', 'method', 'mfolio']));

        $egress->update([
            'pdf_payment' => $path_to_pdf,
            'status' => 'pagado',
        ]);

        return redirect(route('mbe.egress.index'));
    }
}

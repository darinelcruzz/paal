<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Product, Client};

class IngressController extends Controller
{
    function index()
    {
        $ingresses = Ingress::where('company', 'coffee')
                        ->where('status', '!=', 'cancelado')
                        ->get();
        return view('coffee.ingresses.index', compact('ingresses'));
    }

    function create()
    {
        $clients = Client::where('company', '!=', 'mbe')->pluck('name', 'id')->toArray();
        $products = Product::all();
        return view('coffee.ingresses.create', compact('clients', 'products'));
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

        $ingress = Ingress::create($request->except(['pdf_bill', 'xml', 'pdf_complement', 'complement', 'expiration']));

        $path_to_pdf = Storage::putFileAs(
            "public/coffee/bills", $request->file("pdf_bill"), $ingress->emission . "_" . $ingress->id . ".pdf"
        );

        $path_to_xml = Storage::putFileAs(
            "public/coffee/bills", $request->file("xml"), $ingress->emission . "_" . $ingress->id . ".xml"
        );

        $path_to_complement = $request->file("pdf_complement") ? Storage::putFileAs(
            "public/coffee/complements", $request->file("pdf_complement"), $ingress->complement_date . "_" . $egress->id . ".pdf") : null;

        $egress->update([
            'pdf_bill' => $path_to_pdf,
            'pdf_complement' => $path_to_complement,
            'xml' => $path_to_xml,
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('coffee.egress.index'));
    }

    function pay(Ingress $ingress)
    {
        return view('coffee.ingresses.pay', compact('ingress'));
    }

    function settle(Request $request)
    {
        $this->validate($request, [
            'pdf_payment' => 'required',
            'payment_date' => 'required',
            'method' => 'required',
            'mfolio' => 'sometimes|required',
        ]);

        $ingress = Ingress::find($request->id);

        $path_to_pdf = Storage::putFileAs(
            "public/coffee/payments", $request->file("pdf_payment"), $ingress->payment_date . "_" . $ingress->id . ".pdf"
        );

        $ingress->update($request->only(['payment_date', 'method', 'mfolio']));

        $ingress->update([
            'pdf_payment' => $path_to_pdf,
            'status' => 'pagado',
        ]);

        return redirect(route('coffee.ingress.index'));
    }
}

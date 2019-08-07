<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Egress, Provider, Check};

class CashRegisterController extends Controller
{
    function index()
    {
        $checks = Check::where('company', 'coffee')->orderByDesc('charged_at')->get();

        $last_folio = $this->getLastFolio();

        return view('coffee.egresses.register.index', compact('checks', 'last_folio'));
    }

    function create(Check $check)
    {
        $providers = Provider::general()->pluck('name', 'id')->toArray();
        return view('coffee.egresses.register.create', compact('check', 'providers'));
    }

    function store(Request $request, Check $check)
    {
        $this->validate($request, [
            'provider_id' => 'required',
            'folio' => 'required',
            'emission' => 'required',
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

        $egress = $check->egresses()->create($request->except(['pdf_bill', 'xml', 'expiration']));

        $path_to_pdf = Storage::putFileAs(
            "public/coffee/bills", $request->file("pdf_bill"), $egress->emission . "_" . $egress->id . ".pdf"
        );

        $path_to_xml = Storage::putFileAs(
            "public/coffee/bills", $request->file("xml"), $egress->emission . "_" . $egress->id . ".xml"
        );

        $egress->update([
            'pdf_bill' => $path_to_pdf,
            'xml' => $path_to_xml,
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('coffee.egress.register.index'));
    }

    function getLastFolio()
    {
        $check = Check::all()->last();

        return $check ? $check->folio: 0;
    }
}
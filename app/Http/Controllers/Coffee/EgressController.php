<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Coffee\{CEgress, CProvider};

class EgressController extends Controller
{
    function index()
    {
        $egresses = CEgress::all();
        return view('coffee.egresses.index', compact('egresses'));
    }

    function create()
    {
        $providers = CProvider::pluck('name', 'id')->toArray();
        return view('coffee.egresses.create', compact('providers'));
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'provider' => 'required',
            'buying_date' => 'required',
            'pdf_bill' => 'required',
            'xml' => 'required',
            'amount' => 'required',
            'iva' => 'required',
        ]);

        $egress = CEgress::create($request->except(['pdf_bill', 'xml']));

        $path_to_pdf = Storage::putFileAs(
            "public/coffee/bills", $request->file("pdf_bill"), $egress->buying_date . "_" . $egress->id . ".pdf"
        );

        $path_to_xml = Storage::putFileAs(
            "public/coffee/bills", $request->file("xml"), $egress->buying_date . "_" . $egress->id . ".xml"
        );

        $egress->update([
            'pdf_bill' => $path_to_pdf,
            'xml' => $path_to_xml,
        ]);

        return redirect(route('egress.index'));
    }

    function show($id)
    {
        //
    }

    function edit($id)
    {
        //
    }

    function update(Request $request, $id)
    {
        //
    }

    function destroy($id)
    {
        //
    }

    function upload(Request $request)
    {
        $this->validate($request, [
            'pdf_payment' => 'required',
        ]);

        $egress = CEgress::find($request->id);

        $path_to_pdf = Storage::putFileAs(
            "public/coffee/payments", $request->file("pdf_payment"), $egress->payment_date . "_" . $egress->id . ".pdf"
        );

        $egress->update([
            'pdf_payment' => $path_to_pdf,
            'status' => 'pagado'
        ]);

        return redirect(route('egress.index'));
    }
}

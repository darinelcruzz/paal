<?php

namespace App\Http\Controllers\Sanson;

use App\{Quotation, Client, Ingress};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class QuotationController extends Controller
{
    function index(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $quotations = Quotation::normal('sanson', $date)->get();
        $total = count($quotations);

        $sales = $quotations->tap(function($quotations) {
            return $quotations->has('sales');
        })->count();

        return view('sanson.quotations.index', compact('quotations', 'sales', 'total', 'date'));
    }

    function internet(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $quotations = Quotation::internet('sanson', $date)->get();
        $total = count($quotations);

        $sales = $quotations->tap(function($quotations) {
            return $quotations->has('sales');
        })->count();

        return view('sanson.quotations.internet', compact('quotations', 'total', 'sales', 'date'));
    }

    function create($type)
    {
        return view('sanson.quotations.create', compact('type'));
    }

    function store(Request $request)
    {
        $attributes = $this->validate($request, [
            'client_id' => 'required',
            'amount' => 'required',
            'iva' => 'required',
            'company' => 'required',
            'type' => 'required',
            'user_id' => 'required',
            'client_name' => 'sometimes|required',
            'email' => 'sometimes|required',
        ]);

        $quotation = Quotation::create($attributes);

        if (isset($request->client_name)) {
            return redirect(route('sanson.quotation.internet'));
        }

        return redirect(route('sanson.quotation.index'));
    }

    function show(Quotation $quotation)
    {
        return view('sanson.quotations.show', compact('quotation'));
    }

    function download(Quotation $quotation)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setOptions(['isRemoteEnabled' => true, 'isPhpEnabled' => true])
            ->loadView('sanson.quotations.pdf', compact('quotation'));

        return $pdf->stream(date('dmYHis') . $quotation->id . ".pdf");
    }

    function print(Quotation $quotation)
    {
        return view('sanson.quotations.print', compact('quotation'));
    }

    function transform(Quotation $quotation, $type = null)
    {
        if ($type == null) {
            $type = $quotation->products_list_type;
        }
        $last_sale = Ingress::where('company', 'sanson')->get()->last();
        $last_folio = $last_sale ? $last_sale->folio + 1: 1;
        return view('sanson.quotations.transform', compact('quotation', 'last_folio', 'type'));
    }

    function edit(Quotation $quotation)
    {
        return view('sanson.quotations.edit', compact('quotation'));
    }

    function update(Request $request, Quotation $quotation)
    {
        $quotation->update($request->validate([
            'amount' => 'required',
            'iva' => 'required',
            'editions_count' => 'required'
        ]));

        if ($quotation->client_name) return redirect(route('sanson.quotation.internet'));

        return redirect(route('sanson.quotation.index'));
    }

    function destroy(Quotation $quotation)
    {
        //
    }
}

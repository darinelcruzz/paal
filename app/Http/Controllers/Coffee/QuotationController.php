<?php

namespace App\Http\Controllers\Coffee;

use App\{Quotation, Client, Ingress};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class QuotationController extends Controller
{
    function index(Request $request, $type = null)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');
        $quotations = Quotation::monthly('coffee', $date, $type)->get();
        $sales = Quotation::monthly('coffee', $date, $type)->has('retainers')->count();
        $color = $type ? ($type == 'formularios' ? 'primary': 'info') : 'warning';
        $total = count($quotations);

        return view('coffee.quotations.index', compact('quotations', 'sales', 'total', 'date', 'type', 'color'));
    }

    function create()
    {
        return view('coffee.quotations.create');
    }

    function store(Request $request)
    {
        $validated = $this->validate($request, [
            'client_id' => 'required',
            'user_id' => 'required',
            'amount' => 'required',
            'iva' => 'required',
            'company' => 'required',
            'type' => 'required',
            'client_name' => 'sometimes|required',
            'email' => 'sometimes|required',
            'rounding' => 'sometimes|required',
        ]);

        $quotation = Quotation::create($validated);

        if (isset($request->client_name)) {
            return redirect(route('coffee.quotation.index', $request->client_id == 658 ? 'formularios': 'campañas'));
        }

        return redirect(route('coffee.quotation.index'));
    }

    function show(Quotation $quotation)
    {
        return view('coffee.quotations.show', compact('quotation'));
    }

    function download(Quotation $quotation)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setOptions(['isRemoteEnabled' => true, 'isPhpEnabled' => true])
            ->loadView('coffee.quotations.print', compact('quotation'));

        return $pdf->stream('COTIZACION_' . $quotation->id . ".pdf");
    }

    function print(Quotation $quotation)
    {
        return view('coffee.quotations.print', compact('quotation'));
    }

    function transform(Quotation $quotation)
    {
        $last_sale = Ingress::where('company', 'coffee')->get()->last();
        $last_folio = $last_sale ? $last_sale->folio + 1: 1;
        return view('coffee.quotations.transform', compact('quotation', 'last_folio'));
    }

    function edit(Quotation $quotation)
    {
        return view('coffee.quotations.edit', compact('quotation'));
    }

    function update(Request $request, Quotation $quotation)
    {
        // dd($request->all());

        $validated = $this->validate($request, [
            'amount' => 'required',
            'iva' => 'required',
            'products' => 'required|nullable',
            'special_products' => 'required|nullable',
            'rounding' => 'required',
            'editions_count' => 'required',
        ]);

        $quotation->update($validated);

        return redirect(route('coffee.quotation.show', $quotation));
    }

    function destroy(Quotation $quotation)
    {
        //
    }
}

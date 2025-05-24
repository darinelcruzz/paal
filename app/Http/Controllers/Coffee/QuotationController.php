<?php

namespace App\Http\Controllers\Coffee;

use App\{Quotation, Client, Ingress, Variable};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class QuotationController extends Controller
{
    function index(Request $request, $status, $type = null)
    {
        $user = auth()->user();
        $date = isset($request->date) ? $request->date: date('Y-m');
        $quotations = Quotation::monthly($user->store_id, $date, $type)->where('status', $status)->get();
        $sales = Quotation::monthly($user->store_id, $date, $type)->where('status', $status)->has('sale')->count();
        $color = $type ? ($type == 'formularios' ? 'primary': 'info') : 'warning';
        $total = count($quotations);
        $vias = [];

        if ($type == 'campañas') {
            $vias = Quotation::monthly($user->store_id, $date, $type)->where('status', 'terminada')->get()->groupBy('via');
        }

        // dd($quotations);
        return view('coffee.quotations.index', compact('quotations', 'sales', 'total', 'date', 'type', 'color', 'vias', 'status'));
    }

    function create()
    {
        $exchange = Variable::find(1)->value;
        $promo = Variable::find(2)->value;
        $user = auth()->user();
        return view('coffee.quotations.create', compact('exchange', 'promo', 'user'));
    }

    function store(Request $request)
    {
        $validated = $this->validate($request, [
            'client_id' => 'required',
            'user_id' => 'required',
            'amount' => 'required',
            'iva' => 'required',
            'via' => 'sometimes|required',
            'company' => 'required',
            'company_id' => 'required',
            'store_id' => 'required',
            'type' => 'required',
            'client_name' => 'sometimes|required',
            'email' => 'sometimes|required',
            'rounding' => 'sometimes|required',
            'status' => 'required',
        ]);

        $quotation = Quotation::create($validated);

        if (isset($request->client_name)) {
            return redirect(route('coffee.quotation.index', $request->client_id == 658 ? 'formularios': 'campañas'));
        }

        return redirect(route('coffee.quotation.index', $quotation->status));
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

    function transform(Quotation $quotation, $type = null)
    {
        $user = auth()->user();
        $last_sale = Ingress::whereStoreId($user->store_id)->get()->last();
        $last_folio = $last_sale ? $last_sale->folio + 1: 1;
        $exchange = Variable::find(1)->value;
        $promo = Variable::find(2)->value;
        return view('coffee.quotations.transform', compact('quotation', 'last_folio', 'exchange', 'promo', 'user'));
    }

    function move(Quotation $quotation)
    {
        $quotation->update(['status' => 'terminada']);
        return redirect(route('coffee.quotation.index', 'terminada'));
    }

    function edit(Quotation $quotation)
    {
        $exchange = Variable::find(1)->value;
        $promo = Variable::find(2)->value;
        return view('coffee.quotations.edit', compact('quotation', 'exchange', 'promo'));
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

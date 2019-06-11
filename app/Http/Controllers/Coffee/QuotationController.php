<?php

namespace App\Http\Controllers\Coffee;

use App\{Quotation, Client, Ingress};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class QuotationController extends Controller
{
    function index(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $quotations = Quotation::where('company', 'coffee')
                        ->whereMonth('created_at', substr($date, 5, 7))
                        ->whereYear('created_at', substr($date, 0, 4))
                        ->orderByDesc('id')
                        ->get();
        return view('coffee.quotations.index', compact('quotations', 'date'));
    }

    function create($type)
    {
        return view('coffee.quotations.create', compact('clients', 'type'));
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
        ]);

        $quotation = Quotation::create($validated);

        $products = [];
        $special = [];

        for ($i=0; $i < count($request->items); $i++) {
            if ($request->is_special[$i] == 0) {
                array_push($products, [
                    'i' => $request->items[$i],
                    'q' => $request->quantities[$i],
                    'p' => $request->prices[$i],
                    'd' => $request->discounts[$i],
                    't' => $request->subtotals[$i],
                ]);
            } else {
                array_push($special, [
                    'i' => $request->items[$i],
                    'id' => $request->ids[$i],
                    'q' => $request->quantities[$i],
                    'p' => $request->prices[$i],
                    'd' => $request->discounts[$i],
                    't' => $request->subtotals[$i],
                ]);
            }
        }

        $quotation->update([
            'products' => serialize($products),
            'special_products' => serialize($special),
        ]);

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
            ->loadView('coffee.quotations.pdf', compact('quotation'));

        return $pdf->stream(date('dmYHis') . $quotation->id . ".pdf");
    }

    function transform(Quotation $quotation, $type)
    {
        // return $quotation->products_list;
        $last_sale = Ingress::where('company', 'coffee')->get()->last();
        $last_folio = $last_sale ? $last_sale->folio + 1: 1;
        return view('coffee.quotations.transform', compact('quotation', 'last_folio', 'type'));
    }

    function edit(Quotation $quotation)
    {
        return view('coffee.quotations.edit', compact('quotation'));
    }

    function update(Request $request, Quotation $quotation)
    {
        $validated = $this->validate($request, [
            'amount' => 'required',
            'iva' => 'required',
            'items' =>'required|min:1'
        ]);

        $products = [];
        $special = [];

        for ($i=0; $i < count($request->items); $i++) {
            if ($request->is_special[$i] == 0) {
                array_push($products, [
                    'i' => $request->items[$i],
                    'q' => $request->quantities[$i],
                    'p' => $request->prices[$i],
                    'd' => $request->discounts[$i],
                    't' => $request->subtotals[$i],
                ]);
            } else {
                array_push($special, [
                    'i' => $request->items[$i],
                    'id' => $request->ids[$i],
                    'q' => $request->quantities[$i],
                    'p' => $request->prices[$i],
                    'd' => $request->discounts[$i],
                    't' => $request->subtotals[$i],
                ]);
            }
        }

        $quotation->update([
            'products' => serialize($products),
            'special_products' => serialize($special),
            'iva' => $request->iva,
            'amount' => $request->amount,
            'editions_count' => $quotation->editions_count + 1,
        ]);

        return redirect(route('coffee.quotation.show', $quotation));
    }

    function destroy(Quotation $quotation)
    {
        //
    }
}

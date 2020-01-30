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

        $quotations = Quotation::where('company', 'sanson')
            ->whereNull('client_name')
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->orderByDesc('id')
            ->get();

        $quotations_with_sales = Quotation::where('company', 'sanson')
            ->whereNull('client_name')
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->has('sales')
            ->orderByDesc('id')
            ->count();

        $quotations_without_sales = Quotation::where('company', 'sanson')
            ->whereNull('client_name')
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->doesntHave('sales')
            ->orderByDesc('id')
            ->count();

        $all = $quotations->count();

        return view('sanson.quotations.index', compact('quotations', 'all', 'quotations_without_sales', 'quotations_with_sales', 'date'));
    }

    function internet(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $quotations = Quotation::where('company', 'sanson')
            ->whereNotNull('client_name')
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->orderByDesc('id')
            ->get();

        $quotations_with_sales = Quotation::where('company', 'sanson')
            ->whereNotNull('client_name')
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->has('sales')
            ->orderByDesc('id')
            ->count();

        $quotations_without_sales = Quotation::where('company', 'sanson')
            ->whereNotNull('client_name')
            ->whereMonth('created_at', substr($date, 5, 7))
            ->whereYear('created_at', substr($date, 0, 4))
            ->doesntHave('sales')
            ->orderByDesc('id')
            ->count();

        $all = $quotations->count();

        return view('sanson.quotations.internet', compact('quotations', 'all', 'quotations_without_sales', 'quotations_with_sales', 'date'));
    }

    function create($type)
    {
        return view('sanson.quotations.create', compact('type'));
    }

    function store(Request $request)
    {
        dd($request->all());
        $attributes = $this->validate($request, [
            'client_id' => 'required',
            'amount' => 'required',
            'iva' => 'required',
            'company' => 'required',
            'type' => 'required',
            'user_id' => 'required',
        ]);

        $quotation = Quotation::create($attributes);

        $products = [];
        $special = [];

        for ($i=0; $i < count($request->items); $i++) {
            if ($request->is_special[$i] == 0) {
                array_push($products, [
                    'i' => $request->items[$q],
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

        return redirect(route('sanson.quotation.show', $quotation));
    }

    function destroy(Quotation $quotation)
    {
        //
    }
}

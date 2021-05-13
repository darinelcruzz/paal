<?php

namespace App\Http\Controllers\Sanson;

use App\{Purchase, Egress, Provider};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    function index()
    {
        $purchases = Purchase::whereCompany('sanson')->get();
        return view('sanson.purchases.index', compact('purchases'));
    }

    function create()
    {
        //
    }

    function store(Request $request)
    {
        // dd($request->all());
        $attributes = $request->validate([
            'provider_id' => 'required',
            'purchased_at' => 'required',
            'company' => 'required',
            'user_id' => 'required',
            'order_id' => 'required',
            'amount' => 'required',
            'folio' => 'required',
        ]);

        $purchase = Purchase::create($attributes);

        if ($purchase) {
            // $provider = Provider::find($request->provider_id);

            // $is_allowed = $provider->checkAmountAndInvoices();

            // if($is_allowed[0]) {
            //     return redirect()->back()->with('message', $is_allowed[1]);
            // }

            $expiration = strtotime($request->purchased_at) + ($request->expiration * 86400);

            $egress = Egress::create([
                'folio' => $request->folioE,
                'provider_id' => $request->provider_id,
                'iva' => $request->iva,
                'amount' => $request->amount,
                'emission' => $request->purchased_at,
                'company' => $request->company
            ]);

            $egress->update([
                // 'pdf_bill' => saveSansonFile($request->file("pdf_bill")),
                // 'pdf_complement' => saveSansonFile($request->file("pdf_complement"), 'complements'),
                // 'xml' => saveSansonFile($request->file("xml")),
                'expiration' => date('Y-m-d', $expiration),
            ]);
        }

        return redirect(route('sanson.purchase.index'));
    }

    function show(Purchase $purchase)
    {
        return view('sanson.purchases.show', compact('purchase'));
    }

    function edit(Purchase $purchase)
    {
        //
    }

    function update(Request $request, Purchase $purchase)
    {
        //
    }

    function destroy(Purchase $purchase)
    {
        //
    }
}

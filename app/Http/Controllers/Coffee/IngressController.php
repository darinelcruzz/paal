<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Product, Client, Payment};
use Alert;

class IngressController extends Controller
{
    function index(Request $request)
    {
        $date = isset($request->date) ? $request->date: date('Y-m');

        $ingresses = Ingress::where('company', 'coffee')
                        // ->where('status', '!=', 'cancelado')
                        ->whereMonth('created_at', substr($date, 5, 7))
                        ->whereYear('created_at', substr($date, 0, 4))
                        ->orderByDesc('id')
                        ->get();
        return view('coffee.ingresses.index', compact('ingresses', 'date'));
    }

    function create()
    {
        $clients = Client::where('company', '!=', 'mbe')->get(['id', 'name', 'rfc'])->toJson();
        $last_sale = Ingress::where('company', 'coffee')->get()->last();
        $last_folio = $last_sale ? $last_sale->folio + 1: 1;
        return view('coffee.ingresses.create', compact('clients', 'last_folio'));
    }

    function store(Request $request)
    {
        $validated = $this->validate($request, [
            'client_id' => 'required',
            'user_id' => 'required',
            'quotation_id' => 'sometimes|required',
            'amount' => 'required',
            'invoice' => 'required',
            'iva' => 'required',
            'company' => 'required',
            'bought_at' => 'required',
        ]);

        if ($request->folio != Ingress::where('company', 'coffee')->get()->last()->folio) {

            $last_sale = Ingress::where('company', 'coffee')->get()->last();
            $last_folio = $last_sale ? $last_sale->folio + 1: 1;

            $total = $request->cash + $request->transfer + $request->check
                + $request->debit_card + $request->credit_card;

            $ingress = Ingress::create($validated + [
                'folio' => $last_folio,
                'retainer' => $request->type == 'anticipo' ? $total: 0,
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
                        'q' => $request->quantities[$i],
                        'p' => $request->prices[$i],
                        'd' => $request->discounts[$i],
                        't' => $request->subtotals[$i],
                    ]);
                }
            }

            if ($request->type == 'anticipo') {
                $ingress->update([
                    'products' => serialize($products),
                    'special_products' => serialize($special),
                    'retained_at' => date('Y-m-d'),
                    'status' => 'pendiente'
                ]);
            } else {
                $ingress->update([
                    'products' => serialize($products),
                    'special_products' => serialize($special),
                    'paid_at' => date('Y-m-d'),
                    // 'status' => $request->method == 5 ? 'crédito' :'pendiente'
                    'status' => 'pagado'
                ]);
            }

            $payment = Payment::create([
                'ingress_id' => $ingress->id,
                'type' => $request->type,
                'cash' => $request->cash,
                'transfer' => $request->transfer,
                'check' => $request->check,
                'debit_card' => $request->debit_card,
                'credit_card' => $request->credit_card,
                'reference' => $request->reference,
            ]);
        }

        return redirect(route('coffee.ingress.index'));
    }

    function show(Ingress $ingress)
    {
        return view('coffee.ingresses.show', compact('ingress'));
    }

    function charge(Ingress $ingress)
    {
        return view('coffee.ingresses.charge', compact('ingress'));
    }

    function ticket(Ingress $ingress)
    {
        $payment = $ingress->payments->first();
        return view('coffee.ingresses.ticket', compact('ingress', 'payment'));
    }

    function payments(Ingress $ingress)
    {
        return view('coffee.ingresses.payments', compact('ingress'));
    }

    function pay(Request $request, Ingress $ingress)
    {
        $this->validate($request, [
            'cash' => 'required',
            'transfer' => 'required',
            'check' => 'required',
            'debit_card' => 'required',
            'credit_card' => 'required',
            'type' => 'required'
        ]);

        $payment = Payment::create($request->all());

        if ($ingress->debt == 0) {
            $ingress->update([
                'status' => 'pagado',
                'paid_at' => date('Y-m-d')
            ]);

            $payment->update([
                'type' => 'liquidación'
            ]);
        }

        return view('coffee.ingresses.show', compact('ingress'));
    }

    function invoice(Request $request, Ingress $ingress)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|unique:ingresses',
            'xml' => 'required'
        ]);
        
        $path = Storage::putFileAs(
            "public/coffee/invoices", $request->file('xml'), "$request->invoice_id.xml"
        );
        
        $ingress->update($request->only('invoice_id'));

        if (isset($request->reference)) {
            $payment = Payment::where('ingress_id', $ingress->id)->first();
            $payment->update($request->only('reference'));
        }

        return redirect(route('coffee.admin.index'));
    }

    function invoices(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required',
            'xml' => 'required'
        ]);
        
        $path = Storage::putFileAs(
            "public/coffee/invoices", $request->file('xml'), "$request->invoice_id.xml"
        );
        
        foreach (Ingress::find($request->sales) as $sale) {
            $sale->update($request->only('invoice_id'));
            
            $payment = Payment::where('ingress_id', $sale->id)->first();
            $payment->update($request->only('reference'));
        }

        return redirect(route('coffee.admin.index'));
    }

    function destroy(Ingress $ingress, $reason)
    {
        Alert::success('Venta cancelada', "La venta $ingress->folio se ha cancelado exitosamente")->persistent('Cerrar');

        $ingress->update([
            'status' => 'cancelado',
            'canceled_for' => $reason
        ]);

        return back();
    }
}

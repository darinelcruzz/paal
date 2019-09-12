<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Client, Payment, Product};

class IngressController extends Controller
{
    function index()
    {
        $date = dateFromRequest('Y-m');
        $ingresses = Ingress::monthly($date, 'mbe')->get();
        return view('mbe.ingresses.index', compact('ingresses', 'date'));
    }

    function create()
    {
        $clients = Client::where('company', '!=', 'coffee')->pluck('name', 'id')->toArray();
        $methods = ['efectivo' => 'Efectivo', 'transferencia' => 'Transferencia', 'cheque' => 'Cheque', 'tarjeta débito' => 'Tarjeta de débito', 'tarjeta crédito' => 'Tarjeta de crédito'];
        return view('mbe.ingresses.create', compact('clients', 'methods'));
    }

    function store(Request $request)
    {
        $validated = $this->validate($request, [
            'client_id' => 'required',
            'amount' => 'required|gt:iva',
            'iva' => 'required',
            'bought_at' => 'required',
            'method' => 'sometimes|required',
            'folio' => 'required',
            'invoice' => 'sometimes|required',
            'status' => 'required',
            'company' => 'required',
        ],[
            'amount.gt' => 'No puede ser menor que IVA',
        ]);

        $ingress = Ingress::create($validated + ['products' => $this->getSerializedItems($request)]);

        $methods = ['efectivo' => 'cash', 'transferencia' => 'transfer', 'cheque' => 'check', 'tarjeta débito' => 'debit_card', 'tarjeta crédito' => 'credit_card'];

        if ($request->method) {
            $ingress->payments()->create([
                'type' => 'liquidación',
                $methods[$request->method] => $ingress->amount
            ]);
        }

        return redirect(route('mbe.ingress.daily', 'factura'));
    }

    function getSerializedItems(Request $request)
    {
        $products = [];

        for ($i=0; $i < count($request->items); $i++) {
            array_push($products, [
                'i' => $request->items[$i],
                'q' => $request->quantities[$i]
            ]);
        }

        return serialize($products);
    }
}

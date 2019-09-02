<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Client};

class IngressController extends Controller
{
    function index(Request $request, $status)
    {
        return view('mbe.coming_soon');
        $date = dateFromRequest();

        $ingresses = Ingress::whereDate('created_at', $date)
            ->whereCompany('mbe')
            ->where($this->getConditions($status))
            ->get();

        $ingresses_to_filter = Ingress::whereDate('created_at', $date)
            ->whereCompany('mbe')->get();

        $color = ['factura' => 'primary', 'efectivo' => 'success', 'tarjeta' => 'warning', 'transferencia' => 'info'][$status];

        return view('mbe.ingresses.index', compact('date', 'ingresses', 'status', 'color', 'ingresses_to_filter'));
    }

    function create()
    {
        return view('mbe.coming_soon');
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
            'type' => 'required',
            'folio' => 'required',
            'invoice' => 'sometimes|required',
            'status' => 'required',
            'company' => 'required',
        ],[
            'amount.gt' => 'No puede ser menor que IVA',
        ]);

        $ingress = Ingress::create($validated + ['products' => $this->getSerializedItems($request)]);

        $ingress->payments()->create([
            'type' => 'liquidación',
            $request->method => $ingress->amount
        ]);

        return redirect(route('mbe.ingress.index', 'factura'));
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

        return  serialize($products);
    }

    function getConditions($value)
    {
        if ($value == 'factura') {
            return [
                ['invoice', '=', 'otro']
            ];
        } else {
            return [
                ['type', 'LIKE', "%$value%"]
            ];
        }
    }
}

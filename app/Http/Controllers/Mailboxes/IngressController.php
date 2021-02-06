<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Client, Payment, Product, Variable};
use Alert;

class IngressController extends Controller
{
    function index($type = null)
    {
        $date = dateFromRequest('Y-m');
        $ingresses = Ingress::monthly($date, 'mbe')->whereType($type)->get();
        return view('mbe.ingresses.index', compact('ingresses', 'date', 'type'));
    }

    function create($type = null)
    {
        $clients = Client::where('company', 'mbe')->pluck('name', 'id')->toArray();
        $isShifted = false;
        $methods = ['efectivo' => 'Efectivo', 'transferencia' => 'Transferencia', 'cheque' => 'Cheque', 'tarjeta débito' => 'Tarjeta de débito', 'tarjeta crédito' => 'Tarjeta de crédito'];
        return view('mbe.ingresses.create', compact('clients', 'methods', 'isShifted', 'type'));
    }

    function shift($type = null)
    {
        $clients = Client::where('company', 'mbe')->pluck('name', 'id')->toArray();
        $isShifted = Variable::find(3)->value == 1;
        $methods = ['efectivo' => 'Efectivo', 'transferencia' => 'Transferencia', 'cheque' => 'Cheque', 'tarjeta débito' => 'Tarjeta de débito', 'tarjeta crédito' => 'Tarjeta de crédito'];
        return view('mbe.ingresses.create', compact('clients', 'methods', 'isShifted', 'type'));
    }

    function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, ['reference' => 'sometimes|required']);

        $validated = $request->validate([
            'client_id' => 'required',
            'amount' => 'required',
            'iva' => 'required',
            'bought_at' => 'sometimes|required',
            'folio' => 'sometimes|required',
            'invoice_id' => 'sometimes|required',
            'method' => 'sometimes|required',
            'invoice' => 'sometimes|required',
            'status' => 'required',
            'company' => 'required',
            'type' => 'nullable',
        ]);

        $ingress = Ingress::create($validated + ['products' => $this->getSerializedItems($request)]);

        $ingress->update([
            'amount' => round($ingress->amount, 2),
            'iva' => round($ingress->iva, 2),
        ]);

        $methods = ['efectivo' => 'cash', 'transferencia' => 'transfer', 'cheque' => 'check', 'tarjeta débito' => 'debit_card', 'tarjeta crédito' => 'credit_card'];

        if ($request->method) {
            $ingress->payments()->create([
                'type' => 'liquidación',
                $methods[$request->method] => $ingress->amount,
                'reference' => $request->reference
            ]);
        }

        if ($ingress->client_id > 626) {
            return redirect(route('mbe.order.show', $ingress->client));
        }

        return redirect(route('mbe.ingress.daily', $ingress->route_method));
    }

    function ticket(Ingress $ingress)
    {
        $payment = $ingress->payments->first();
        return view('mbe.ingresses.ticket', compact('ingress', 'payment'));
    }

    function destroy(Ingress $ingress, $reason)
    {
        Alert::success('Venta cancelada', "La venta $ingress->folio se ha cancelado exitosamente")->persistent('Cerrar');

        $ingress->update([
            'status' => 'cancelado',
            'canceled_for' => $reason
        ]);

        return redirect(route('mbe.ingress.index'));
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

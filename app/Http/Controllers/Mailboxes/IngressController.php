<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Client, Payment};

class IngressController extends Controller
{
    function index(Request $request, $status)
    {
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
            'type' => 'sometimes|required',
            'folio' => 'required',
            'invoice' => 'sometimes|required',
            'status' => 'required',
            'company' => 'required',
        ],[
            'amount.gt' => 'No puede ser menor que IVA',
        ]);

        $ingress = Ingress::create($validated + ['products' => $this->getSerializedItems($request)]);

        $methods = ['efectivo' => 'cash', 'transferencia' => 'transfer', 'cheque' => 'check', 'tarjeta débito' => 'debit_card', 'tarjeta crédito' => 'credit_card'];

        if ($request->type) {
            $ingress->payments()->create([
                'type' => 'liquidación',
                $methods[$request->type] => $ingress->amount
            ]);
        }

        return redirect(route('mbe.ingress.index', 'factura'));
    }

    function monthly(Request $request)
    {
        $date = dateFromRequest('Y-m');

        $month = Payment::monthly($date, 'mbe');

        $working_days = $month->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date')->get()->groupBy('date')->count();

        $shippings = Ingress::monthly($date, 'mbe')->count();

        $credit_total = Ingress::monthly($date, 'mbe')->whereStatus('crédito')->sum('amount');

        $working_days = $working_days == 0 ? 1: $working_days;

        $pending = Payment::monthly($date, 'mbe')->whereNull('cash_reference')->sum('cash');

        return view('mbe.ingresses.monthly', compact('date', 'month', 'pending', 'working_days', 'credit_total', 'shippings'));
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

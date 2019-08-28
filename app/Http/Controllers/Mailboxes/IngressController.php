<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Client};

class IngressController extends Controller
{
    function index()
    {
        $ingresses = Ingress::where('company', 'mbe')
                        ->where('status', '!=', 'cancelado')
                        ->get();
        return view('mbe.ingresses.index', compact('ingresses'));
    }

    function create()
    {
        $clients = Client::where('company', '!=', 'coffee')->pluck('name', 'id')->toArray();
        $methods = ['cash' => 'Efectivo', 'transfer' => 'Transferencia', 'check' => 'Cheque', 'debit_card' => 'Tarjeta de débito', 'credit_card' => 'Tarjeta de crédito'];
        return view('mailboxes.ingresses.create', compact('clients', 'methods'));
    }

    function store(Request $request)
    {
        $validated = $this->validate($request, [
            'client_id' => 'required',
            'amount' => 'required|gt:iva',
            'iva' => 'required',
            'bought_at' => 'required',
            'paid_at' => 'required',
            'method' => 'required',
            'operation_number' => 'required',
            'status' => 'required',
            'company' => 'required',
        ],[
            'amount.gt' => 'No puede ser menor que IVA',
        ]);

        $ingress = Ingress::create($validated);

        $ingress->payments()->create([
            'type' => 'liquidación',
            $request->method => $ingress->amount
        ]);

        return redirect(route('mbe.ingress.index'));
    }
}

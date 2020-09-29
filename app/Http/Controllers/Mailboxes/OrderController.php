<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Ingress, Client};

class OrderController extends Controller
{
    function index()
    {
        $date = dateFromRequest('Y-m');

        $clients = Client::where('id', '>', '627')
            ->whereHas('ingresses', function($query) use ($date) {
                $query->whereCompany('mbe')
                    ->whereMonth('created_at', substr($date, 5, 7))
                    ->whereYear('created_at', substr($date, 0, 4));
            })
            ->get();

        return view('mbe.clients.index', compact('date', 'clients'));
    }

    function show(Client $client)
    {
        $invoices = $client->ingresses->where('invoice_id', '!=', null)->groupBy('invoice_id');
        $ingresses = $client->ingresses->where('status', '!=', 'cancelado')->where('invoice_id', null);
        
        return view('mbe.clients.show', compact('client', 'ingresses', 'invoices'));
    }

    function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'invoice_id' => 'required',
            'sales' => 'required',
            'xml' => 'required'
        ]);

        $path = Storage::putFileAs(
            "public/mbe/invoices", $request->file('xml'), "$request->invoice_id.xml"
        );
        
        foreach (Ingress::find($request->sales) as $sale) {
            $sale->update($request->only('invoice_id'));
        }

        return redirect(route('mbe.order.show', $sale->client));
    }
}

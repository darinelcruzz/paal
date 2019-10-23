<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        return view('mbe.clients.show', compact('client'));
    }
}
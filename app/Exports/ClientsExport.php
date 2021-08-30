<?php

namespace App\Exports;

use App\Client;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClientsExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $clients = Client::whereCompany('coffee')
            ->with('addresses')
            ->get();

        return view('exports.clients', compact('clients'));
    }
}

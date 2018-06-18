<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Egress;

// class EgressesByDateExport implements FromCollection
// {
//     function collection()
//     {
//     	return Egress::where('company', 'coffee')
//     		->get(['provider_id', 'folio', 'amount', 'iva']);
//     }
// }

/**
 * 
 */
class EgressesByDateExport implements FromView
{
	
	function view(): View
	{
		$egresses = Egress::all();
		return view('exports.egresses_by_date', compact('egresses'));
	}
}
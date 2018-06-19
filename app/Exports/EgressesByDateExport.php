<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Egress;

class EgressesByDateExport implements FromView
{
	
	function view(): View
	{
		$egresses = Egress::all();
		return view('exports.egresses_by_date', compact('egresses'));
	}
}
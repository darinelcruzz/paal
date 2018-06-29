<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Egress;

class EgressesByDateExport implements FromView, ShouldAutoSize
{
	public function __construct($startDate, $endDate)
    {
        $this->start = $startDate;
        $this->end = $endDate;
    }
	
	function view(): View
	{
		$egresses = Egress::whereBetween('emission', [$this->start, $this->end])->get();
		return view('exports.egresses_by_date', compact('egresses'));
	}
}
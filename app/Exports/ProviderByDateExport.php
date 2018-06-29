<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Egress;

class ProviderByDateExport implements FromView, ShouldAutoSize
{
    public function __construct($startDate, $endDate, $provider)
    {
    	$this->provider = $provider;
        $this->start = $startDate;
        $this->end = $endDate;
    }
	
	function view(): View
	{
		$egresses = Egress::where('provider_id', $this->provider)
					->whereBetween('emission', [$this->start, $this->end])
					->get();

		return view('exports.provider_by_date', compact('egresses'));
	}
}
<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Egress;

class PaidByProviderExport implements FromView, ShouldAutoSize
{
    public function __construct($startDate, $endDate)
    {
        $this->start = $startDate;
        $this->end = $endDate;
    }
	
	function view(): View
	{
		$egresses = Egress::whereBetween('payment_date', [$this->start, $this->end])
					->get()
					->groupBy('provider_id');

		return view('exports.paid_by_provider', compact('egresses'));
	}
}

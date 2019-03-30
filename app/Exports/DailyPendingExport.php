<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Ingress;

class DailyPendingExport implements FromView, ShouldAutoSize
{
    public function __construct($date)
    {
        $this->date = $date;
    }
	
	function view(): View
	{
		$invoices = Ingress::where('invoice_id', '!=', null)
            ->whereDate('created_at', $this->date)
            ->get()
            ->groupBy('invoice_id');

		return view('exports.daily_pending', compact('invoices'));
	}
}
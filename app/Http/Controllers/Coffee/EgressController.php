<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Egress, Provider, Check};

class EgressController extends Controller
{
    function index(Request $request, $status = 'pagado', $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest('Y-m'): $thisDate;

        $paid = Egress::from($date, 'payment_date')
            ->where('status', 'pagado')
            ->where('check_id', null)
            ->orderByDesc('payment_date')
            ->get();

        $pending = Egress::company('coffee')->where('status', 'pendiente')->where('check_id', null)->get();
        
        $expired = Egress::company('coffee')->where('status', 'vencido')->get();

        $checks = Check::from($date, 'charged_at')->get();

        $checkssum = $checks->sum(function ($product) {
            return $product->total;
        });

        $expired = Egress::where('company', 'coffee')
            ->where('status', 'vencido')
            ->get()
            ->sum(function ($egress) { 
                return $egress->coffee != 0 ? $egress->coffee : $egress->amount;
            });

        return view('coffee.egresses.index', compact('paid', 'pending', 'expired', 'date', 'expired', 'checks', 'checkssum', 'status'));
    }

    function pay(Egress $egress)
    {
        return view('coffee.egresses.pay', compact('egress'));
    }

    function charge(Request $request, Egress $egress)
    {
        // dd($request->all());
        $attributes = $this->validate($request, [
            'paid_at' => 'required',
            'method' => 'required',
            'folio' => 'required',
            'amount' => 'required'
        ]);

        $egress->payments()->create($attributes);

        if ($request->single_payment == 0 || $egress->debt == 0) {
            $egress->update([
                'status' => 'pagado',
                'method' => $request->method,
                'payment_date' => $request->paid_at,
            ]);
        }

        return redirect(route('coffee.egress.index', $egress->status));
    }

    function edit(Egress $egress)
    {
        return view('coffee.egresses.edit', compact('egress'));
    }

    function update(Request $request, Egress $egress)
    {
        $egress->update($request->validate(['folio' => 'required']));

        return redirect(route('coffee.egress.index', $egress->status));
    }
    
    function replace(Egress $egress)
    {
        return view('coffee.egresses.replace', compact('egress'));
    }

    function upload(Request $request, Egress $egress)
    {
        $request->validate(['pdf_bill' => 'required']);

        $egress->update(['pdf_bill' => saveCoffeeFile($request->file("pdf_bill"))]);

        return redirect(route('coffee.egress.index'));
    }
}

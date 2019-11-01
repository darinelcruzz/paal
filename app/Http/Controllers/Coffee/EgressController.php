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
        // $date = isset($request->date) ? $request->date: date('Y-m');
        $date = $thisDate == null ? dateFromRequest(): $thisDate;

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

        $alltime = Egress::where('company', 'coffee')->get();

        return view('coffee.egresses.index', compact('paid', 'pending', 'expired', 'date', 'alltime', 'checks', 'checkssum', 'status'));
    }

    function pay(Egress $egress)
    {
        return view('coffee.egresses.pay', compact('egress'));
    }


    function charge(Request $request, Egress $egress)
    {
        $attributes = $this->validate($request, [
            'payment_date' => 'sometimes|required',
            'method' => 'sometimes|required',
            'mfolio' => 'sometimes|required',
            'second_payment_date' => 'sometimes|required',
            'second_method' => 'sometimes|required',
            'nfolio' => 'sometimes|required',
        ]);

        $egress->update($attributes);

        $egress->update([
            'status' => $request->single_payment == 0 ? 'pagado': 'pendiente',
        ]);

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

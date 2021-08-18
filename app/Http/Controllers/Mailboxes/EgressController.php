<?php

namespace App\Http\Controllers\Mailboxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Egress, Provider, Check};

class EgressController extends Controller
{
    function index(Request $request, $status = 'pagado', $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest('Y-m'): $thisDate;

        $paid1 = Egress::from($date, 'payment_date', 'mbe')
            ->where('check_id', null)
            ->where('status', 'pagado')
            ->get();

        $paid2 = Egress::from($date, 'payment_date', 'coffee')->where('mbe', '!=', 0)->get();
        $paid = $paid1->concat($paid2);

        $pending1 = Egress::company('mbe')->where('status', 'pendiente')->get();
        $pending2 = Egress::where('mbe', '!=', 0)->where('status', 'pendiente')->get();
        $pending = $pending1->concat($pending2);
        
        $expired1 = Egress::company('mbe')->where('status', 'vencido')->get();
        $expired2 = Egress::where('mbe', '!=', 0)->where('status', 'vencido')->get();
        $expired = $expired1->concat($expired2);

        $checks = Check::from($date, 'charged_at', 'mbe')->get();

        $checkssum = $checks->sum(function ($product) {
            return $product->total;
        });

        $alltime = Egress::where('company', 'mbe')->orWhere('mbe', '>', 0)->get();

        return view('mbe.egresses.index', compact('paid', 'pending', 'expired', 'date', 'alltime', 'checks', 'checkssum', 'status'));
    }

    function pay(Egress $egress)
    {
        return view('mbe.egresses.pay', compact('egress'));
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

        return redirect(route('mbe.egress.index', $egress->status));
    }

    function edit(Egress $egress)
    {
        return view('mbe.egresses.edit', compact('egress'));
    }

    function update(Request $request, Egress $egress)
    {
        $egress->update($request->validate(['folio' => 'required']));

        return redirect(route('mbe.egress.index', $egress->status));
    }

    function replace(Egress $egress)
    {
        return view('mbe.egresses.replace', compact('egress'));
    }

    function upload(Request $request, Egress $egress)
    {
        $request->validate(['pdf_bill' => 'required']);

        $egress->update(['pdf_bill' => saveMbeFile($request->file("pdf_bill"))]);

        return redirect(route('mbe.egress.index'));
    }
}

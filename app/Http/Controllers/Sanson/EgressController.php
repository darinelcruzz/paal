<?php

namespace App\Http\Controllers\Sanson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Egress, Provider, Check};
use Response;

class EgressController extends Controller
{
    function index(Request $request, $status = 'pagado', $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest('Y-m'): $thisDate;

        $paid = Egress::from($date, 'payment_date', 'sanson')
            ->where('status', 'pagado')
            ->where('check_id', null)
            ->orderByDesc('payment_date')
            ->get();

        $pending = Egress::company('sanson')->where('status', 'pendiente')->where('check_id', null)->get();
        
        $expired = Egress::company('sanson')->where('status', 'vencido')->get();

        $checks = Check::from($date, 'charged_at', 'sanson')->get();

        $checkssum = $checks->sum(function ($product) {
            return $product->total;
        });

        $alltime = Egress::where('company', 'sanson')->get();

        return view('sanson.egresses.index', compact('paid', 'pending', 'expired', 'date', 'alltime', 'checks', 'checkssum', 'status'));
    }

    function pay(Egress $egress)
    {
        return view('sanson.egresses.pay', compact('egress'));
    }


    function charge(Request $request, Egress $egress)
    {
        // $attributes = $this->validate($request, [
        //     'payment_date' => 'sometimes|required',
        //     'method' => 'sometimes|required',
        //     'mfolio' => 'sometimes|required',
        //     'second_payment_date' => 'sometimes|required',
        //     'second_method' => 'sometimes|required',
        //     'nfolio' => 'sometimes|required',
        // ]);

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

        return redirect(route('sanson.egress.index', $egress->status));
    }

    function edit(Egress $egress)
    {
        return view('sanson.egresses.edit', compact('egress'));
    }

    function update(Request $request, Egress $egress)
    {
        $egress->update($request->validate(['folio' => 'required']));

        return redirect(route('sanson.egress.index', $egress->status));
    }
    
    function replace(Egress $egress)
    {
        return view('sanson.egresses.replace', compact('egress'));
    }

    function upload(Request $request, Egress $egress)
    {
        $request->validate(['pdf_bill' => 'required']);

        $egress->update(['pdf_bill' => saveSansonFile($request->file("pdf_bill"))]);

        return redirect(route('sanson.egress.index'));
    }

    function displayPDF(Egress $egress, $column)
    {
        $filePath = $egress->{$column};
        
        if(!Storage::exists($filePath) ) {
          abort(404);
        }

        $pdfContent = Storage::get($filePath);
        $type       = Storage::mimeType($filePath);
        $fileName   = $egress->folio;

        return Response::make($pdfContent, 200, [
          'Content-Type'        => $type,
          'Content-Disposition' => 'inline; filename="'.$fileName.'"'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Paal;

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

        $egresses = Egress::from($date, 'emission')
            ->where('check_id', null)
            ->orWhere('status', '!=', 'pagado')
            ->orderByDesc('id')
            ->get();

        $checks = Check::from($date, 'charged_at')->get();

        $checkssum = $checks->sum(function ($product) {
            return $product->total;
        });

        return view('paal.egresses.index', compact('egresses', 'date', 'checks', 'checkssum'));
    }

    function pay(Egress $egress)
    {
        return view('paal.egresses.pay', compact('egress'));
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

        return redirect(route('paal.egress.index', $egress->status));
    }

    function edit(Egress $egress)
    {
        return view('paal.egresses.edit', compact('egress'));
    }

    function update(Request $request, Egress $egress)
    {
        $egress->update($request->validate(['folio' => 'required']));

        return redirect(route('paal.egress.index', $egress->status));
    }
    
    function replace(Egress $egress)
    {
        return view('paal.egresses.replace', compact('egress'));
    }

    function upload(Request $request, Egress $egress)
    {
        $request->validate(['pdf_bill' => 'required']);

        $egress->update(['pdf_bill' => saveCoffeeFile($request->file("pdf_bill"))]);

        return redirect(route('paal.egress.index'));
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

    function destroy(Egress $egress)
    {
        $egress->delete();

        return redirect(route('paal.egress.index', ['pagado', dateFromRequest('Y-m')]));
    }
}

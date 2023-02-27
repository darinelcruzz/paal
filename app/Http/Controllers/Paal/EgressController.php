<?php

namespace App\Http\Controllers\Paal;

use Illuminate\Http\Request;
use App\Http\Requests\EgressRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Egress, Provider, Check, Category, User};
use Response;

class EgressController extends Controller
{
    function index(Request $request, $status = 'pagado', $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest('Y-m'): $thisDate;

        $egresses = Egress::whereYear('emission', substr($date, 0, 4))
            ->whereMonth('emission', substr($date, 5, 7))
            ->where('check_id', null)
            ->orWhere(function ($query) {
                $query->where('check_id', null)
                    ->where('status', '!=', 'pagado');
            })
            ->orWhere(function ($query) use ($date) {
                $query->whereYear('payment_date', substr($date, 0, 4))
                    ->whereMonth('payment_date', substr($date, 5, 7))
                    ->where('check_id', null);
            })
            ->orderByDesc('id')
            ->get();

        $egresses2 = Egress::whereYear('emission', substr($date, 0, 4))
            ->whereMonth('emission', substr($date, 5, 7))
            ->where('check_id', null)
            ->orWhere(function ($query) {
                $query->where('check_id', null)
                    ->where('status', '!=', 'pagado');
            })
            ->orWhere(function ($query) use ($date) {
                $query->whereYear('payment_date', substr($date, 0, 4))
                    ->whereMonth('payment_date', substr($date, 5, 7))
                    ->where('check_id', null);
            })
            ->orderByDesc('id')
            ->get();

        $checks = Check::from($date, 'charged_at')->get();

        $checkssum = $checks->sum(function ($product) {
            return $product->total;
        });

        return view('paal.egresses.index', compact('egresses', 'date', 'checks', 'checkssum'));
    }

    function create()
    {
        $users = User::whereIn('id', [2, 7])->pluck('name', 'id')->toArray();
        $providers = Provider::general()->pluck('provider', 'id')->toArray();
        $categories = Category::whereType('egresos')->where('name', '!=', 'CAJA CHICA')->pluck('name', 'id')->toArray();
        $groups = Category::whereType('gastos')->pluck('name', 'id')->toArray();

        return view('paal.egresses.create', compact('users', 'providers', 'categories', 'groups'));
    }

    function store(EgressRequest $request)
    {
        $provider = Provider::find($request->provider_id);

        $is_allowed = $provider->checkAmountAndInvoices();

        if($is_allowed[0]) {
            return redirect()->back()->with('message', $is_allowed[1]);
        }

        $expiration = strtotime($request->emission) + ($request->expiration * 24 * 60 * 60);

        $egress = Egress::create($request->except(['pdf_bill', 'xml', 'pdf_complement', 'complement', 'expiration']));

        $egress->update([
            'pdf_bill' => saveCoffeeFile($request->file("pdf_bill")),
            'pdf_complement' => saveCoffeeFile($request->file("pdf_complement"), 'complements'),
            'xml' => saveCoffeeFile($request->file("xml")),
            'expiration' => date('Y-m-d', $expiration),
        ]);

        return redirect(route('paal.egress.index'));
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

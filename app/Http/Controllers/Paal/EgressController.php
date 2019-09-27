<?php

namespace App\Http\Controllers\Paal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\{Egress, Provider, Check};

class EgressController extends Controller
{
    function index($company, $status = 'pagado')
    {
        $date = dateFromRequest('Y-m');

        $colors = ['pagado' => 'success', 'pendiente' => 'warning', 'vencido' => 'danger'];
        $color = $colors[$status];

        $conditions = [
            ['company', '=', $company],
            ['status', '=', $status]
        ];

        if ($status == 'pagado') {
            array_push($conditions, ['check_id', '=', null]);

            $egresses = Egress::whereYear('payment_date', substr($date, 0, 4))
                ->whereMonth('payment_date', substr($date, 5, 7))
                ->where($conditions)
                ->get();
        } else {
            $egresses = Egress::where($conditions)->get();
        }

        $checks = Check::from($date, 'charged_at', $company)->get();

        $checkssum = $checks->sum(function ($product) {
            return $product->total;
        });

        $alltime = Egress::company($company)->get();
        $paid = Egress::from($date, 'payment_date', $company)->get();

        return view('paal.egresses.index', compact('egresses','paid', 'date', 'alltime', 'checks', 'checkssum', 'status', 'company', 'color'));
    }

    function pay(Egress $egress)
    {
        return view('paal.egresses.pay', compact('egress'));
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

        return redirect(route('paal.egress.index', $egress->company));
    }

    function monthly($company = 'coffee')
    {
        $date = dateFromRequest('Y-m');
        $total = Egress::from($date, 'created_at', $company)->sum('amount');
        $pending = Egress::whereCompany($company)->whereStatus('pendiente')->sum('amount');
        $expired = Egress::whereCompany($company)->whereStatus('vencido')->sum('amount');

        $general = Egress::from($date, 'created_at', $company)
            ->whereHas('provider', function ($query) {
                $query->where('group', 'of');
            })
            ->sum('amount');

        $register = Egress::from($date, 'created_at', $company)
            ->whereHas('provider', function ($query) {
                $query->where('group', 'cc');
            })
            ->sum('amount');

        $reposition = Egress::from($date, 'created_at', $company)
            ->whereHas('provider', function ($query) {
                $query->where('group', 'rp');
            })
            ->sum('amount');

        $extra = Egress::from($date, 'created_at', $company)
            ->whereHas('provider', function ($query) {
                $query->where('group', 'ex');
            })
            ->sum('amount');

        $expenses = Egress::from($date, 'created_at', $company)
            ->whereHas('provider', function ($query) {
                $query->where('type', 'gg');
            })
            ->sum('amount');

        $sales = Egress::from($date, 'created_at', $company)
            ->whereHas('provider', function ($query) {
                $query->where('type', 'cv');
            })
            ->sum('amount');

        $undeductible = Egress::from($date, 'created_at', $company)
            ->whereHas('provider', function ($query) {
                $query->where('is_deductible', 0);
            })
            ->sum('amount');

        $deductible = Egress::from($date, 'created_at', $company)
            ->whereHas('provider', function ($query) {
                $query->where('is_deductible', 1);
            })
            ->sum('amount');

        return view('paal.admin.monthly_e', 
            compact(
                'total', 'pending', 'expired', 'general', 'register', 'reposition', 'extra', 
                'expenses', 'sales', 'undeductible', 'deductible', 'company', 'date'
            )
        );
    }
}
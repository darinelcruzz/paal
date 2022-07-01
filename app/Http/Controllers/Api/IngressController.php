<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Ingress, Shipping};

class IngressController extends Controller
{
    function index($date = null, $company = 'coffee', $type = 'total')
    {
        $date = $date ?? date('Y-m');

        if ($type != 'envíos') {
            $ingresses = Ingress::whereYear('bought_at', substr($date, 0, 4))
                ->whereMonth('bought_at', substr($date, 5, 2))
                ->where('company', $company)
                ->where('status', '!=', 'cancelado')
                ->with('payments')
                ->get();

            $divisor = $type == 'promedio' ? $ingresses->groupBy('bought_at')->count(): 1;

            // return $ingresses->sum('amount') / $divisor;

            return $ingresses->sum(function ($ingress) use ($type) {
                if ($type == 'total') {
                    return $ingress->payments->sum(function ($payment) {
                        return $payment->cash + $payment->check + $payment->credit_card + $payment->debit_card + $payment->transfer;
                    });
                } elseif ($type == 'depositar') {
                    return $ingress->payments->where('cash_reference', null)->sum('cash');
                } elseif ($type == 'promedio') {
                    return $ingress->type != 'anticipo' ? $ingress->amount - $ingress->retainers->sum('amount'): $ingress->amount;
                }
            }) / $divisor;
        }

        return Shipping::monthly($date, $company)->count();;
    }

    function ingresses($date = null, $company = 'coffee', $type = 'no equipo')
    {
        $date = $date ?? date('Y-m');

        // if ($type == 'no equipo' || $type == 'equipo') {
        //     $projectSum = Ingress::whereYear('bought_at', substr($date, 0, 4))
        //         ->whereMonth('bought_at', substr($date, 5, 7))
        //         ->where('company', $company)
        //         ->where('status', '!=', 'cancelado')
        //         ->where('type', 'proyecto')
        //         ->with('movements.product')
        //         ->get()
        //         ->sum(function ($ingress) use ($type) { 
        //             return $ingress->movements->sum(function ($m) use ($ingress, $type) {
        //                 if ($type == 'equipo') {
        //                     return in_array($m->product->category, ['EQUIPO', 'BARRAS', 'REFACCIONES']) ? $m->real_amount: 0;
        //                 } else {
        //                     return in_array($m->product->category, ['INSUMOS', 'ACCESORIOS', 'VASOS', 'SERVICIOS', 'LIMPIEZA']) ? $m->real_amount: 0;
        //                 }
        //             }) + $ingress->rounding;
        //         });
        // } else {
        //     $projectSum = 0;
        // }

        // $projectSum = 0;

        return Ingress::whereYear('bought_at', substr($date, 0, 4))
            ->whereMonth('bought_at', substr($date, 5, 7))
            ->where('company', $company)
            ->where('status', '!=', 'cancelado')
            ->when($type == 'depositado', function ($query) {
                $query->with('payments');
            }, function ($query) use ($type){
                $query->where('type', $type);
            })
            ->get()
            ->sum(function ($ingress) use ($type) {
                if($type == 'depositado') {
                    return $ingress->payments->where('cash_reference', '!=', null)->sum('cash');
                } else {
                    // return $ingress->type == 'anticipo' ? $ingress->quotation->amount - $ingress->retainers->sum('amount'): $ingress->amount;
                    return $ingress->amount;
                }
            });
    }

    function payments($date = null, $company = 'coffee', $method = 'efectivo')
    {
        $date = $date ?? date('Y-m');
        $column = ['efectivo' => 'cash', 'transferencia' => 'transfer', 'cheque' => 'check', 'tarjeta de débito' => 'debit_card', 'tarjeta de crédito' => 'credit_card'][$method];

        return Ingress::whereYear('bought_at', substr($date, 0, 4))
            ->whereMonth('bought_at', substr($date, 5, 7))
            ->where('company', $company)
            // ->where('method', $method)
            ->where('status', '!=', 'cancelado')
            ->with('payments')
            ->get()
            ->sum(function ($ingress) use ($column){
                return $ingress->payments->sum($column);
            });
    }
}

<?php

namespace App\Observers;

use App\Ingress;

class IngressObserver
{
    function created(Ingress $ingress)
    {
        if ($ingress->company != 'mbe' && $ingress->type != 'anticipo' && $ingress->type != 'nota de crédito') {
            $ingress->movements()->createMany(request('items'));
        }

        if (request('shipping')) $ingress->shipping()->create(['address_id' => request('address_id') ?? null]);

        if ($ingress->retainers->count() > 0 && $ingress->type != 'anticipo' && $ingress->type != 'nota de crédito') {
            Ingress::create([
                'folio' => $ingress->folio + 1,
                'company' => $ingress->company,
                'client_id' => $ingress->client_id,
                'user_id' => auth()->user()->id,
                'bought_at' => date('Y-m-d'),
                'paid_at' => date('Y-m-d'),
                'invoice' => 'G02',
                'status' => 'pagado',
                'type' => 'nota de crédito',
                'quotation_id' => $ingress->quotation_id,
                'amount' => $ingress->retainers->sum('amount'),
            ]);
        }
    }

    function updated(Ingress $ingress)
    {
        if ($ingress->company != 'mbe' && $ingress->status == 'cancelado') {
            foreach ($ingress->movements as $movement) {
                $movement->product->update([
                    'quantity' => $movement->product->quantity + $movement->quantity
                ]);
            }
        }
    }

    function deleted(Ingress $ingress)
    {
        //
    }

    function restored(Ingress $ingress)
    {
        //
    }

    function forceDeleted(Ingress $ingress)
    {
        //
    }
}

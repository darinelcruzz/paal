<?php

namespace App\Observers;

use App\Ingress;

class IngressObserver
{
    function created(Ingress $ingress)
    {
        if ($ingress->company != 'mbe') {
            $ingress->movements()->createMany(request('items'));
        }

        if ($ingress->company == 'sanson') {
            $ingress->payments()->create(request('payment') + ['type' => request('method')]);
        }

        if (request('shipping')) $ingress->shipping()->create();
    }

    function updated(Ingress $ingress)
    {
        if ($ingress->company == 'sanson' && $ingress->status == 'cancelado') {
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

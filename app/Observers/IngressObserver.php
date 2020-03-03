<?php

namespace App\Observers;

use App\Ingress;

class IngressObserver
{
    function created(Ingress $ingress)
    {
        if($ingress->company == 'sanson') {
            $ingress->movements()->createMany(request('items'));

            $ingress->payments()->create(request('payment') + ['type' => request('method')]);

            if (request('shipping')) $ingress->shipping()->create();
        }
    }

    function updated(Ingress $ingress)
    {
        //
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

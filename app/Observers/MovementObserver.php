<?php

namespace App\Observers;

use App\Movement;

class MovementObserver
{
    function created(Movement $movement)
    {
        if ($movement->movable_type == 'App\Ingress') {
            $movement->product->update([
                'quantity' => $movement->product->quantity - $movement->quantity
            ]);
        }

        if ($movement->movable_type == 'App\Purchase') {
            $movement->product->update([
                'quantity' => $movement->product->quantity + $movement->quantity
            ]);
        }
    }

    function updated(Movement $movement)
    {
        //
    }

    function deleted(Movement $movement)
    {
        //
    }

    function restored(Movement $movement)
    {
        //
    }

    function forceDeleted(Movement $movement)
    {
        //
    }
}

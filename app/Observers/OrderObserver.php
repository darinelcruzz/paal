<?php

namespace App\Observers;

use App\Order;

class OrderObserver
{
    function created(Order $order)
    {
        $order->movements()->createMany(request('items'));
    }

    function updated(Order $order)
    {
        //
    }

    function deleted(Order $order)
    {
        //
    }

    function restored(Order $order)
    {
        //
    }

    function forceDeleted(Order $order)
    {
        //
    }
}

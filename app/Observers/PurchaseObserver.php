<?php

namespace App\Observers;

use App\Purchase;

class PurchaseObserver
{
    function created(Purchase $purchase)
    {
        if($purchase->company == 'sanson') {
            
            $purchase->movements()->createMany(request('items'));
        }
    }

    function updated(Purchase $purchase)
    {
        //
    }

    function deleted(Purchase $purchase)
    {
        //
    }

    function restored(Purchase $purchase)
    {
        //
    }

    function forceDeleted(Purchase $purchase)
    {
        //
    }
}

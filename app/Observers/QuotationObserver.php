<?php

namespace App\Observers;

use App\Quotation;

class QuotationObserver
{
    function created(Quotation $quotation)
    {
        if($quotation->company == 'sanson') {
            $quotation->movements()->createMany(request('items'));
        }
    }

    function updated(Quotation $quotation)
    {
        //
    }

    function deleted(Quotation $quotation)
    {
        //
    }

    function restored(Quotation $quotation)
    {
        //
    }

    function forceDeleted(Quotation $quotation)
    {
        //
    }
}

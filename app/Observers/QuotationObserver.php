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
        if ($quotation->company == 'sanson') {
            $products = $quotation->movements->pluck('product_id')->toArray();
            foreach (request('items') as $index => $item) {
                if (in_array($item['product_id'], $products)) {
                    $movement = $quotation->movements->where('product_id', $item['product_id'])->first();
                    $movement->update($item);
                } else {
                    $quotation->movements()->create($item);
                }
            }

            foreach ($quotation->movements as $movement) {
                $products = collect(request('items'))->pluck('product_id')->toArray();
                if (!in_array($movement->product_id, $products)) {
                    $movement->delete();
                }
            }
        }
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

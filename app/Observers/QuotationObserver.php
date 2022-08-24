<?php

namespace App\Observers;

use App\Quotation;

class QuotationObserver
{
    function created(Quotation $quotation)
    {
        $quotation->movements()->createMany(request('items'));
    }

    function updated(Quotation $quotation)
    {
        if($quotation->getOriginal('status') != 'pendiente') {
            if (count($quotation->movements) > 0) {
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
            } else {
                $quotation->movements()->createMany(request('items'));
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

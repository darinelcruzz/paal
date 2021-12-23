<?php

namespace App\Observers;

use App\Egress;

class EgressObserver
{
    function updated(Egress $egress)
    {
        if ($egress->status == 'eliminado') {
            $egress->logs()->create([
                'description' => "ELIMINADO",
                'user_id' => auth()->user()->id,
            ]);
        }
    }
}

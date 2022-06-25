<?php

namespace App\Observers;

use App\Egress;

class EgressObserver
{
    function deleted(Egress $egress)
    {
        $description = 'Se eliminó el egresso ' . $egress->id . ' folio: ' . $egress->folio;

        $egress->logs()->create([
            'description' => $description,
            'user_id' => auth()->user()->id,
        ]);
    }
}

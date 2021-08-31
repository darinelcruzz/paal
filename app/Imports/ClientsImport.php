<?php

namespace App\Imports;

use App\Client;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ClientsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows->splice(1) as $row) {
            $client = Client::find($row[0]);
            
            $client->update([
                'state' => 'chiapas',
            ]);
        }
    }
}

<?php

namespace App\Imports;

use App\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows->splice(1) as $row) {

            Product::create([
                'description' => $row[0],
                'code' => $row[1],
                'type' => $row[2],
                'category' => $row[3],
                'family' => $row[4],
                'wholesale_price' => $row[5] * 1.16,
                'retail_price' => $row[5] * 1.16,
                'barcode' => $row[1],
                'wholesale_quantity' => 0,
                'iva' => 1,
            ]);            
        }
    }
}

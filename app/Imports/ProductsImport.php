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
            $product = Product::find($row[0]);

            if ($product) {
                $product->update([
                    'category' => $row[6],
                    'status' => $row[7],
                ]);
            }
            
        }
    }
}

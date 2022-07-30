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
                    'type' => $row[1],
                    'description' => $row[2],
                    'code' => $row[3],
                    'barcode' => $row[3],
                    'retail_price' => $row[4],
                    'wholesale_price' => $row[5],
                    'family' => $row[6],
                    'category' => $row[7],
                    'status' => $row[8] == 0 ? 'descontinuado': 'activo',
                ]);
            }
            
        }
    }
}

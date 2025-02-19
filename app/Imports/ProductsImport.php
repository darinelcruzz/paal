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

            if($product = Product::where('id', $row[0])->first()) {

                if ($row[8] == 'activo') {
                    $product->update([
                        'description' => $row[1],
                        'code' => $row[2],
                        'barcode' => $row[2],
                        'retail_price' => $row[3],
                        'wholesale_price' => $row[4],
                        'maximum_discount' => $row[5],
                        'family' => $row[6],
                        'category' => $row[7],
                        'type' => $row[8],
                        'status' => 'activo',
                    ]);
                } else {
                    $product->update(['status' => 'inactivo']);
                }

            } else {
                Product::create([
                    'description' => $row[1],
                    'code' => $row[2],
                    'barcode' => $row[2],
                    'retail_price' => $row[3],
                    'wholesale_price' => $row[4],
                    'maximum_discount' => $row[5],
                    'family' => $row[6],
                    'category' => $row[7],
                    'type' => $row[8],
                    'iva' => 1,
                    'wholesale_quantity' => 0,
                ]);            
            }

        }
    }
}

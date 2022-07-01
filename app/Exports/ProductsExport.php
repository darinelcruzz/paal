<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

// class ProductsExport implements FromCollection
class ProductsExport implements FromView, ShouldAutoSize
{
    public function __construct($company)
    {
        $this->company = $company;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $products = Product::select('id', 'description', 'code', 'retail_price', 'wholesale_price', 'family', 'category')
            ->whereCompany($this->company)
            ->get();

        return view('exports.products', compact('products'));
    }
}

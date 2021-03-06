<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Product};
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    function coffee($keyword = '')
    {
        return Product::where('company', 'COFFEE')
            ->where(function ($query) use ($keyword) {
                $query->where("description", "LIKE","%$keyword%")
                    ->orWhere("code", "LIKE", "%$keyword%")
                    ->orWhere("barcode", "LIKE", "%$keyword%")
                    ->orWhere("family", "LIKE", "%$keyword%");
            })
            ->orWhere('family', 'ENVÍOS')
            ->with('serial_numbers')
            ->paginate(5);
    }

    function sanson($keyword = '')
    {
        return Product::where('company', 'SANSON')
            ->where(function ($query) use ($keyword) {
                $query->where("description", "LIKE","%$keyword%")
                    ->orWhere("code", "LIKE", "%$keyword%")
                    ->orWhere("barcode", "LIKE", "%$keyword%")
                    ->orWhere("family", "LIKE", "%$keyword%");
            })
            ->orWhere('family', 'ENVÍOS')
            ->with('serial_numbers')
            ->paginate(5);
    }

    function mbe($keyword = '')
    {
        return Product::whereCompany('MBE')
            ->where(function ($query) use ($keyword) {
                $query->where("description", "LIKE","%$keyword%")
                    ->orWhere("code", "LIKE", "%$keyword%")
                    ->orWhere("barcode", "LIKE", "%$keyword%")
                    ->orWhere("family", "LIKE", "%$keyword%");
            })->paginate(5);
    }

    function seriable($company, $keyword = '')
    {
        return Product::whereCompany(strtoupper($company))
            ->where(function ($query) use ($keyword) {
                $query->where("description", "LIKE","%$keyword%")
                    ->orWhere("code", "LIKE", "%$keyword%")
                    ->orWhere("barcode", "LIKE", "%$keyword%")
                    ->orWhere("family", "LIKE", "%$keyword%");
            })
            ->where('is_seriable', 1)
            ->paginate(5);
    }

    function show(Product $product)
    {
        return $product;
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Product};
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    function index()
    {
        return Product::orderBy('id', 'DESC')->paginate(10);
    }

    function search($keyword)
    {
        return Product::orderBy('id', 'DESC')
            ->where('description', 'LIKE', "%$keyword%")
            ->orWhere('family', 'LIKE', "%$keyword%")
            ->orWhere('code', 'LIKE', "%$keyword%")
            ->paginate(10);
    }
}

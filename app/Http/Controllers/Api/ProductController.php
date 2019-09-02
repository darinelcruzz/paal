<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Product};
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    function index()
    {
        return Product::where('category', '!=', 'EQUIPO')
            ->where('category', '!=', 'MBE')
            ->orderBy('id', 'DESC')
            ->paginate(10);
    }

    function equipment()
    {
        return Product::where('category', 'EQUIPO')
            ->orWhere('dollars', 1)
            ->orderBy('id', 'DESC')
            ->paginate(10);
    }

    function mbe()
    {
        return Product::where('category', 'MBE')
            ->orderBy('id', 'DESC')
            ->paginate(5);
    }

    function search($keyword)
    {
        return Product::orderBy('id', 'DESC')
            ->where([
                ['category', '!=', 'EQUIPO'],
                ['category', '!=', 'MBE'],
                ['description', 'LIKE', "%$keyword%"]
            ])
            ->orWhere([
                ['category', '!=', 'EQUIPO'],
                ['category', '!=', 'MBE'],
                ['family', 'LIKE', "%$keyword%"]
            ])
            ->orWhere([
                ['category', '!=', 'EQUIPO'],
                ['category', '!=', 'MBE'],
                ['code', 'LIKE', "%$keyword%"]
            ])
            ->paginate(5);
    }

    function seek($keyword)
    {
        return Product::orderBy('id', 'DESC')
            ->where([
                ['category', '=', 'EQUIPO'],
                ['description', 'LIKE', "%$keyword%"]
            ])
            ->orWhere([
                ['category', '=', 'EQUIPO'],
                ['family', 'LIKE', "%$keyword%"]
            ])
            ->orWhere([
                ['category', '=', 'EQUIPO'],
                ['code', 'LIKE', "%$keyword%"]
            ])
            ->paginate(10);
    }

    function look($keyword)
    {
        return Product::orderBy('id', 'DESC')
            ->where([
                ['category', '=', 'MBE'],
                ['description', 'LIKE', "%$keyword%"]
            ])
            ->orWhere([
                ['category', '=', 'MBE'],
                ['family', 'LIKE', "%$keyword%"]
            ])
            ->orWhere([
                ['category', '=', 'MBE'],
                ['code', 'LIKE', "%$keyword%"]
            ])
            ->paginate(10);
    }
}

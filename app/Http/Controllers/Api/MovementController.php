<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Movement};

class MovementController extends Controller
{
    function index($type, $id)
    {
        return Movement::query()
            ->select('movable_type', 'movable_id', 'product_id', 'quantity', 'price', 'total', 'discount')
            ->where('movable_type', 'App\\' . ucfirst($type))
            ->where('movable_id', $id)
            ->with('product')
            ->get();
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\County;
use App\Http\Controllers\Controller;

class CountyController extends Controller
{
    function cities($name)
    {
        $county = County::where('name', $name)->first();
        return $county->cities;
    }
}
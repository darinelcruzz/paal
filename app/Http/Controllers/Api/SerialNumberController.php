<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{SerialNumber};

class SerialNumberController extends Controller
{
    function index($id)
    {
        return SerialNumber::where('ingress_id', $id)->get();
    }
}
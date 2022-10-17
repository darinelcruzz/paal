<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Payment};

class PaymentController extends Controller
{
    function index($id)
    {
        return Payment::where('ingress_id', $id)->get();
    }
}
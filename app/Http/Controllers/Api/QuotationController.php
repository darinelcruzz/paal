<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Quotation;
use App\Http\Controllers\Controller;

class QuotationController extends Controller
{
    function movements(Quotation $quotation)
    {
        return $quotation->movements;
    }
}

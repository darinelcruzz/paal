<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Provider;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{
    function index()
    {
        return Provider::where('company', '!=', 'mbe')->get(['id', 'name', 'xml_required']);
    }
}
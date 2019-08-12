<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Provider;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{
    function index()
    {
        return Provider::where('company', '!=', 'mbe')
        	->where('type', 'gg')
        	->orWhere('type', 'cv')
        	->get(['id', 'name', 'xml_required']);
    }

    function register()
    {
        return Provider::where('company', '!=', 'mbe')
        	->where('type', 'cc')
        	->get(['id', 'name', 'xml_required']);
    }
}
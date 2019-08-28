<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Provider;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{
    function index($company)
    {
        return Provider::where('company', '!=', $company)
        	->where('type', 'gg')
        	->orWhere('type', 'cv')
        	->get(['id', 'name', 'xml_required']);
    }

    function register($company)
    {
        return Provider::where('company', '!=', $company)
        	->where('type', 'cc')
        	->get(['id', 'name', 'xml_required']);
    }
}
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Provider;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{
    function index($company, $group)
    {
        return Provider::whereIn('company', [$company, 'both'])
        	->where('group', $group)
        	->get(['id', 'name', 'xml_required', 'type']);
    }
}

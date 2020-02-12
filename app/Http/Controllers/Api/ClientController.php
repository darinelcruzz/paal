<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Client};
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    function index($company)
    {
        return Client::where('company', $company)->get(['id', 'name', 'rfc']);
    }
}
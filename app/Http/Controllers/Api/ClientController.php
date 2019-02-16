<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Client};
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    function index()
    {
        return Client::where('company', '!=', 'mbe')->get(['id', 'name', 'rfc']);
    }
}
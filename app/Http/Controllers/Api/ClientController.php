<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Client};
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    function index($company)
    {
        return Client::whereStoreId(auth()->user()->store_id)->orWhere('company', 'internet')->get(['id', 'name', 'rfc']);
    }

    function addresses(Client $client)
    {
        return $client->addresses;
    }
}
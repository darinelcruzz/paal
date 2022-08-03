<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\{Client};
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    function index($company)
    {
        return Client::whereIn('company', ['coffee', 'sanson'])->orWhere('company', 'internet')->get(['id', 'name', 'rfc']);
    }

    function addresses(Client $client)
    {
        return $client->addresses;
    }
}
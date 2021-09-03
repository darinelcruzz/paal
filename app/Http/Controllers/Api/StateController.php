<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\State;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    function index()
    {
        return State::all();
    }

    function show(State $state)
    {
        return $state;
    }

    function counties($name)
    {
        $state = State::where('name', $name)->first();
        return $state->counties;
    }
}
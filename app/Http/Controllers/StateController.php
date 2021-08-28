<?php

namespace App\Http\Controllers;

use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    function index()
    {
        $states = State::all();
        return view('paal.states.index', compact('states'));
    }

    function create()
    {
        //
    }

    function store(Request $request)
    {
        //
    }

    function show(State $state)
    {
        //
    }

    function edit(State $state)
    {
        //
    }

    function update(Request $request, State $state)
    {
        //
    }

    function destroy(State $state)
    {
        //
    }
}

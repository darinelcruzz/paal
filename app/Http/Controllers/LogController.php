<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    function index()
    {
        $logs = Log::where('company', 'coffee')
            ->with('user', 'loggable.ingress')
            ->get();

        return view('coffee.logs.index', compact('logs'));
    }

    function create()
    {
        //
    }

    function store(Request $request)
    {
        //
    }

    function show(Log $log)
    {
        //
    }

    function edit(Log $log)
    {
        //
    }

    function update(Request $request, Log $log)
    {
        //
    }

    function destroy(Log $log)
    {
        //
    }
}

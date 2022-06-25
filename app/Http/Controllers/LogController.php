<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    function index()
    {
        $logs = Log::with('user', 'loggable.ingress')
            ->orderByDesc('id')
            ->get();

        return view("paal.logs.index", compact('logs'));
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

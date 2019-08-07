<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Check;

class CheckController extends Controller
{
    function store(Request $request)
    {
        $request->validate([
            'folio' => 'required',
            'pdf' => 'required',
            'charged_at' => 'required',
        ]);

        $check = Check::create($request->except('pdf'));

        $path_to_pdf = Storage::putFileAs(
            "public/coffee/checks", $request->file("pdf"), $check->charged_at . "_" . $check->id . ".pdf"
        );

        $check->update(['pdf' => $path_to_pdf]);

        return redirect(route('coffee.egress.register.index'));
    }

    function show(Check $check)
    {
        return view('coffee.checks.show', compact('check'));
    }
}

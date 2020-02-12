<?php

namespace App\Http\Controllers\Sanson;

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
            'company' => 'required',
            'charged_at' => 'required',
        ]);

        $check = Check::create($request->except('pdf'));

        $path_to_pdf = Storage::putFileAs(
            "public/sanson/checks", $request->file("pdf"), $check->charged_at . "_" . $check->id . ".pdf"
        );

        $check->update(['pdf' => $path_to_pdf]);

        return redirect(route('sanson.egress.register.index'));
    }

    function edit(Check $check)
    {
        return view('sanson.checks.edit', compact('check'));
    }

    function update(Request $request, Check $check)
    {
        $attributes = $request->validate([
            'folio' => 'required',
            'charged_at' => 'required',
        ]);

        $check->update($attributes);

        if (isset($request->file)) {
            $check->update(['pdf' => saveSansonFile($request->file, 'checks')]);
        }

        return redirect(route('sanson.egress.register.index'));
    }

    function show(Check $check)
    {
        return view('sanson.checks.show', compact('check'));
    }
}

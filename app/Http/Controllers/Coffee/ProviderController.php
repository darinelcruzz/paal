<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coffee\CProvider;

class ProviderController extends Controller
{
    function index()
    {
        $providers = CProvider::all();
        return view('coffee.providers.index', compact('providers'));
    }

    function create()
    {
        return view('coffee.providers.create');
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'social' => 'required',
            'name' => 'required',
            'rfc' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'contact' => 'required',
        ]);

        CProvider::create($request->all());

        return redirect(route('provider.index'));
    }
}

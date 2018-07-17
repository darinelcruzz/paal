<?php

namespace App\Http\Controllers\Paal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    function index()
    {
        return view('paal.home');
    }
    
    function create()
    {
        //
    }
    
    function store(Request $request)
    {
        //
    }
    
    function show($id)
    {
        //
    }
    
    function edit($id)
    {
        //
    }
    
    function update(Request $request, $id)
    {
        //
    }
    
    function destroy($id)
    {
        //
    }
}

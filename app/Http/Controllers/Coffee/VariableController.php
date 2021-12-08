<?php

namespace App\Http\Controllers\Coffee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Variable;

class VariableController extends Controller
{
    function edit()
    {
        $variable = Variable::find(1);
        return view('coffee.variables.edit', compact('variable'));
    }

    function update(Request $request, Variable $variable)
    {
        $variable->update($request->validate(['value' => 'required']));

        // \Alert::success("El precio del dólar se cambió exitosamente")->persistent('Cerrar');

        return redirect(route('coffee.variable.edit'));
    }
}
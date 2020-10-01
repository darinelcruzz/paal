<?php

namespace App\Http\Controllers\Paal;

use Alert;
use App\Variable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VariableController extends Controller
{
    function edit(Variable $variable)
    {
        return view('paal.variables.edit', compact('variable'));
    }

    function update(Request $request, Variable $variable)
    {
        $variable->update($request->validate(['value' => 'required']));

        Alert::success("Se " . ($variable->value > 0 ? 'activó': 'desactivó') . " la opción DESFASADAS exitosamente")->persistent('Cerrar');

        return redirect(route('paal.variable.edit', $variable));
    }
}

<?php

namespace App\Http\Controllers;

use App\Egress;
use Illuminate\Http\Request;

class EgressController extends Controller
{
    function index()
    {
        $egresses = Egress::where('status', '!=', 'cancelado')->get();
        return view('paal.egresses.index', compact('egresses'));
    }

    function cancel(Egress $egress)
    {
        return view('paal.egresses.cancel', compact('egress'));
    }

    function destroy(Request $request, Egress $egress)
    {
        $this->validate($request, [
            'observations' => 'required'
        ]);

        $egress->update([
            'observations' => $request->observations,
            'user' => $request->user,
            'status' => 'cancelado'
        ]);

        return redirect(route('paal.egress.index'));
    }

    function settle()
    {
        return;
    }
}

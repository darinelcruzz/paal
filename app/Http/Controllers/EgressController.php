<?php

namespace App\Http\Controllers;

use App\Egress;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EgressesByDateExport;

class EgressController extends Controller
{
    function index()
    {
        $egresses = Egress::where('status', '!=', 'cancelado')->get();
        return view('paal.egresses.index', compact('egresses'));
    }

    function destroy(Request $request)
    {
        $this->validate($request, [
            'observations' => 'required'
        ]);

        $egress = Egress::find($request->id);

        $egress->update([
            'observations' => $request->observations,
            'user' => $request->user,
            'status' => 'cancelado'
        ]);

        return redirect(route('paal.egress.index'));
    }

    function export()
    {
        return Excel::download(new EgressesByDateExport, 'egresos.xlsx');
    }
}

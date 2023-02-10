<?php

namespace App\Http\Controllers;

use App\{Company, Store, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('enterprise:id,name', 'store:id,name')->get();
        return view('paal.users.index', compact('users'));
    }

    public function create()
    {
        $companies = Company::pluck('name', 'id');
        $stores1 = Store::whereCompanyId(1)->pluck('name', 'id');
        $stores2 = Store::whereCompanyId(2)->pluck('name', 'id');
        $stores3 = Store::whereCompanyId(3)->pluck('name', 'id');
        return view('paal.users.create', compact('companies', 'stores1', 'stores2', 'stores3'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed',
            'company_id' => 'required',
            'store_id' => 'required',
            'level' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'company_id' => $request->company_id,
            'store_id' => $request->store_id,
            'level' => $request->level,
        ]);

        return redirect(route('paal.user.index'));
    }

    public function edit(User $user)
    {
        return view('paal.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'confirmed',
            'company' => 'sometimes|required',
            'level' => 'sometimes|required',
        ]);

        $user->update($request->except('password', 'password_confirmation'));

        if ($request->password != '') {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect(route('paal.user.index'));
    }

    public function destroy(User $user)
    {
        //
    }
}

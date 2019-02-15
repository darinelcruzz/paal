<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('paal.users.index', compact('users'));
    }

    public function create()
    {
        return view('paal.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed',
            'company' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'company' => $request->company,
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

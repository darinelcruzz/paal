<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    use ThrottlesLogins;

	public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended($request->company);
        }

        $company = substr(redirect()->intended()->getTargetUrl(), strlen(env('APP_URL')));

        // dd($company);

        return view('auth.login', compact('company'));
    }
    
}

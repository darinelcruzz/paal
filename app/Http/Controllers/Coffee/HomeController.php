<?php

namespace App\Http\Controllers\Coffee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Task, User};

class HomeController extends Controller
{
    public function index($store = null)
    {
        if ($store != null) {
            $user = User::find(auth()->user()->id);
            $user->update(['store_id' => $store]);

            return back();
        }
        // Task::where('status', 'pendiente')->where('assigned_at', '<', date('Y-m-d'))->update(['status' => 'vencida']);
        return view('coffee.home');
    }
}

<?php

namespace App\Http\Controllers\Sanson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;

class HomeController extends Controller
{
    public function index()
    {
        Task::where('status', 'pendiente')->where('assigned_at', '<', date('Y-m-d'))->update(['status' => 'vencida']);
        return view('sanson.home');
    }
}

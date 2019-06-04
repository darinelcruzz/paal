<?php

namespace App\Http\Controllers\Coffee;

use Alert;
use App\{Task, User};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    function index()
    {
        $tasks = Task::all();

        return view('coffee.tasks.index', compact('tasks'));
    }

    function create()
    {
        $users = User::whereCompany('coffee')
            ->where('level', '!=', 0)
            ->pluck('name', 'id')
            ->toArray();

        return view('coffee.tasks.create', compact('users'));
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required',
            'assigned_to' => 'required',
            'assigned_at' => 'required',
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect(route('coffee.task.index'));
    }

    function edit()
    {
        $variable = Task::find(1);
        return view('coffee.variables.edit', compact('variable'));
    }

    function update(Request $request, Task $variable)
    {
        $variable->update($request->validate(['value' => 'required']));

        Alert::success("El precio del dólar se cambió exitosamente")->persistent('Cerrar');

        return redirect(route('coffee.variable.edit'));
    }
}
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

    function edit(Task $task)
    {
        return view('coffee.tasks.edit', compact('task'));
    }

    function update(Request $request, Task $task)
    {
        $request->validate(['observations' => 'required']);

        $task->update([
            'observations' => $request->observations,
            'status' => 'terminada',
        ]);

        return redirect(route('coffee.task.index'));
    }

    function change(Task $task, $status)
    {
        $task->update(['status' => $status]);

        return redirect(route('coffee.task.index'));
    }
}
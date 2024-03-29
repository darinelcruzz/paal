<?php

namespace App\Http\Controllers\Coffee;

use Alert;
use App\{Task, User, Category};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\TaskAssigned;
use App\Notifications\TaskCreatedAndAssigned;
use App\Notifications\TaskMarkedAsFinished;
use App\Notifications\TaskNotAccepted;
use App\Notifications\TaskAccepted;

class TaskController extends Controller
{
    function index($thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest('Y-m'): $thisDate;
        $user_id = auth()->user()->id;

        $mytasks = Task::where('company', 'coffee')
            ->where('assigned_to', $user_id)
            ->whereMonth('assigned_at', substr($date, 5, 7))
            ->whereYear('assigned_at', substr($date, 0, 4))
            ->orWhere(function ($query) use ($user_id) {
                $query->whereIn('status', ['pendiente', 'terminada'])
                    ->where('assigned_to', $user_id);
            })
            ->with('user:id,name', 'tasker:id,name')
            ->get();


        $tasks = Task::where('company', 'coffee')
            ->where('assigned_by', $user_id)
            ->whereMonth('assigned_at', substr($date, 5, 7))
            ->whereYear('assigned_at', substr($date, 0, 4))
            ->orWhere(function ($query) use ($user_id) {
                $query->whereIn('status', ['pendiente', 'terminada'])
                    ->where('assigned_by', $user_id);
            })
            ->where('status', 'pendiente')
            ->with('user:id,name', 'tasker:id,name')
            ->get();

        return view('coffee.tasks.index', compact('tasks', 'mytasks', 'date'));
    }

    function create()
    {
        $categories = Category::whereType('tareas')->pluck('name', 'id')->toArray();

        $users = User::where('company', '!=', 'mbe')
            ->where('level', '>', auth()->user()->level)
            ->pluck('name', 'id')
            ->toArray();

        return view('coffee.tasks.create', compact('users', 'categories'));
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required',
            'category_id' => 'required',
            'assigned_at' => 'required',
        ]);

        $task = auth()->user()->tasks()->create($validated + ['assigned_to' => $request->assigned_to, 'status' => 'pendiente']);

        return redirect(route('coffee.task.index'));
    }

    function edit(Task $task)
    {
        $users = User::where('company', '!=', 'mbe')
            ->where('level', '>', auth()->user()->level)
            ->pluck('name', 'id')
            ->toArray();
        $categories = Category::whereType('tareas')->pluck('name', 'id')->toArray();
        return view('coffee.tasks.edit', compact('task', 'categories', 'users'));
    }

    function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'description' => 'required',
            'category_id' => 'required',
            'assigned_at' => 'required',
        ]);

        $task->update($request->all());

        return redirect(route('coffee.task.index'));
    }

    function complete(Request $request, Task $task, $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest('Y-m'): $thisDate;

        $attributes = $request->validate(['observations' => 'required', 'status' => 'required']);

        $sign = $request->status == 'terminada' ? '+ ': '- ';

        $task->update([
            'status' => $request->status,
            'observations' => strlen($task->observations) > 0 ? $task->observations . '<br>' . $sign . $request->observations: '+ ' . $request->observations
        ]);

        if ($task->status == 'terminada') {
            $task->update(['completed_at' => date('Y-m-d')]);
        }

        return redirect(route('coffee.task.index', $date));
    }

    function change(Task $task, $status, $thisDate = null)
    {
        $date = $thisDate == null ? dateFromRequest('Y-m'): $thisDate;

        $task->update(['status' => $status]);

        return redirect(route('coffee.task.index', $date));
    }
}

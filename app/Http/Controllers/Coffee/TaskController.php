<?php

namespace App\Http\Controllers\Coffee;

use Alert;
use App\{Task, User};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\TaskAssigned;
use App\Notifications\TaskCreatedAndAssigned;
use App\Notifications\TaskMarkedAsFinished;
use App\Notifications\TaskNotAccepted;
use App\Notifications\TaskAccepted;

class TaskController extends Controller
{
    function index()
    {
        $tasks = Task::where('assigned_to', auth()->user()->id)->orWhere('assigned_by', auth()->user()->id)->get();

        return view('coffee.tasks.index', compact('tasks'));
    }

    function create()
    {
        $users = User::whereCompany('coffee')
            ->where('level', '>', auth()->user()->level)
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

        $task = auth()->user()->tasks()->create($validated + ['status' => 'pendiente']);

        if ($task->user->telegram_user_id) {
            $task->notify(new TaskCreatedAndAssigned($task->user));
        }

        return redirect(route('coffee.task.index'));
    }

    function edit(Task $task)
    {
        return view('coffee.tasks.edit', compact('task'));
    }

    function update(Request $request, Task $task)
    {
        $attributes = $request->validate(['observations' => 'required', 'status' => 'required']);

        $sign = $request->status == 'terminada' ? '+ ': '- ';

        $task->update([
            'status' => $request->status,
            'observations' => strlen($task->observations) > 0 ? $task->observations . '<br>' . $sign . $request->observations: '+ ' . $request->observations
        ]);

        if ($task->status == 'terminada') {
            $task->update(['completed_at' => date('Y-m-d')]);
            
            if ($task->tasker->telegram_user_id) {
                $task->notify(new TaskMarkedAsFinished);
            }

        } else {
           $task->update([
            'completed_at' => null,
            'repetitions' => $task->repetitions + 1
           ]);

           if ($task->user->telegram_user_id) {
               $task->notify(new TaskNotAccepted($request->observations));
           }
        }

        return redirect(route('coffee.task.index'));
    }

    function change(Task $task, $status)
    {
        $task->update(['status' => $status]);

        if ($task->status == 'aceptada' && $task->user->telegram_id) {
            $task->notify(new TaskAccepted);
        }

        return redirect(route('coffee.task.index'));
    }
}
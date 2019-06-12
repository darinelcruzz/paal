@component('mail::message')
Hola, **{{ $task->user->name }}**, se te ha asginado la siguiente tarea:

#{{ $task->description }}

Por favor, completala antes del:

#{{ fdate($task->assigned_at, 'l j \d\e F, Y', 'Y-m-d') }}

@component('mail::button', ['url' => url('/coffee/tareas')])
Ver detalles
@endcomponent

Gracias que tengas buen día<br>
{{ config('app.name') }}
@endcomponent

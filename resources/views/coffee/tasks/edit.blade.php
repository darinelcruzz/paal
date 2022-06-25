@extends('coffee.root')

@push('pageTitle', 'Tareas | Editar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Editar tarea" color="warning">

                {!! Form::open(['method' => 'POST', 'route' => ['coffee.task.update', $task]]) !!}

                    {!! Field::textarea('description', $task->description ,['tpl' => 'withicon', 'rows' => '2'], ['icon' => 'comments']) !!}

                    {!! Field::select('category_id', $categories, $task->category_id, ['label' => 'Rubro', 'tpl' => 'withicon', 'empty' => 'Seleccione un rubro'], ['icon' => 'tags']) !!}

                    {!! Field::select('assigned_to', $users, $task->assigned_to, ['label' => 'Asignar a (opcional)', 'tpl' => 'withicon', 'empty' => 'Seleccione un usuario'], ['icon' => 'user']) !!}

                    {!! Field::date('assigned_at', $task->assigned_at , ['label' => 'Fecha límite', 'tpl' => 'withicon'], ['icon' => 'calendar-alt']) !!}

                    <hr>
                    
                    <button type="submit" class="btn btn-warning pull-right">EDITAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
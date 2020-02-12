@extends('sanson.root')

@push('pageTitle', 'Tareas | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar tarea nueva" color="info">

                {!! Form::open(['method' => 'POST', 'route' => 'sanson.task.store']) !!}

                    {!! Field::textarea('description', ['tpl' => 'withicon', 'rows' => '2'], ['icon' => 'comments']) !!}

                    {!! Field::select('assigned_to', $users, null, ['label' => 'Asignar a', 'tpl' => 'withicon', 'rows' => '2', 'empty' => 'Seleccione un usuario'], ['icon' => 'user']) !!}

                    {!! Field::date('assigned_at', today(), ['label' => 'Fecha límite', 'tpl' => 'withicon'], ['icon' => 'calendar-alt']) !!}

                    <hr>
                    <input type="hidden" name="company" value="sanson">
                    
                    <button type="submit" class="btn btn-info pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
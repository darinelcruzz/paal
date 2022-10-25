@extends('coffee.root')

@push('pageTitle', 'Tareas | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar tarea nueva" color="warning">

                {!! Form::open(['method' => 'POST', 'route' => 'coffee.task.store']) !!}

                    {!! Field::textarea('description', ['tpl' => 'withicon', 'rows' => '2'], ['icon' => 'comments']) !!}

                    {!! Field::select('category_id', $categories, null, ['label' => 'Rubro', 'tpl' => 'withicon', 'empty' => 'Seleccione un rubro'], ['icon' => 'tags']) !!}

                    {!! Field::select('assigned_to', $users, null, ['label' => 'Asignar a (opcional)', 'tpl' => 'withicon', 'empty' => 'Seleccione un usuario'], ['icon' => 'user']) !!}

                    {!! Field::date('assigned_at', today(), ['label' => 'Fecha límite', 'tpl' => 'withicon'], ['icon' => 'calendar-alt']) !!}

                    <hr>
                    
                    <button type="submit" class="btn btn-warning pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
@extends('mbe.root')

@push('pageTitle')
    Tareas | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar tarea nueva" color="success">

                {!! Form::open(['method' => 'POST', 'route' => 'mbe.task.store']) !!}

                    {!! Field::textarea('description', ['tpl' => 'withicon', 'rows' => '2'], ['icon' => 'comments']) !!}

                    {!! Field::select('assigned_to', $users, null, ['label' => 'Asignar a', 'tpl' => 'withicon', 'rows' => '2', 'empty' => 'Seleccione un usuario'], ['icon' => 'user']) !!}

                    {!! Field::date('assigned_at', today(), ['label' => 'Fecha límite', 'tpl' => 'withicon'], ['icon' => 'calendar-alt']) !!}

                    <hr>
                    
                    <button type="submit" class="btn btn-success pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
@extends('paal.root')

@push('pageTitle')
    Desactivar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            <solid-box title="Des/Activar" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => ['paal.variable.update', $variable]]) !!}

                    {!! Field::select('value', ['Desactivar', 'Activar'], !$variable->value, ['label' => 'Desfasadas', 'empty' => false],
                        ['tpl' => 'withicon'], ['icon' => 'toggle-on']) 
                    !!}

                    <p>
                        Actualmente: <strong>{{ $variable->value ? 'ACTIVADO': 'DESACTIVADO'}}</strong>
                    </p>

                    <hr>
                    
                    <button type="submit" class="btn btn-primary pull-right">MODIFICAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

    @include('sweet::alert')

@endsection

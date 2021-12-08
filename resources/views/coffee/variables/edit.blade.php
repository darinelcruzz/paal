@extends('coffee.root')

@push('pageTitle')
    Tipo de cambio | Editar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            <solid-box title="Editar tipo de cambio" color="danger" button>

                {!! Form::open(['method' => 'POST', 'route' => ['coffee.variable.update', $variable]]) !!}

                    {!! Field::text('value', $variable->value, ['tpl' => 'withicon'], ['icon' => 'usd']) !!}

                    <hr>
                    
                    <button type="submit" class="btn btn-danger pull-right">MODIFICAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

    {{-- @include('sweet::alert') --}}

@endsection
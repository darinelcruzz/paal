@extends('lte.root')

@push('pageTitle')
    PAAL | Inicio
@endpush

@push('headerTitle')
    Inicio <small>COMIENZA AQUÍ</small>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Una caja" color="success" button>
                {!! Field::text('name', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                {!! Field::text('last_name', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                {!! Field::number('phone', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                {!! Field::number('age', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                {!! Field::text('address', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                {!! Field::text('city', ['tpl' => 'withicon'], ['icon' => 'user']) !!}

                {!! Form::submit('Guardar', ['class' => 'btn btn-success btn-block']) !!}
            </solid-box>
        </div>
    </div>

@endsection

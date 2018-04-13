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
                <p>
                    Hola
                </p>

                {!! Form::submit('Botón', ['class' => 'btn btn-success pull-right']) !!}
            </solid-box>
        </div>
    </div>

@endsection
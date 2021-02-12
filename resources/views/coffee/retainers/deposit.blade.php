@extends('coffee.root')

@push('pageTitle', 'Abonos | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Sumar abono al anticipo {{ $retainer->folio }}" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.retainer.deposit', $retainer]]) !!}

                    <payment-methods></payment-methods>

                    {!! Form::submit('S U M A R', ['class' => 'pull-right btn btn-danger btn-md']) !!}
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection

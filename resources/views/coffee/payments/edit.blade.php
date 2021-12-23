@extends('coffee.root')

@push('pageTitle', 'Editar pago')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Editar pago (total: {{ number_format($total, 2) }})" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.payment.update', $payment]]) !!}

                    <div class="row">
                        <div class="col-md-12">
                            <payment-methods :amount="{{ $total }}" :payment="{{ $payment }}"></payment-methods>
                        </div>
                    </div>

                    {!! Form::submit('CORREGIR', ['class' => 'btn btn-danger pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
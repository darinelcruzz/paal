@extends('coffee.root')

@push('pageTitle')
    Ingresos | Pagar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar pago" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.payment.store', $ingress]]) !!}

                    <div class="row">
                        <div class="col-md-12">
                            <payment-methods :amount="{{ $ingress->debt }}"></payment-methods>
                        </div>
                    </div>
                    
                    <input type="hidden" name="type" value="abono">

                    {!! Form::submit('PAGAR', ['class' => 'btn btn-danger pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
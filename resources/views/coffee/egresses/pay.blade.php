@extends('coffee.root')

@push('pageTitle')
    Egresos | Pagar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Detalles del pago" color="danger" button>
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.egress.charge', $egress]]) !!}

                    @if($egress->payments->count() == 0)
                        {!! Field::select('single_payment', ['Sí, un sólo pago', 'No, es el primero de varios'], 0,
                            ['tpl' => 'withicon', 'label' => '¿Pago único?', 'empty' => 'Elija una opción'], ['icon' => 'question']) 
                        !!}
                    @else
                        <input type="hidden" name="single_payment" :value="1">
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('folio', ['label' => 'Folio', 'tpl' => 'withicon', 'ph' => 'XXXXXX'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::date('paid_at', Date::now(), ['label' => 'Fecha pago', 'tpl' => 'withicon'], ['icon' => 'dollar']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('method', ['check' => 'Cheque', 'transfer' => 'Transferencia', 'automatic' => 'Domiciliación'], null,
                                ['label' => 'Método', 'tpl' => 'withicon', 'empty' => 'Seleccione método'], ['icon' => 'credit-card']) 
                            !!}
                        </div>

                        <div class="col-md-6">
                            {!! Field::number('amount', $egress->debt, ['label'=> 'Cantidad', 'tpl' => 'withicon', 'step' => '0.01'], ['icon' => 'money']) !!}
                        </div>
                    </div>

                    <hr>

                    {!! Form::submit('P A G A R', ['class' => 'btn btn-danger pull-right btn-block']) !!}
                    
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection

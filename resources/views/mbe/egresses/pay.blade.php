@extends('mbe.root')

@push('pageTitle', 'EGRESOS | PAGAR')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Detalles del pago" color="success" button>
                {!! Form::open(['method' => 'POST', 'route' => ['mbe.egress.charge', $egress]]) !!}

                    {{-- @if ($egress->method)
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::text('nfolio', ['label' => 'Folio', 'tpl' => 'withicon', 'ph' => 'XXXXXX'], ['icon' => 'barcode']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::date('second_payment_date', Date::now(), ['label' => 'Fecha pago', 'tpl' => 'withicon'], ['icon' => 'dollar']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::select('second_method', ['check' => 'Cheque', 'transfer' => 'Transferencia', 'automatic' => 'Domiciliación'], null,
                                    ['label' => 'Método', 'tpl' => 'withicon', 'empty' => 'Seleccione método'], ['icon' => 'credit-card']) 
                                !!}
                            </div>
                        </div>
                            
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::text('mfolio', ['label' => 'Folio', 'tpl' => 'withicon', 'ph' => 'XXXXXX'], ['icon' => 'barcode']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::date('payment_date', Date::now(), ['tpl' => 'withicon'], ['icon' => 'dollar']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::select('method', ['check' => 'Cheque', 'transfer' => 'Transferencia', 'automatic' => 'Domiciliación'], null,
                                    ['tpl' => 'withicon', 'empty' => 'Seleccione método'], ['icon' => 'credit-card']) 
                                !!}
                            </div>
                            <div class="col-md-6">                        
                                {!! Field::select('single_payment', ['Sí, un sólo pago', 'No, es el primero de dos'], 0,
                                    ['tpl' => 'withicon', 'label' => '¿Pago único?', 'empty' => 'Elija una opción'], ['icon' => 'question']) 
                                !!}
                            </div>
                        </div>
                    @endif --}}

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

                    {!! Form::submit('P A G A R', ['class' => 'btn btn-success pull-right btn-block']) !!}
                    
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
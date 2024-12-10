@extends('coffee.root')

@push('pageTitle', 'Editar pago')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Editar venta de {{ $ingress->client->name}} ({{ $ingress->folio }})" color="warning">
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.payment.update', $payment]]) !!}

                    <h5>VENTA</h5>
                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            {!! Field::select('invoice', ['no' => 'No require factura', 'G01' => 'G01 Adquisición de mercancías', 'G03' => 'G03 Gastos en general', 'P01' => 'P01 Por definir','I08' => 'I08 Otra maquinaria y equipo', 'otro' => 'Otro'], $ingress->invoice,
                                ['label' => 'Uso de CFDI', 'tpl' => 'withicon', 'empty' => 'Elegir uso de CFDI'],
                                ['icon' => 'file-invoice'])
                            !!}
                        </div>
                    </div>

                    <h5>PAGO</h5>
                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <payment-methods :amount="{{ $ingress->amount }}" :payment="{{ $payment }}"></payment-methods>
                        </div>
                    </div>

                    <input type="hidden" name="update_path" value="edit">

                    {!! Form::submit('CORREGIR', ['class' => 'btn btn-warning pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
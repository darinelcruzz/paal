@extends('coffee.root')

@push('pageTitle')
    Ingresos | Pagar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar pago" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.ingress.pay', $ingress]]) !!}

                <div class="row">
                    <div class="col-md-6">
                        {!! Field::select('type', ['abono' => 'Abono', 'liquidación' => 'Liquidación'], 'abono',
                            ['tpl' => 'withicon', 'empty' => 'Tipo de pago'],
                            ['icon' => 'question'])
                        !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="control-group">
                            <label>Total a pagar:</label>
                            <span class="form-control" style="color: green;">
                                <b>{{ $ingress->debt }}</b>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        {!! Field::number('cash', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'usd']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! Field::number('debit_card', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'usd']) !!}
                        {!! Field::number('transfer', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'usd']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Field::number('credit_card', 0, ['tpl' => 'withicon', 'step' => '0.01'], ['icon' => 'usd']) !!}
                        {!! Field::number('check', 0, ['tpl' => 'withicon', 'step' => '0.01'], ['icon' => 'usd']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        {!! Field::text('reference', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                    </div>
                </div>

                    <input type="hidden" name="ingress_id" value="{{ $ingress->id }}">

                    {!! Form::submit('PAGAR', ['class' => 'btn btn-danger pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection

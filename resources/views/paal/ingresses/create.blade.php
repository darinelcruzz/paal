@extends('paal.root')

@push('pageTitle')
    Ingresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-7">
            <solid-box title="Agregar ingreso" color="{{ $company == 'coffee' ? 'danger': 'success'}}" button>
                {!! Form::open(['method' => 'POST', 'route' => 'paal.ingress.store']) !!}

                    {!! Field::select('client_id', $clients, null,
                        ['tpl' => 'withicon', 'empty' => 'Seleccione un cliente'],
                        ['icon' => 'user'])
                    !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::date('bought_at', Date::now(), ['tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::date('paid_at', Date::now(), ['tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('amount', 0, ['tpl' => 'withicon', 'min' => '0', 'step' => '0.01'], ['icon' => 'dollar']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('iva', 0, ['tpl' => 'withicon', 'min' => '0', 'step' => '0.01'], ['icon' => 'scissors']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('method', ['1' => 'Efectivo', '2' => 'Transferencia', '3' => 'Cheque',
                                '4' => 'Tarjeta de débito', '5' => 'Tarjeta de crédito'],
                                null, ['tpl' => 'withicon', 'empty' => 'Elija forma de pago'], ['icon' => 'credit-card'])
                            !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('operation_number', ['tpl' => 'withicon'], ['icon' => 'list']) !!}
                        </div>
                    </div>
                    <input type="hidden" name="company" value="{{ $company }}">
                    <input type="hidden" name="status" value="pagado">
                    <hr>
                    <button type="submit" class="btn btn-{{ $company == 'coffee' ? 'danger': 'success'}} pull-right" onclick="submitForm(this);">Agregar</button>

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection

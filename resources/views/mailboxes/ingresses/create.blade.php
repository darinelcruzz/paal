@extends('mailboxes.root')

@push('pageTitle')
    Ingresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-7">
            <solid-box title="Agregar ingreso" color="success" button>
                {!! Form::open(['method' => 'POST', 'route' => 'mbe.ingress.store', 'enctype' => 'multipart/form-data']) !!}

                    {!! Field::select('client_id', $clients, null,
                        ['tpl' => 'withicon', 'label' => 'Cliente', 'empty' => 'Seleccione un cliente'],
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
                            {!! Field::select('method', $methods, null,
                                ['tpl' => 'withicon', 'empty' => 'Seleccione forma de pago'],
                                ['icon' => 'credit-card'])
                            !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('operation_number', ['tpl' => 'withicon'], ['icon' => 'list']) !!}
                        </div>
                    </div>

                    <hr>
                    <input type="hidden" name="company" value="mbe">
                    <input type="hidden" name="status" value="pagado">
                    <button type="submit" class="btn btn-success pull-right" onclick="submitForm(this);">Agregar</button>

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection

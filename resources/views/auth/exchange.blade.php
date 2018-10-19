@extends('paal.root')

@push('pageTitle')
    Tipo de cambio
@endpush

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="Modificar valor del dólar" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => 'paal.exchange.update']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('exchange_rate', env('EXCHANGE_RATE'), 
                                ['tpl' => 'withicon', 'min' => '0', 'step' => '0.01', 'label' => 'Tipo de cambio'], 
                                ['icon' => 'usd'])
                            !!}  
                        </div>
                        <div class="col-md-6">
                            <span class="pull-right"><em>actualmente:</em> <b>$ {{ number_format(env('EXCHANGE_RATE'), 2) }}</b></span>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary pull-right">
                        <i class="fa fa-refresh"></i> &nbsp;&nbsp; ACTUALIZAR
                    </button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
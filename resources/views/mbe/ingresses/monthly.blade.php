@extends('mbe.root')

@push('pageTitle')
    Corte mensual
@endpush

@section('content')

    <div class="row">

        <div class="col-md-9">

            {!! Form::open(['method' => 'post', 'route' => 'mbe.ingress.monthly']) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}

            <br>

        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <color-card color="green" icon="money-bill-wave" label="Total">
                <em>$ {{ number_format($month->sum('cash') + $month->sum('credit_card') + $month->sum('debit_card') + $month->sum('transfer') + $month->sum('check'), 2) }}</em>
            </color-card>

            <color-card color="red" icon="piggy-bank" label="Por depositar">
                <em>$ {{ number_format($pending, 2) }}</em>
            </color-card>

            <color-card color="yellow" icon="credit-card" label="Crédito">
                <em>$ {{ number_format($credit_total, 2) }}</em>
            </color-card>

            <color-card color="primary" icon="truck" label="Envíos">
                <em>{{ $shippings }}</em>
            </color-card>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <color-card color="aqua" label="<big>Efectivo</big>">
                        <small style="color: white">$ {{ number_format($month->sum('cash'), 2) }}</small>
                    </color-card>
                </div>
                <div class="col-md-4">
                    <color-card color="aqua" label="<big>Tarjeta de crédito</big>">
                        <small style="color: white">$ {{ number_format($month->sum('credit_card'), 2) }}</small>
                    </color-card>
                </div>
                <div class="col-md-4">
                    <color-card color="aqua" label="<big>Tarjeta de débito</big>">
                        <small style="color: white">$ {{ number_format($month->sum('debit_card'), 2) }}</small>
                    </color-card>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <color-card color="aqua" label="<big>Transferencia</big>">
                        <small style="color: white">$ {{ number_format($month->sum('transfer'), 2) }}</small>
                    </color-card>
                </div>
                <div class="col-md-4">
                    <color-card color="aqua" label="<big>Cheque</big>">
                        <small style="color: white">$ {{ number_format($month->sum('check'), 2) }}</small>
                    </color-card>
                </div>
            </div>
        </div>
    </div>

@endsection
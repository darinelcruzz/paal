@extends('coffee.root')

@push('pageTitle', 'Corte mensual')

@section('content')

    <div class="row">

        <div class="col-md-9">

            {!! Form::open(['method' => 'post', 'route' => 'coffee.admin.monthly']) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
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
            <div class="small-box bg-green">
                <div class="inner">
                    <p>Total Mensual</p>
                    <h3><em>{{ number_format($ingresses->sum(function ($ingress) { return $ingress->type != 'anticipo' ? $ingress->amount - $ingress->retainers->sum('amount'): $ingress->amount;}), 2) }}</em></h3>
                </div>
                <div class="icon">
                    <i class="fa fa-usd"></i>
                </div>
            </div>

            <div class="small-box bg-red">
                <div class="inner">
                    <p>Por depositar</p>
                    <h3>
                        <em>
                            {{ number_format($ingresses->sum(function ($ingress) { return $ingress->payments->where('cash_reference', null)->sum('cash');}), 2) }}
                        </em>
                    </h3>
                </div>
                <div class="icon">
                    <i class="fa fa-piggy-bank"></i>
                </div>
            </div>

            <div class="small-box bg-primary">
                <div class="inner">
                    <p>Promedio</p>
                    <h3>
                        <em>
                            {{ number_format($ingresses->sum(function ($ingress) { return $ingress->type != 'anticipo' ? $ingress->amount - $ingress->retainers->sum('amount'): $ingress->amount;}) / $divisor, 2) }}
                        </em>
                    </h3>
                </div>
                <div class="icon">
                    <i class="fa fa-chart-line"></i>
                </div>
            </div>

            <div class="small-box bg-yellow">
                <div class="inner">
                    <p>Envíos</p>
                    <h3><em>{{ $shippings }}</em></h3>
                </div>
                <div class="icon">
                    <i class="fa fa-shipping-fast"></i>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <big>Efectivo</big>
                            <h3>
                                <small style="color: white">{{ number_format($ingresses->sum('cash'), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <big>Tarjeta de crédito</big>
                            <h3>
                                {{-- <small style="color: white">$ {{ number_format($month->sum('credit_card'), 2) }}</small> --}}
                                <small style="color: white">{{ number_format($ingresses->sum(function ($ingress) { return $ingress->payments->sum('credit_card');}), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <big>Tarjeta de débito</big>
                            <h3>
                                <small style="color: white">{{ number_format($ingresses->sum(function ($ingress) { return $ingress->payments->sum('debit_card');}), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <big>Transferencia</big>
                            <h3>
                                <small style="color: white">{{ number_format($ingresses->sum(function ($ingress) { return $ingress->payments->sum('transfer');}), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <big>Cheque</big>
                            <h3>
                                <small style="color: white">{{ number_format($ingresses->sum(function ($ingress) { return $ingress->payments->sum('check');}), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <big>Insumos</big>
                            <h3>
                                <small style="color: white">{{ number_format($ingresses->sum(function ($ingress) { return $ingress->type == 'insumos' ? $ingress->amount: 0;}), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-navy">
                        <div class="inner">
                            <big>Equipo</big>
                            <h3>
                                <small style="color: white">
                                    {{ number_format($ingresses->sum(function ($ingress) { 
                                            return $ingress->movements->sum(function ($m) {
                                                return $m->product->category == 'EQUIPO' ? $m->total: 0;
                                            });
                                        }), 2) 
                                    }}
                                </small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <big>Anticipo</big>
                            <h3>
                                <small style="color: white">{{ number_format($ingresses->sum(function ($ingress) { return $ingress->type == 'anticipo' ? $ingress->amount - $ingress->retainers->sum('amount'): 0;}), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <big>Notas de crédito</big>
                            <h3>
                                <small>-{{ number_format($ingresses->sum(function ($ingress) { return $ingress->type == 'nota de crédito' ? $ingress->amount: 0;}), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <big>Depositado BBVA</big>
                            <h3>
                                <small style="color: white;">{{ number_format($ingresses->sum(function ($ingress) { return $ingress->payments->where('cash_reference', '!=', null)->sum('cash');}), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

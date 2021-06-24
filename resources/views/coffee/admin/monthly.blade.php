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
                    <p>TOTAL MENSUAL</p>
                    <h3>
                        {{-- <em>{{ number_format($ingresses->sum(function ($ingress) { return $ingress->type != 'anticipo' ? $ingress->amount - $ingress->retainers->sum('amount'): $ingress->amount;}), 2) }}</em>--}}
                        <em>{{ number_format($ingresses->sum('amount'), 2) }}</em>
                    </h3>
                </div>
                <div class="icon">
                    <i class="fa fa-usd"></i>
                </div>
            </div>

            <div class="small-box bg-red">
                <div class="inner">
                    <p>POR DEPOSITAR</p>
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
                    <p>PROMEDIO</p>
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
                    <p>ENVÍOS</p>
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
                            EFECTIVO
                            <h3>
                                <small style="color: white">{{ number_format($ingresses->sum('cash'), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            TARJETA DE CRÉDITO
                            <h3>
                                <small style="color: white">
                                    {{ number_format($ingresses->sum(function ($ingress) { return $ingress->payments->sum('credit_card');}), 2) }}
                                </small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            TARJETA DE DÉBITO
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
                            TRANSFERENCIA
                            <h3>
                                <small style="color: white">{{ number_format($ingresses->sum(function ($ingress) { return $ingress->payments->sum('transfer');}), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            CHEQUE
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
                            INSUMOS
                            <h3>
                                {{-- function ($ingress) { return $ingress->type == 'insumos' ? $ingress->amount: 0;} --}}
                                {{-- <small style="color: white">{{ number_format($ingresses->where('type', 'insumos')->sum('amount'), 2) }}</small> --}}
                                <small style="color: white">
                                    {{ number_format($ingresses->where('type', 'insumos')->sum('amount') + $ingresses->where('type', 'proyecto')->sum(function ($ingress) { 
                                            return $ingress->movements->sum(function ($m) use ($ingress){
                                                return $m->product->category == 'INSUMOS' ? $m->total: 0;
                                            });
                                        }), 2) 
                                    }}
                                </small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-navy">
                        <div class="inner">
                            EQUIPO
                            <h3>
                                <small style="color: white">
                                    {{ number_format($ingresses->sum(function ($ingress) { 
                                            return $ingress->movements->sum(function ($m) use ($ingress){
                                                return $m->product->category == 'EQUIPO' ? $m->total + $ingress->iva : 0;
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
                            ANTICIPO
                            <h3>
                                <small style="color: white">{{ number_format($ingresses->where('type', 'anticipo')->sum('amount'), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            NOTAS DE CRÉDITO
                            <h3>
                                <small>-{{ number_format($ingresses->where('type', 'nota de crédito')->sum('amount'), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            DEPOSITADO BBVA
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

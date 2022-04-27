@extends('sanson.root')

@push('pageTitle', 'Corte mensual')

@section('content')

    <div class="row">

        <div class="col-md-9">

            {!! Form::open(['method' => 'post', 'route' => 'sanson.admin.monthly']) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
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
            <icon-box title="total mensual" color="green" icon="usd" company="sanson" model="index" type="total" date="{{ $date }}"></icon-box>
            <icon-box title="por depositar" color="red" icon="piggy-bank" company="sanson" model="index" type="depositar" date="{{ $date }}"></icon-box>
            <icon-box title="promedio" color="primary" icon="chart-line" company="sanson" model="index" type="promedio" date="{{ $date }}"></icon-box>
            <icon-box title="envíos" color="yellow" icon="shipping-fast" company="sanson" model="index" type="envíos" date="{{ $date }}"></icon-box>
        </div>


        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <info-box title="efectivo" color="aqua" company="sanson" type="efectivo" date="{{ $date }}" model="payments">
                    </info-box>
                </div>
                <div class="col-md-4">
                    <info-box title="tarjeta de crédito" color="aqua" company="sanson" type="tarjeta de crédito" date="{{ $date }}" model="payments">
                    </info-box>
                </div>
                <div class="col-md-4">
                    <info-box title="tarjeta de débito" color="aqua" company="sanson" type="tarjeta de débito" date="{{ $date }}" model="payments">
                    </info-box>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <info-box title="transferencia" color="aqua" company="sanson" type="transferencia" date="{{ $date }}" model="payments">
                    </info-box>
                </div>
                <div class="col-md-4">
                    <info-box title="cheque" color="aqua" company="sanson" type="cheque" date="{{ $date }}" model="payments">
                    </info-box>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <big>Equipos y refacciones</big>
                            <h3>
                                <small style="color: white">{{ number_format($ingresses->sum(function ($ingress) { return $ingress->type == 'equipo' ? $ingress->amount: 0;}), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <big>Proyectos</big>
                            <h3>
                                <small style="color: white">{{ number_format($ingresses->sum(function ($ingress) { return $ingress->type == 'proyecto' ? $ingress->amount: 0;}), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <big>Sanson equipo</big>
                            <h3>
                                <small style="color: white">$ {{ number_format($equipment * 1.16, 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-black">
                        <div class="inner">
                            <big>Imbera</big>
                            <h3>
                                <small style="color: white">$ {{ number_format($imbera * 1.16, 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-navy">
                        <div class="inner">
                            <big>Rhino</big>
                            <h3>
                                <small style="color: white">$ {{ number_format($rhino * 1.16, 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="small-box bg-maroon">
                        <div class="inner">
                            <big>Sanson refacciones</big>
                            <h3>
                                <small style="color: white">$ {{ number_format($refactions * 1.16, 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

@endsection

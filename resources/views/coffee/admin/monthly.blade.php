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
                                <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <icon-box title="total mensual" color="green" icon="usd" company="coffee" model="index" type="total" date="{{ $date }}"></icon-box>
            <icon-box title="por depositar" color="red" icon="piggy-bank" company="coffee" model="index" type="depositar" date="{{ $date }}"></icon-box>
            <icon-box title="promedio" color="primary" icon="chart-line" company="coffee" model="index" type="promedio" date="{{ $date }}"></icon-box>
            <icon-box title="envíos" color="yellow" icon="shipping-fast" company="coffee" model="index" type="envíos" date="{{ $date }}"></icon-box>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <info-box title="efectivo" color="aqua" company="coffee" type="efectivo" date="{{ $date }}" model="payments">
                    </info-box>
                </div>
                <div class="col-md-4">
                    <info-box title="tarjeta de crédito" color="aqua" company="coffee" type="tarjeta de crédito" date="{{ $date }}" model="payments">
                    </info-box>
                </div>
                <div class="col-md-4">
                    <info-box title="tarjeta de débito" color="aqua" company="coffee" type="tarjeta de débito" date="{{ $date }}" model="payments">
                    </info-box>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <info-box title="transferencia" color="aqua" company="coffee" type="transferencia" date="{{ $date }}" model="payments">
                    </info-box>
                </div>
                <div class="col-md-4">
                    <info-box title="cheque" color="aqua" company="coffee" type="cheque" date="{{ $date }}" model="payments">
                    </info-box>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <info-box title="no equipo" color="purple" company="coffee" type="no equipo" date="{{ $date }}" model="ingresses">
                    </info-box>
                </div>

                <div class="col-md-3">
                    <info-box title="equipo" color="navy" company="coffee" type="equipo" date="{{ $date }}" model="ingresses">
                    </info-box>
                </div>
                <div class="col-md-3">
                    <info-box title="anticipo" color="teal" company="coffee" type="anticipo" date="{{ $date }}" model="ingresses">
                    </info-box>
                </div>
                <div class="col-md-3">
                    <info-box title="notas de crédito" color="gray" company="coffee" type="nota de crédito" date="{{ $date }}" model="ingresses">
                    </info-box>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <info-box title="depositado bbva" color="blue" company="coffee" type="depositado" date="{{ $date }}" model="ingresses">
                    </info-box>
                </div>
            </div>
        </div>
    </div>

@endsection

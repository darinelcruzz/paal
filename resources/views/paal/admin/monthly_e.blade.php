@extends('paal.root')

@push('pageTitle')
    Egresos mensuales
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">                
            <div class="row">
                <div class="col-md-4">
                    {!! Form::open(['method' => 'post', 'route' => ['paal.egress.monthly', $company]]) !!}
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-{{ $company == 'coffee' ? 'danger': 'success' }} btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    {!! Form::close() !!}
                </div>

                <div class="col-md-8">
                    <a href="{{ route('paal.egress.monthly', $company == 'coffee' ? 'mbe': 'coffee') }}" class="btn btn-primary btn-xs pull-right">
                        <i class="fa fa-random fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-4">
            <color-card color="green" icon="usd" label="TOTAL {{ strtoupper($company) }}">
                <em>$ {{ number_format($total, 2) }}</em>
            </color-card>

            <color-card color="yellow" icon="coins" label="PENDIENTE">
                <em>$ {{ number_format($pending, 2) }}</em>
            </color-card>

            <color-card color="red" icon="stopwatch" label="VENCIDO">
                <em>$ {{ number_format($expired, 2) }}</em>
            </color-card>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-sm-3">
                    <color-card color="aqua" label="Generales">
                        <small style="color: white"><em>$ {{ number_format($general, 2) }}</em></small>
                    </color-card>
                </div>
                <div class="col-sm-3">
                    <color-card color="teal" label="Caja chica">
                        <small style="color: white"><em>$ {{ number_format($register, 2) }}</em></small>
                    </color-card>
                </div>
                <div class="col-sm-3">
                    <color-card color="aqua" label="Reposición">
                        <small style="color: white"><em>$ {{ number_format($reposition, 2) }}</em></small>
                    </color-card>
                </div>
                <div class="col-sm-3">
                    <color-card color="teal" label="Extras">
                        <small style="color: white"><em>$ {{ number_format($extra, 2) }}</em></small>
                    </color-card>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <color-card color="blue" label="Gastos Generales">
                        <small style="color: white"><em>$ {{ number_format($expenses, 2) }}</em></small>
                    </color-card>
                </div>
                <div class="col-sm-3">
                    <color-card color="purple" label="Costo venta">
                        <small style="color: white"><em>$ {{ number_format($sales, 2) }}</em></small>
                    </color-card>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <color-card color="navy" label="No deducible">
                        <small style="color: white"><em>$ {{ number_format($undeductible, 2) }}</em></small>
                    </color-card>
                </div>
            </div>
        </div>

        
    </div>

@endsection

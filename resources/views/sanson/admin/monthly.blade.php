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
            <div class="small-box bg-green">
                <div class="inner">
                    <p>Total Mensual</p>
                    <h3>
                        <em>
                            $ {{ number_format($month->sum('cash') + $month->sum('credit_card') + $month->sum('debit_card') + $month->sum('transfer') + $month->sum('check'), 2) }}
                        </em>
                    </h3>
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
                            $ {{ number_format($pending, 2) }}
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
                            $ {{ number_format(($month->sum('cash') + $month->sum('credit_card') + $month->sum('debit_card') + $month->sum('transfer') + $month->sum('check')) / $working_days, 2) }}
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
                    <h3>
                        <em>
                            {{ $shippings->count() }}
                        </em>
                    </h3>
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
                                <small style="color: white">$ {{ number_format($month->sum('cash'), 2) }}</small>
                            </h3>
                        </div>
                        {{-- <div class="icon">
                            <i class="fa fa-money-bill-alt"></i>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <big>Tarjeta de crédito</big>
                            <h3>
                                <small style="color: white">$ {{ number_format($month->sum('credit_card'), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <big>Tarjeta de débito</big>
                            <h3>
                                <small style="color: white">$ {{ number_format($month->sum('debit_card'), 2) }}</small>
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
                                <small style="color: white">$ {{ number_format($month->sum('transfer'), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <big>Cheque</big>
                            <h3>
                                <small style="color: white">$ {{ number_format($month->sum('check'), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <big>Equipos y refacciones</big>
                            <h3>
                                <small style="color: white">$ {{ number_format($equipment->sum('amount'), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <big>Proyectos</big>
                            <h3>
                                <small style="color: white">$ {{ number_format($project->sum('amount'), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <big>Sanson equipo</big>
                            <h3>
                                <small style="color: white">$ {{ number_format($equipment->sum('amount'), 2) }}</small>
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
                                <small style="color: white">$ {{ number_format($project->sum('amount'), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-navy">
                        <div class="inner">
                            <big>Rhino</big>
                            <h3>
                                <small style="color: white">$ {{ number_format($equipment->sum('amount'), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="small-box bg-maroon">
                        <div class="inner">
                            <big>Sanson refacciones</big>
                            <h3>
                                <small style="color: white">$ {{ number_format($equipment->sum('amount'), 2) }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
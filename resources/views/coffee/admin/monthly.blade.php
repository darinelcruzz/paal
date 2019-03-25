@extends('coffee.root')

@push('pageTitle')
    Corte mensual
@endpush

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
                            $ {{ number_format($pending->sum('cash') + $pending->sum('credit_card') + $pending->sum('debit_card') + $pending->sum('transfer') + $pending->sum('check'), 2) }}
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
                            $ {{ number_format(($month->sum('cash') + $month->sum('credit_card') + $month->sum('debit_card') + $month->sum('transfer') + $month->sum('check')) / $month->count(), 2) }}
                        </em>
                    </h3>
                </div>
                <div class="icon">
                    <i class="fa fa-chart-line"></i>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <p>Efectivo</p>
                            <h3>
                                <small style="color: white">$ {{ number_format($month->sum('cash'), 2) }}</small>
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money-bill-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <p>Tarjeta de crédito</p>
                            <h3>
                                <small style="color: white">$ {{ number_format($month->sum('credit_card'), 2) }}</small>
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="fab fa-cc-visa"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <p>Tarjeta de débito</p>
                            <h3>
                                <small style="color: white">$ {{ number_format($month->sum('debit_card'), 2) }}</small>
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="fa fa-credit-card"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <p>Transferencia</p>
                            <h3>
                                <small style="color: white">$ {{ number_format($month->sum('transfer'), 2) }}</small>
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="fa fa-exchange-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <p>Cheque</p>
                            <h3>
                                <small style="color: white">$ {{ number_format($month->sum('check'), 2) }}</small>
                            </h3>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money-check-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
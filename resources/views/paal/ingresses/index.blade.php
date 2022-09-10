@extends('paal.root')

@push('pageTitle', 'Ingresos')

@section('content')

    <div class="row">
        <div class="col-md-9">
            {!! Form::open(['method' => 'post', 'route' => 'paal.ingress.index']) !!}
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
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
            <div class="small-box bg-olive">
                <div class="inner">
                    <h3>
                        {{ number_format($ingresses->sum(function ($i) { return $i->payments->sum(function ($py) { return $py->cash + $py->debit_card + $py->credit_card + $py->transfer + $py->check; }); }), 2) }}
                    </h3>
                    <p><big>TOTAL</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-coins"></i></div>
            </div>

            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ number_format($ingresses->sum(function ($i) { return $i->payments->sum('cash');}), 2) }}</h3>
                    <p><big>EFECTIVO</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-money-bill"></i></div>
            </div>
            
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ number_format($ingresses->sum(function ($i) { return $i->payments->sum('debit_card');}), 2) }}</h3>
                    <p><big>T. DÉBITO</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-credit-card"></i></div>
            </div>
            
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ number_format($ingresses->sum(function ($i) { return $i->payments->sum('credit_card');}), 2) }}</h3>
                    <p><big>T. CRÉDITO</big></p>
                </div>
                
                <div class="icon"><i class="fa fa-credit-card"></i></div>
            </div>
            
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ number_format($ingresses->sum(function ($i) { return $i->payments->sum('transfer');}), 2) }}</h3>
                    <p><big>TRANSFERENCIA</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-exchange-alt"></i></div>
            </div>
            
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ number_format($ingresses->sum(function ($i) { return $i->payments->sum('check');}), 2) }}</h3>
                    <p><big>CHEQUE</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-money-check-alt"></i></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>
                        {{ number_format($ingresses->where('company', '!=', 'mbe')->sum(function ($i) { return $i->payments->sum(function ($py) { return $py->cash + $py->debit_card + $py->credit_card + $py->transfer + $py->check; }); }), 2) }}
                    </h3>
                    <p><big>COCINAS</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-mug-hot"></i></div>
            </div>

            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ number_format($ingresses->where('company', '!=', 'mbe')->sum(function ($i) { return $i->payments->sum('cash');}), 2) }}</h3>
                    <p><big>EFECTIVO</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-money-bill"></i></div>
            </div>
            
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ number_format($ingresses->where('company', '!=', 'mbe')->sum(function ($i) { return $i->payments->sum('debit_card');}), 2) }}</h3>
                    <p><big>T. DÉBITO</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-credit-card"></i></div>
            </div>
            
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ number_format($ingresses->where('company', '!=', 'mbe')->sum(function ($i) { return $i->payments->sum('credit_card');}), 2) }}</h3>
                    <p><big>T. CRÉDITO</big></p>
                </div>
                
                <div class="icon"><i class="fa fa-credit-card"></i></div>
            </div>
            
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ number_format($ingresses->where('company', '!=', 'mbe')->sum(function ($i) { return $i->payments->sum('transfer');}), 2) }}</h3>
                    <p><big>TRANSFERENCIA</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-exchange-alt"></i></div>
            </div>
            
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ number_format($ingresses->where('company', '!=', 'mbe')->sum(function ($i) { return $i->payments->sum('check');}), 2) }}</h3>
                    <p><big>CHEQUE</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-money-check-alt"></i></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                        {{ number_format($ingresses->where('company', 'mbe')->sum(function ($i) { return $i->payments->sum(function ($py) { return $py->cash + $py->debit_card + $py->credit_card + $py->transfer + $py->check; }); }), 2) }}
                    </h3>
                    <p><big>LOGÍSTICA</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-dolly"></i></div>
            </div>

            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ number_format($ingresses->where('company', 'mbe')->sum(function ($i) { return $i->payments->sum('cash');}), 2) }}</h3>
                    <p><big>EFECTIVO</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-money-bill"></i></div>
            </div>
            
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ number_format($ingresses->where('company', 'mbe')->sum(function ($i) { return $i->payments->sum('debit_card');}), 2) }}</h3>
                    <p><big>T. DÉBITO</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-credit-card"></i></div>
            </div>
            
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ number_format($ingresses->where('company', 'mbe')->sum(function ($i) { return $i->payments->sum('credit_card');}), 2) }}</h3>
                    <p><big>T. CRÉDITO</big></p>
                </div>
                
                <div class="icon"><i class="fa fa-credit-card"></i></div>
            </div>
            
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ number_format($ingresses->where('company', 'mbe')->sum(function ($i) { return $i->payments->sum('transfer');}), 2) }}</h3>
                    <p><big>TRANSFERENCIA</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-exchange-alt"></i></div>
            </div>
            
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ number_format($ingresses->where('company', 'mbe')->sum(function ($i) { return $i->payments->sum('check');}), 2) }}</h3>
                    <p><big>CHEQUE</big></p>
                </div>
                
                <div class="icon"><i class="fas fa-money-check-alt"></i></div>
            </div>
        </div>
    </div>

@endsection

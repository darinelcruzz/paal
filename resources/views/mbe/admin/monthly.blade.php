@extends('mbe.root')

@push('pageTitle', 'Corte mensual')

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

            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-money-bill-alt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><big>TOTAL</big></span>
                    <span class="info-box-number">
                        <h3><em>{{ number_format($ingresses->sum('amount'), 2) }}</em></h3>
                    </span>
                </div>
            </div>

            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-cash-register"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">MOSTRADOR</span>
                  <span class="info-box-number">{{ number_format($checkout, 2) }}</span>

                  <div class="progress">
                    <div class="progress-bar" style="width: {{ number_format(100 - $pending*100/($checkout > 0 ? $checkout: 1), 2) }}%"></div>
                  </div>
                  <span class="progress-description">Por depositar: <em>{{ number_format($pending, 2) }}</em></span>
                </div>
            </div>

            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-credit-card"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">CRÉDITO</span>
                  <span class="info-box-number">{{ number_format($credit, 2) }}</span>
                </div>
            </div>

            <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-file-invoice-dollar"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">FACTURADO</span>
                  <span class="info-box-number">{{ number_format($invoiced, 2) }}</span>

                  <div class="progress">
                    <div class="progress-bar" style="width: {{ $invoiced > 0 ? number_format($paid*100/$invoiced, 2) : 100 }}%"></div>
                  </div>
                  <span class="progress-description">Por pagar: <em>{{ number_format($invoiced - $paid, 2) }}</em></span>
                </div>
            </div>

            <a href="{{ route('mbe.ingress.companies', $date) }}">
            <div class="info-box bg-teal">
                <span class="info-box-icon"><i class="fa fa-truck"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">ENVÍOS</span>
                  <span class="info-box-number"><big>{{ $shippings }}</big></span>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-8">
            <div class="row">
            @foreach(['cash' => 'efectivo','credit_card' => 'tarjeta de crédito','debit_card' => 'tarjeta de débito','transfer' => 'transferencia','check' => 'cheque'] as $key => $name)
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <big>{{ ucfirst($name) }}</big>
                            <h3>
                                <small style="color: white">
                                    {{ number_format($ingresses->sum(function ($ingress) use ($key) { return $ingress->payments->sum($key);}), 2) }}
                                </small>
                            </h3>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>

@endsection

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
                    <span class="info-box-text">TOTAL</span>
                    <span class="info-box-number">
                        <big>$ {{ number_format($checkout_total + $credit_total + $invoiced_total, 2) }}</big>
                    </span>
                </div>
            </div>

            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-cash-register"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">MOSTRADOR</span>
                  <span class="info-box-number">$ {{ number_format($checkout_total, 2) }}</span>

                  <div class="progress">
                    <div class="progress-bar" style="width: {{ number_format(100 - $pending*100/$checkout_div, 2) }}%"></div>
                  </div>
                  <span class="progress-description">Por depositar: <em>$ {{ number_format($pending, 2) }}</em></span>
                </div>
            </div>

            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-credit-card"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">CRÉDITO</span>
                  <span class="info-box-number">$ {{ number_format($credit_total, 2) }}</span>
                </div>
            </div>

            <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-file-invoice-dollar"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">FACTURADO</span>
                  <span class="info-box-number">$ {{ number_format($invoiced_total, 2) }}</span>

                  <div class="progress">
                    <div class="progress-bar" style="width: {{ $invoiced_total > 0 ? number_format($paid_total*100/$invoiced_total, 2) : 100 }}%"></div>
                  </div>
                  <span class="progress-description">Por pagar: <em>$ {{ number_format($invoiced_total - $paid_total, 2) }}</em></span>
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

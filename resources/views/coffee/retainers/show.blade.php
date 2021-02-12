<html>
<head>
    <meta charset="UTF-8">
    <title>Anticipo | Comprobante</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/img/coffee.ico') }}" />

    <!-- Bootstrap 3.3.7 -->  
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap-print.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.css') }}">
    <!-- AdminLTE skins -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/skins/_all-skins.min.css') }}">

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">

    <style>
        body {
            text-align: center;
            font-family: 'Oswald', sans-serif;
        },
    </style>
</head>

<body onload="window.print();">

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <img width="300px" src="{{ asset('/img/coffee mono.png') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <p>
                <big><b>SUCURSAL CHS</b></big><br>
                16 Poniente Norte #138<br>
                Col. Las Arboledas, C.P. 29030 <br>
                Tuxtla Gutiérrez <br>
                <i class="fas fa-phone"></i> 01 (961) 121 34 04 - <i class="fab fa-whatsapp"></i> 961 330 65 28 <br>
                <i class="fas fa-envelope"></i> ventas@coffeedepotchiapas.com.mx <br>
                <i class="fab fa-facebook"></i> Coffee Depot TGZ
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <span class="pull-left">{{ strtoupper($retainer->client->name) }}</span> <br>
            <span class="pull-left">{{ $retainer->client->rfc }}</span> <br>
            <span class="pull-left">{{ $retainer->client->email }}</span> <br>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">
            <span class="pull-left"><b>Folio: </b> {{ $retainer->folio }}</span> 
            <span class="pull-right">{{ fdate($retainer->retained_at, 'd/m/Y', 'Y-m-d') }}</span>
        </div>
    </div>

    <br><br>


    <div class="row">
        <div class="col-md-12">
            <h3>ANTICIPO</h3>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="text-align: left;"><small>MÉTODO</small></th>
                        <th style="text-align: right; width: 20%"><small>CANTIDAD</small></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($retainer->payments as $payment)
                        @if($payment->cash > 0)
                            <tr>
                                <td>EFECTIVO</td>
                                <td style="text-align: right; width: 20%">{{ number_format($payment->cash, 2) }}</td>
                            </tr>
                        @endif
                        @if($payment->check > 0)
                            <tr>
                                <td>CHEQUE</td>
                                <td style="text-align: right; width: 20%">{{ number_format($payment->check, 2) }}</td>
                            </tr>
                        @endif
                        @if($payment->transfer > 0)
                            <tr>
                                <td>TRANSFERENCIA</td>
                                <td style="text-align: right; width: 20%">{{ number_format($payment->transfer, 2) }}</td>
                            </tr>
                        @endif
                        @if($payment->credit_card > 0)
                            <tr>
                                <td>TARJETA DE CRÉDITO</td>
                                <td style="text-align: right; width: 20%">{{ number_format($payment->credit_card, 2) }}</td>
                            </tr>
                        @endif
                        @if($payment->debit_card > 0)
                            <tr>
                                <td>TARJETA DE DÉBITO</td>
                                <td style="text-align: right; width: 20%">{{ number_format($payment->debit_card, 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th style="text-align: right;"><small>TOTAL</small></th>
                        <td style="text-align: right; width: 20%">{{ number_format($retainer->amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <br>
    <br>
    =============================================================================
        
</body>
</html>

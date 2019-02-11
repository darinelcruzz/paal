<html>
<head>
    <meta charset="UTF-8">
    <title>Ventas | Comprobante</title>
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
            text-align:center;
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
                Blvd Angel Albino Corzo #955<br>
                Loc A y B COl. Las Palmas CP 29040 <br>
                <i class="fas fa-phone"></i> 01 (961) 121 34 04 - <i class="fab fa-whatsapp"></i> 961 330 65 28 <br>
                <i class="fas fa-envelope"></i> ventas@coffeedepotchiapas.com.mx <br>
                <i class="fab fa-facebook"></i> Coffee Depot TGZ
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <span class="pull-left">{{ strtoupper($ingress->client->name) }}</span> 
            @if ($ingress->invoice == 'otro')
                <span class="pull-right">Otro:__________________________</span>
            @elseif($ingress->invoice != 'no')
                <span class="pull-right">{{ $ingress->cfdi }}</span>
            @else
                <span class="pull-right">S/F</span>
            @endif
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">
            <span class="pull-left"><b>Folio: </b> {{ substr("000{$ingress->id}", -3) }}</span> 
            <span class="pull-right">{{ fdate($ingress->created_at, 'd/m/Y h:i a') }}</span>
        </div>
    </div>

    <br><br>


    <div class="row">
        <div class="col-md-12">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Método</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $total = 0 
                    @endphp
                    @foreach ($ingress->payments as $payment)
                        @if ($payment->cash > 0)
                            <tr>
                                <td style="text-align: center">{{ fdate($payment->created_at, 'd/m/Y') }}</td>
                                <td style="text-align: center">{{ ucfirst($payment->type) }}</td>
                                <td style="text-align: center">Efectivo</td>
                                <td style="text-align: right">{{ '$ ' . number_format($payment->cash, 2) }}</td>
                            </tr>
                        @endif
                        @if ($payment->transfer > 0)
                            <tr>
                                <td style="text-align: center">{{ fdate($payment->created_at, 'd/m/Y') }}</td>
                                <td style="text-align: center">{{ ucfirst($payment->type) }}</td>
                                <td style="text-align: center">Transferencia</td>
                                <td style="text-align: right">{{ '$ ' . number_format($payment->transfer, 2) }}</td>
                            </tr>
                        @endif

                        @if ($payment->check > 0)
                            <tr>
                                <td style="text-align: center">{{ fdate($payment->created_at, 'd/m/Y') }}</td>
                                <td style="text-align: center">{{ ucfirst($payment->type) }}</td>
                                <td style="text-align: center">Cheque</td>
                                <td style="text-align: right">{{ '$ ' . number_format($payment->check, 2) }}</td>
                            </tr>
                        @endif

                        @if ($payment->debit_card > 0)
                            <tr>
                                <td style="text-align: center">{{ fdate($payment->created_at, 'd/m/Y') }}</td>
                                <td style="text-align: center">{{ ucfirst($payment->type) }}</td>
                                <td style="text-align: center">T. Débito</td>
                                <td style="text-align: right">{{ '$ ' . number_format($payment->debit_card, 2) }}</td>
                            </tr>
                        @endif

                        @if ($payment->credit_card > 0)
                            <tr>
                                <td style="text-align: center">{{ fdate($payment->created_at, 'd/m/Y') }}</td>
                                <td style="text-align: center">{{ ucfirst($payment->type) }}</td>
                                <td style="text-align: center">T. Crédito</td>
                                <td style="text-align: right">{{ '$ ' . number_format($payment->credit_card, 2) }}</td>
                            </tr>
                        @endif

                        @php
                            $total += $payment->total;
                        @endphp
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: right">Total pagos</th>
                        <td style="text-align: right">$ {{ number_format($total, 2) }}</td>
                    </tr>
                    <tr>
                        <th colspan="4">&nbsp;</th>
                    </tr>
                    <tr>
                        <th style="text-align: left">Total venta</th>
                        <td style="text-align: left">$ {{ number_format($ingress->amount, 2) }}</td>
                        <th style="text-align: right">Por pagar</th>
                        <td style="text-align: right">$ {{ number_format($ingress->amount - $total, 2) }}</td>
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

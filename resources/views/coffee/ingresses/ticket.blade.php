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
            <span class="pull-left">{{ strtoupper($ingress->client->name) }}</span> <br>
            <span class="pull-left">{{ $ingress->client->rfc }}</span> <br>
            <span class="pull-left">{{ $ingress->client->email }}</span> <br>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
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
            <span class="pull-left"><b>Folio: </b> {{ $ingress->folio }}</span> 
            <span class="pull-right">{{ fdate($ingress->created_at, 'd/m/Y h:i a') }}</span>
        </div>
    </div>

    <br><br>


    <div class="row">
        <div class="col-md-12">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>CANT</th>
                        <th style="width: 55%">DESCRIPCIÓN</th>
                        <th>UNITARIO</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $subtotal = $discounts = 0 
                    @endphp

                    @foreach ($ingress->movements as $movement)
                        <tr>
                            <td style="text-align: center;">{{ $movement->quantity }}</td>
                            <td>{{ $movement->description or $movement->product->description }}{{ $movement->discount != 0 ? '*': ''}}</td>
                            <td style="text-align: right">$ {{ number_format($movement->price, 2) }}</td>
                            <td style="text-align: right">$ {{ number_format($movement->total, 2) }}</td>
                        </tr>
                        @php
                            $subtotal += $movement->total;
                            $discounts += $movement->discount == 0 ? 0: 1;
                        @endphp
                    @endforeach

                    @if($ingress->products)
                        @foreach (unserialize($ingress->products) as $product)
                            <tr>
                                <td style="text-align: center;">{{ $product['q'] }}</td>
                                <td>{{ App\Product::find($product['i'])->description }}{{ $product['d'] != 0 ? '*': ''}}</td>
                                <td style="text-align: right">$ {{ number_format($product['p'], 2) }}</td>
                                <td style="text-align: right">$ {{ number_format($product['t'], 2) }}</td>
                            </tr>
                            @php
                                $subtotal += $product['t'];
                                $discounts += $product['d'] == 0 ? 0: 1;
                            @endphp
                        @endforeach
                    @endif

                    @if($ingress->special_products)
                        @foreach (unserialize($ingress->special_products) as $product)
                            <tr>
                                <td>{{ $product['q'] }}</td>
                                <td>{{ $product['i'] }}</td>
                                <td>$ {{ number_format($product['p'], 2) }}</td>
                                <td>$ {{ number_format($product['t'], 2) }}</td>
                            </tr>
                            @php
                                $subtotal += $product['t'];
                            @endphp
                        @endforeach
                    @endif
                </tbody>

                <tfoot>
                    @if ($ingress->iva > 0)
                        <tr>
                            <th colspan="3" style="text-align: right">Subtotal</th>
                            <td style="text-align: right">$ {{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align: right">I.V.A.</th>
                            <td style="text-align: right">$ {{ number_format($ingress->iva, 2) }}</td>
                        </tr>
                    @endif
                    <tr style="border:1px solid black">
                        <th colspan="3" style="text-align: right">Total</th>
                        <td style="text-align: right">$ {{ number_format($ingress->amount, 2) }}</td>
                    </tr>
                    @if ($ingress->retainer > 0)
                        <tr>
                            <th colspan="3" style="text-align: right">Anticipo</th>
                            <td style="text-align: right">$ {{ number_format($ingress->retainer, 2) }}</td>
                        </tr>
                        <tr style="border:1px solid black">
                            <th colspan="3" style="text-align: right">Pendiente</th>
                            <td style="text-align: right">$ {{ number_format($ingress->debt, 2) }}</td>
                        </tr>
                    @endif
                </tfoot>
            </table>
        </div>
    </div>

    <br>
    
    <div class="row">
        <div class="col-md-12">
            <table align="center">
                <thead>
                    <th>EFECTIVO {!! $payment->cash > 0 ? '<i class="far fa-check-square"></i>': '<i class="far fa-square"></i>' !!}</th>
                    <th>TRANSFERENCIA {!! $payment->transfer > 0 ? '<i class="far fa-check-square"></i>': '<i class="far fa-square"></i>' !!}</th>
                    <th>T.C. {!! $payment->credit_card > 0 ? '<i class="far fa-check-square"></i>': '<i class="far fa-square"></i>' !!}</th>
                    <th>T.D. {!! $payment->debit_card > 0 ? '<i class="far fa-check-square"></i>': '<i class="far fa-square"></i>' !!}</th>
                    <th>CHEQUE {!! $payment->check > 0 ? '<i class="far fa-check-square"></i>': '<i class="far fa-square"></i>' !!}</th>
                </thead>
            </table>
        </div>
    </div>

    <br><br>

    <div class="row">
        <div class="col-md-12">
            <small>
                {!! $discounts > 0 ? '* se aplicó descuento<br>': '' !!}
            </small>
        </div>
    </div>

    <br>
    =============================================================================
        
</body>
</html>

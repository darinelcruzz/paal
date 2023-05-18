<html translate="no">
<head>
    <meta charset="UTF-8">
    <title>Ventas | Comprobante</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/img/cocinaspaal.ico') }}" />

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

    {{-- <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <img width="200px" src="{{ asset('/img/cocinaspaal.png') }}">
        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <p>
                @if($ingress->store_id == 2)
                <big><b>COFFEE DEPOT & SANSON SURESTE</b></big><br>
                <big><b>SUCURSAL CHS</b></big><br>
                16 Poniente Norte #138<br>
                Col. Las Arboledas, C.P. 29030 <br>
                Tuxtla Gutiérrez <br>
                <i class="fas fa-phone"></i> 01 (961) 121 34 04 - <i class="fab fa-whatsapp"></i> 961 330 65 28 <br>
                <i class="fas fa-envelope"></i> ventas@coffeedepotchiapas.com.mx <br>
                <img style="vertical-align: bottom;" width="100px" src="{{ asset('/img/cocinaspaallong.jpg') }}">                    
                | <small>DISTRIBUIDOR AUTORIZADO</small><br>
                @else
                <big><b>COFFEE DEPOT & SANSON SURESTE</b></big><br>
                <big><b>SUCURSAL MID</b></big><br>
                Circuito Colonia (Calle 31) #87 x 20 y 18<br>
                Col. Mexico Oriente, C.P. 97137<br>
                Mérida, Yucatán <br>
                <i class="fas fa-phone"></i> 999 926 8658 - <i class="fab fa-whatsapp"></i> 999 900 2523 <br>
                <i class="fas fa-envelope"></i> merida@cocinaspaal.com <br>
                <img style="vertical-align: bottom;" width="100px" src="{{ asset('/img/cocinaspaallong.jpg') }}">                    
                | <small>DISTRIBUIDOR AUTORIZADO</small><br>
                @endif
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <span class="pull-left">{{ strtoupper($ingress->client_name ?? $ingress->client->name) }}</span> <br>
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
                        <th style="text-align: right;">UNITARIO</th>
                        <th style="text-align: right;">TOTAL</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $subtotal = $discounts = $quantity = 0 
                    @endphp

                    @foreach ($ingress->movements as $movement)
                        <tr>
                            <td style="text-align: center;">{{ $movement->quantity }}</td>
                            <td>{{ $movement->description ?? $movement->product->description }}{{ $movement->discount != 0 ? '*': ''}}</td>
                            <td style="text-align: right">$ {{ number_format($movement->price, 2) }}</td>
                            <td style="text-align: right">$ {{ number_format($movement->total, 2) }}</td>
                        </tr>
                        @php
                            $quantity += $movement->quantity;
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

                    @if($ingress->type == 'nota de crédito')
                        <tr>
                            <td style="text-align: center;">1</td>
                            <td>Nota de crédito</td>
                            <td style="text-align: right">{{ number_format($ingress->amount, 2) }}</td>
                            <td style="text-align: right">{{ number_format($ingress->amount, 2) }}</td>
                        </tr>
                    @endif
                </tbody>

                <tfoot>
                    @if ($ingress->iva > 0)
                        <tr>
                            <td style="text-align: center;border-top: 1px solid black;">{{ $quantity }}</td>
                            <th colspan="2" style="text-align: right">Subtotal</th>
                            <td style="text-align: right">$ {{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align: right">I.V.A.</th>
                            <td style="text-align: right">$ {{ number_format($ingress->iva, 2) }}</td>
                        </tr>
                    @endif
                    <tr style="border:1px solid black">
                        @if($ingress->iva <= 0)<td style="text-align: center;border-top: 1px solid black;">{{ $quantity }}</td>@endif
                        <th colspan="{{ $ingress->iva > 0 ? 3: 2 }}" style="text-align: right">Total</th>
                        <td style="text-align: right">$ {{ number_format($ingress->type == 'anticipo' ? $ingress->quotation->amount: $ingress->amount, 2) }}</td>
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
                    @if ($ingress->type == 'anticipo')
                        <tr>
                            <th colspan="3" style="text-align: right">Anticipo</th>
                            <td style="text-align: right">$ {{ number_format($ingress->amount, 2) }}</td>
                        </tr>
                        <tr style="border:1px solid black">
                            <th colspan="3" style="text-align: right">Pendiente</th>
                            <td style="text-align: right">$ {{ number_format($ingress->debt, 2) }}</td>
                        </tr>
                    @endif
                    @if ($ingress->type != 'anticipo' && $ingress->retainers->sum('amount') > 0)
                        <tr>
                            <th colspan="3" style="text-align: right">Anticipo</th>
                            <td style="text-align: right">$ {{ number_format($ingress->retainers->sum('amount'), 2) }}</td>
                        </tr>
                        <tr style="border:1px solid black">
                            <th colspan="3" style="text-align: right">Importe</th>
                            <td style="text-align: right">$ {{ number_format($ingress->amount - $ingress->retainers->sum('amount'), 2) }}</td>
                        </tr>
                    @endif
                </tfoot>
            </table>
        </div>
    </div>

    <br>
    @if($ingress->type != 'nota de crédito')
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
    @endif

    <br><br>

    <div class="row">
        <div class="col-md-12">
            <small>
                {!! $discounts > 0 ? '* se aplicó descuento<br>': '' !!}
            </small>
        </div>
    </div>

    <br><br>

    <div class="row">
        <div class="col-md-12">
            <small style="font-weight: bold;">
                FACTURACIÓN AL DÍA <br>
                FAVOR DE SOLICITAR EN EL MOMENTO DE SU COMPRA, DE LO CONTRARIO SERÁ PARTE DE LA FACTURA GLOBAL DEL DÍA. <br>
                VERIFICAR SUS DATOS YA QUE NO HABRÁ CANCELACIONES NI REFACTURACIÓN.
            </small>
        </div>
    </div>

    <br>
    =============================================================================
        
</body>
</html>

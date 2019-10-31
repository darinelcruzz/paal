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
            <img width="100px" src="{{ asset('/img/mbe.png') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <p>
                <big><b>SUCURSAL CHS</b></big><br>
                16 Poniente Norte #138 <br>
                Fracc. Las Arboledas C.P. 29030 <br>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <span style="text-align: center;">{{ strtoupper($ingress->client->name) }}</span>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <span class="pull-left"><b>FI</b> {{ $ingress->invoice_id }}</span> 
            <span class="pull-right">{{ fdate($ingress->created_at, 'd/m/Y h:i a') }}</span>
        </div>
    </div>

    <br><br>


    <div class="row">
        <div class="col-md-12">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 55%">DESCRIPCIÓN</th>
                        <th>CANT</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach (unserialize($ingress->products) as $product)
                        <tr>
                            <td style="text-align: center;">{{ App\Product::find($product['i'])->description }}</td>
                            <td style="text-align: center;">{{ $product['q'] }}</td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th>I.V.A.</th>
                        <td style="text-align: center">$ {{ number_format($ingress->iva, 2) }}</td>
                    </tr>
                    <tr style="border:1px solid black">
                        <th>Total</th>
                        <td style="text-align: center">$ {{ number_format($ingress->amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-xs-12">
            <img width="100%" src="{{ asset('/img/banner_mbe.png') }}">
        </div>
    </div>
        
</body>
</html>

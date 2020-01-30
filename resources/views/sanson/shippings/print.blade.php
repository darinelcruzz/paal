<html>
<head>
    <meta charset="UTF-8">
    <title>Rótulo</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/img/coffee.ico') }}" />

    <!-- Bootstrap 2.3.7 -->  
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
            font-size: 34px;
        },
    </style>
</head>

<body onload="window.print();">

    <div class="wrapper">
        <div class="content-wrapper">
            <div class="row">
                @if ($shipping->address)

                    <div class="col-md-12">
                        <br>
                        DESTINATARIO: <br>
                        <span style="font-size: 50px"><b>{{ $shipping->address->business_name }}</b></span><br><br>

                        <span style="font-size: 50px">CONTACTO: {{ $shipping->address->contact }}</span> <br><br>

                        TEL: {{ $shipping->address->phone  }} <br><br>

                        <span style="font-size: 50px">
                        DIRECCIÓN: {{ $shipping->address->street  }}, # EXT: {{ $shipping->address->street_number  }} {{ $shipping->address->street_number2 ? "# INT: " . $shipping->address->street_number2: ''  }}, Col. {{ $shipping->address->district  }}, CP: {{ $shipping->address->postcode  }}, {{ $shipping->address->city  }}, {{ $shipping->address->state  }}
                        </span> <br><br>

                        <span style="font-size: 50px">REFERENCIA: {{ $shipping->address->reference }}</span> <br><br>
                    </div>

                @else

                    <div class="col-md-12">
                        <br>
                        DESTINATARIO: <br>
                        <span style="font-size: 50px"><b>{{ $shipping->ingress->client->name }}</b></span><br><br>

                        <span style="font-size: 50px">DIRECCIÓN: {{ strtoupper($shipping->ingress->client->complete_address) }}</span> <br><br>

                        TEL: {{ $shipping->ingress->client->phone }} <br><br>
                        DE: <b>COFFEE DEPOT TUXTLA GTZ</b><br>
                    </div>

                @endif
            </div>
        </div>
    </div>
        
</body>
</html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Ticket Coffee</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/img/coffee.ico') }}" />
    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/dataTables.bootstrap.css') }}">

    <style>
        p {
            text-align:justify;
            text-indent:50px;
            font-family: 'Oswald', sans-serif;
        },
        body {
            text-align:center;
            text-indent:50px;
            font-family: 'Oswald', sans-serif;
        },
        td {
            height: 10px;
        }
    </style>
</head>

<body onload="window.print();">
<div class="wrapper">
    <section class="invoice">
        <div class="wrapper">
            <div class="row">
                <center>
                    <img width="300px" src="{{ asset('/img/coffee mono.png') }}">
                </center>
            </div>
            <div class="row">
                <h5 style="font-family: 'Oswald', sans-serif;" align="center">
                    <big><b>SUCURSAL TGZ</b></big><br>
                    Blvd Angel Albino Corzo #955<br>
                    Loc A y B COl. Las Palmas CP 29040 <br>
                    <i class="fas fa-phone"></i> 01 (961) 121 57 04 - <i class="fab fa-whatsapp"></i> 961 330 65 28 <br>
                    <i class="fas fa-envelope"></i> tuxtla@coffeedepot.com.mx - <i class="fab fa-facebook"></i> Coffee Depot TGZ
                </h5>
            </div>
            <div style="font-family: 'Oswald', sans-serif;" align="center">
                <span class="pull-right">
                    <big><b>FOLIO: </b> <b>Fecha: </b>25/Ene/19</big>
                </span>
            </div>

            {{-- <h5 align="right">
                {{ fdate($service->date_out, 'd \d\e F \d\e\l Y') }} <br><br>
            </h5>

            <h5 align="left">
                <b>GRUAS MAPER HACE ENTREGA DEL VEHICULO:</b><br>
            </h5>

            <h5><b>MARCA: </b>{{ $service->brand }} <span class="pull-right"><b>TIPO: </b>{{ $service->type }}</span></h5>
            <h5><b>MODELO: </b>{{ $service->model }} <span class="pull-right"><b>PLACAS: </b>{{ $service->plate }}</span></h5>
            <h5><b>COLOR: </b>{{ $service->color }}</h5>
            <h5><b>AL SR. (A): </b>{{ $service->releaser }}</h5> --}}
        </div>
    </section>
</div>
</body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Cotización</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Bootstrap 3.3.7 -->  
        <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.css') }}">
        <!-- AdminLTE skins -->
        {{-- <link rel="stylesheet" href="{{ asset('adminlte/dist/css/skins/_all-skins.min.css') }}"> --}}
        {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"> --}}
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        
        <!-- Salto de página -->
        <style>
        body {
            font-style: bold;
        }
        .page-break {
            page-break-after: always;
        }
        </style>
    </head>

    <body>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <img width="150px" src="{{ asset('/img/coffee.png') }}">
                            </td>
                            <td width="60%">
                                <b>COFFEE DEPOT</b> -
                                SUCURSAL CHIAPAS<br>
                                Blvd Angel Albino Corzo #955, Loc A y B COl. Las Palmas CP 29040 <br>
                                <i class="fa fa-phone"></i> 01 (961) 121 34 04 &nbsp;&nbsp;&nbsp;&nbsp;
                                <i class="fa fa-envelope"></i> ventas@coffeedepotchiapas.com.mx <br>
                                <i class="fa fa-whatsapp"></i> 961 330 65 28 &nbsp;&nbsp;&nbsp;&nbsp;
                                <i class="fa fa-facebook"></i> Coffee Depot TGZ
                            </td>
                            <td style="text-align: right;">
                                <b>COTIZACIÓN</b><br>
                                <b>Fecha:</b><br>
                                {{ fdate($quotation->created_at, 'd/m/Y') }}<br>
                                <b>Folio:</b><br>
                                {{ substr("0000{$quotation->id}", -4) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <table width="100%">
                    <thead>
                        <tr style="background-color: red; color: white;">
                            <th colspan="3" style="padding-top: 8px; padding-bottom: 8px; padding-left: 6px;">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                           <td colspan="2"><b>{{ $quotation->client->name or 'A quien corresponda' }}</b></td>
                           <td width="50%"></td>
                        </tr>
                        <tr>
                           <td colspan="2"><b>RFC:</b> {{ $quotation->client->rfc or '' }}</td>
                           <td width="50%">&nbsp;</td>
                        </tr>
                        <tr>
                           <td><b>Correo:</b> {{ $quotation->client->email or '' }}</td>
                           <td></td>
                           <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped">
                    <thead style="background-color: red; color: white;">
                        <tr>
                            <th>#</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Descuento</th>
                            <th>Importe</th>
                        </tr>
                    </thead>

                    <tbody>
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach (unserialize($quotation->products) as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ App\Product::find($product['i'])->description }}</td>
                            <td>$ {{ number_format($product['p'], 2) }}</td>
                            <td>{{ $product['q'] }}</td>
                            <td>$ {{ number_format($product['d'], 2) }}</td>
                            <td>$ {{ number_format($product['t'], 2) }}</td>
                        </tr>
                        @php
                            $subtotal += $product['t'];
                        @endphp
                    @endforeach

                    @if($quotation->special_products)
                        @foreach (unserialize($quotation->special_products) as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product['i'] }}</td>
                                <td>$ {{ number_format($product['p'], 2) }}</td>
                                <td>{{ $product['q'] }}</td>
                                <td>$ {{ number_format($product['d'], 2) }}</td>
                                <td>$ {{ number_format($product['t'], 2) }}</td>
                            </tr>
                            @php
                                $subtotal += $product['t'];
                            @endphp
                        @endforeach
                    @endif
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="4"></th>
                            <th>Subtotal</th>
                            <td>$ {{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <th colspan="4"></th>
                            <th>IVA</th>
                            <td>$ {{ number_format($quotation->iva, 2) }}</td>
                        </tr>
                        <tr>
                            <th colspan="4"></th>
                            <th>Total</th>
                            <td>$ {{ number_format($quotation->amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- jQuery 3 -->
        {{-- <script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.min.js') }}"></script> --}}
        <!-- Bootstrap 3.3.7 -->
        {{-- <script src="{{ asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script> --}}
        <!-- AdminLTE App -->
        {{-- <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script> --}}

        </script>

    </body>
</html>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Cotización</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!-- Bootstrap 3.3.7 -->  
        <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <link rel="icon" href="{{ asset("/img/sanson.ico") }}" />
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
                                <img width="150px" src="{{ asset('/img/sanson_alt.png') }}">
                            </td>
                            <td width="60%">
                                <b>SAN-SON</b> -
                                SUCURSAL CHIAPAS<br>
                                Blvd Angel Albino Corzo #955, <br>
                                Loc A y B COl. Las Palmas CP 29040 <br>
                                <i class="fa fa-phone"></i> 01 (961) 121 34 04 &nbsp;&nbsp;&nbsp;&nbsp;
                                <i class="fa fa-whatsapp"></i> 961 330 65 28<br>
                                <i class="fa fa-envelope"></i> ventas@coffeedepotchiapas.com.mx <br>
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
                <table width="100%" class="table table-striped">
                    <thead>
                        <tr style="background-color: #49a9df; color: white;">
                            <th colspan="3" style="padding-top: 8px; padding-bottom: 8px; padding-left: 6px;">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                           <td colspan="2"><b>{{ $quotation->client_name }}</b></td>
                           <td width="50%"></td>
                        </tr>
                        <tr>
                           <td><b>Correo:</b> {{ $quotation->email or '' }}</td>
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
                    <thead style="background-color: #49a9df; color: white;">
                        <tr>
                            <th>#</th>
                            <th>Descripción</th>
                            <th style="text-align: right;">Precio</th>
                            <th style="text-align: center;">Cantidad</th>
                            <th style="text-align: center;">Descuento</th>
                            <th style="text-align: right;">Importe</th>
                        </tr>
                    </thead>

                    <tbody>
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach ($quotation->movements as $movement)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $movement->product->description }}</td>
                            <td style="text-align: right;">{{ number_format($movement->price, 2) }}</td>
                            <td style="text-align: center;">{{ $movement->quantity }}</td>
                            <td style="text-align: center;">
                                {{ number_format($movement->price * ($movement->discount/100), 2) }} ({{ $movement->discount }}%)
                            </td>
                            <td style="text-align: right;">{{ number_format($movement->total, 2) }}</td>
                        </tr>
                        @php
                            $subtotal += $movement->total;
                        @endphp
                    @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="4"></th>
                            <th style="text-align: center;">Subtotal</th>
                            <td style="text-align: right;">{{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <th colspan="4"></th>
                            <th style="text-align: center;">IVA</th>
                            <td style="text-align: right;">{{ number_format($quotation->iva, 2) }}</td>
                        </tr>
                        <tr>
                            <th colspan="4"></th>
                            <th style="text-align: center;">Total</th>
                            <td style="text-align: right;">{{ number_format($quotation->amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </body>
</html>
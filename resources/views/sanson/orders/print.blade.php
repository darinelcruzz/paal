<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Orden de compra {{ $order->id }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!-- Bootstrap 3.3.7 -->  
        <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
        
        <link rel="stylesheet" href="{{ asset('css/printable.css') }}" media="all">

        <link rel="icon" href="{{ asset("/img/sanson.ico") }}" />
    </head>

    <body onload="window.print();">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <td style="text-align: center;" rowspan="2">
                                <img width="100px" src="{{ asset('/img/paal.png') }}">
                            </td>
                            <td width="60%">
                                <big><b>GRUPO FINANCIERO PAAL, S.A. DE C.V.</b></big>
                            </td>
                            <td style="text-align: right;"><b>ORDEN DE COMPRA</b></td>
                            <td class="alt-title">
                                {{ substr("0000{$order->id}", -4) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                DOMICILIO FISCAL <br>
                                Gardena No 20, Col. El Valle, C.P. 29010, Tuxtla Gutiérrez, Chiapas <br>
                                LUGAR DE EXPEDICIÓN <br>
                                16 Poniente Norte #138, Col. Las Arboledas, C.P. 29030, Tuxtla Gutiérrez
                            </td>
                            <td colspan="2" style="align-content: right;">
                                <img width="200px" src="{{ asset('/img/' . ($order->provider->name == "RHINO" ? 'rhino': 'sanson') . '.png') }}">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="alt-title">Proveedor</td>
                            <td>
                                {{ $order->provider->social }}
                            </td>
                            <th class="alt-title" style="width: 20%">Fecha de expedición</th>
                            <td>{{ fdate($order->created_at, 'd/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th class="alt-title" style="width: 15%">Dirección</th>
                            <td>{{ $order->provider->address }}</td>
                            <th class="alt-title" style="width: 20%">Almacen</th>
                            <td style="width: 15%">1</td>
                        </tr>
                        <tr>
                            <th class="alt-title" style="width: 15%">Correo</th>
                            <td>{{ $order->provider->email }}</td>
                            <th class="alt-title" style="width: 20%">Teléfono</th>
                            <td>{{ $order->provider->phone }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr class="title">
                            <th class="centered" width="10%">CANTIDAD</th>
                            <th class="centered">MODELO</th>
                            <th class="centered" style="width: 35%;">DESCRIPCIÓN</th>
                            <th class="centered">% DESCUENTO</th>
                            <th class="centered">COSTO UNITARIO</th>
                            <th class="centered">IMPORTE</th>
                        </tr>
                    </thead>
                    
                    @php
                        $subtotal = $shipping = $ieps = $discount = 0;
                    @endphp

                    <tbody>
                    @foreach ($order->movements as $movement)
                        <tr>
                            <td class="centered">{{ $movement->quantity }}</td>
                            <td class="centered">{{ $movement->product->code }}</td>
                            <td class="centered">{{ $movement->description or $movement->product->description }}</td>
                            <td style="text-align: right;">{{ number_format($movement->discount, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($movement->price, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($movement->total, 2) }}</td>
                        </tr>
                        @php
                            $subtotal += $movement->total;
                            $discount += $movement->discount;
                            $shipping += $movement->product->family == 'ENVÍOS' ? $movement->price: 0;
                        @endphp
                    @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <th class="alt-title centered">SUBTOTAL</th>
                            <th style="text-align: right;">$ {{ number_format($subtotal, 2) }}</th>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <th class="alt-title centered">DESCUENTO</th>
                            <td style="text-align: right;">- $ {{ number_format($discount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <th class="alt-title centered">I.E.P.S.</th>
                            <td style="text-align: right;">$ {{ number_format($ieps, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <th class="alt-title centered">I.V.A.</th>
                            <td style="text-align: right;">$ {{ number_format($order->iva, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <th class="alt-title centered">TOTAL</th>
                            <td style="text-align: right;">$ {{ number_format($subtotal - $discount + $ieps + $order->iva, 2) }}</td>
                        </tr>
                        <tr>
                            <th colspan="6">{{ amountToText($subtotal) . ' PESOS ' . amountDecimals($subtotal) . '/100 MXN' }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Cotización {{ $quotation->id }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!-- Bootstrap 3.3.7 -->  
        <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- CSS Print -->
        <link rel="stylesheet" href="{{ asset('css/printable.css') }}" media="all">
    </head>

    <body onload="window.print();">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <td style="text-align: center;">
                                <img width="100px" src="{{ asset('/img/sanson_login.png') }}">
                            </td>
                            <td width="60%">
                                <big><b>SAN-SON</b></big>
                                SUCURSAL CHIAPAS<br>
                                16 Poniente Norte #138<br>
                                Col. Las Arboledas, C.P. 29030 <br>
                                <i class="fa fa-phone"></i> 01 (961) 121 34 04 &nbsp;&nbsp;&nbsp;&nbsp;
                                <i class="fa fa-whatsapp"></i> 961 330 65 28<br>
                                <i class="fa fa-envelope"></i> ventas@coffeedepotchiapas.com.mx <br>
                                <i class="fa fa-facebook"></i> Coffee Depot TGZ
                            </td>
                            <td style="text-align: right;">
                                <b>COTIZACIÓN</b><br>
                                {{ substr("0000{$quotation->id}", -4) }} <br>
                                <b>{{ strtoupper($quotation->type) }}</b>
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
                            <th class="title">No. Asesor</th>
                            <td>{{ auth()->user()->id }}</td>
                            <th class="title">Email</th>
                            <td>ventas.tuxtla1@coffeedepot.com.mx</td>
                            <th class="title">Fecha de expedición</th>
                            <td>{{ fdate($quotation->updated_at, 'd/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th class="title">Nombre</th>
                            <td colspan="3">{{ auth()->user()->name }}</td>
                            <th class="title">Vigencia</th>
                            <td>{{ date('d/m/Y', strtotime($quotation->updated_at) + 3 * 24 * 60 * 60) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table>
                    <tbody>
                        <tr class="title">
                            <th colspan="2" style="text-align: center">DATOS DEL CLIENTE</th>
                            <th style="width: 40%; text-align: center">OBSERVACIONES</th>
                        </tr>
                        <tr>
                            <td class="title" style="width: 15%">Empresa</td>
                            <td>{{ $quotation->client->name }}</td>
                            <td rowspan="6">
                                DESCUENTO DEL 5 % EN PAGO EN EFECTIVO, TRANSFERENCIA, TARJETA DE DEBITO,  PRECIOS CON VIGENCIA DE 3 DÍAS, FECHA DE ENTREGA DE 20 A 25 DÍAS HÁBILES. 
                            </td>
                        </tr>
                        <tr>
                            <td class="title">Solicitante</td>
                            <td>{{ $quotation->client->name }}</td>
                        </tr>
                        <tr>
                            <td class="title">Dirección</td>
                            <td>{{ $quotation->client->address }}</td>
                        </tr>
                        <tr>
                            <td class="title">Lugar</td>
                            <td>{{ $quotation->client->city }}</td>
                        </tr>
                        <tr>
                            <td class="title">Teléfono</td>
                            <td>{{ $quotation->client->phone }}</td>
                        </tr>
                        <tr>
                            <td class="title">Email</td>
                            <td>{{ $quotation->client->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-xs-12">
                <table class="table">
                    <thead>
                        <tr class="title">
                            <th class="centered">CANTIDAD</th>
                            <th class="centered">MODELO</th>
                            <th class="centered">DESCRIPCIÓN</th>
                            <th class="centered">PRECIO</th>
                            <th class="centered">DESCUENTO</th>
                            <th style="width: 15%">IMPORTE NETO</th>
                        </tr>
                    </thead>
                    
                    @php
                        $shipping = 0;
                    @endphp

                    <tbody>
                    @foreach ($quotation->movements as $movement)
                        @if($movement->product->family != 'ENVÍOS')
                            <tr>
                                <td class="centered">{{ $movement->quantity }}</td>
                                <td class="centered">{{ $movement->product->code }}</td>
                                <td class="centered">{{ $movement->product->description }}</td>
                                <td style="text-align: right;">{{ number_format($movement->price, 2) }}</td>
                                <td class="centered">{{ $movement->discount }} %</td>
                                <td style="text-align: right;">{{ number_format($movement->total, 2) }}</td>
                            </tr>
                        @else
                            @php
                                $shipping += $movement->total;
                            @endphp
                        @endif
                    @endforeach

                        <tr>
                            <th colspan="6" class="terms-and-conditions">
                                NUESTROS REPRESENTANTES DE VENTA NO ESTÁN AUTORIZADOS A RECIBIR PAGOS HECHOS. SOLO ACEPTAMOS ESTOS PAGOS DIRECTAMENTE EN LA CAJA DE NUESTRAS SUCURSALES Y USTED DEBERÁ RECIBIR UN COMPROBANTE DE RECIBO DE EFECTIVO, MEMBRETADO, FOLIADO, Y FIRMADO POR LA CAJERA Y EL GERENTE DE LA SUCURSAL; SI USTED EFECTUA SU PAGO A NUESTRO REPRESENTANTE, ESTE DEBERÁ SER CON CHEQUE NOMINATIVO A FAVOR DE GRUPO FINANCIERO PAAL S.A. DE C.V. CON LA LEYENDA "PARA ABONO EN CUENTA DEL BENEFICIARIO". NO NOS HACEMOS REPONSABLES POR PAGOS QUE NO CUMPLAN CON ESTOS REQUISITOS. LOS PRECIOS COTIZADOS EN DOLARES O EUROS SE TOMARÁN AL TIPO DE CAMBIO VIGENTE EL DÍA DEL PAGO.
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" rowspan="3" style="text-align: center">Firma</th>
                            <td colspan="2" rowspan="3" style="text-align: center">
                                Todos los productos que vendemos están protegidos por nuestro programa de garantía, servicio y refacciones
                            </td>
                            <td>Envío</td>
                            <td style="text-align: right;">{{ number_format($shipping, 2) }}</td>
                        </tr>
                        <tr>
                            <th style="color: red">TOTAL</th>
                            <th style="color: red; text-align: right;">{{ number_format($quotation->amount, 2) }}</th>
                        </tr>

                        <tr>
                            <td colspan="6">
                                &nbsp;
                            </td>
                        </tr>

                        <tr>
                            <th colspan="6" class="terms-and-conditions">
                                TIEMPO DE ENTREGA: El tiempo de entrega de los equipos se contará a partir de la recepción del 50 % de anticipo, así como el respectivo pedido firmado por el cliente. En caso de ser un equipo o mobiliario especial, se deberá contar además con los datos y especificaciones necesarias para su fabricación. Toda cancelación de equipo causara una penalidad del 50 % del valor tota. en todos los pedidos de mobiliario, comercialización o equipos de fabricación especial, NO se aceptan cancelaciones, devoluciones, ni cambios una vez fincado el pedido. Los precios cotizados estarán sujetos a cambios sin previo aviso. /SERVICIO Y GARANTIA: Todos los equipos vendidos contarán con un año de garantia a partir de la fecha de la factura cubriendo solo defectos de fabricación. Todas las partes para el control y flujo de corriente eléctrica, gozarán de un período de 90 días. La garantia no cubre los muebles y equipos descoompuestos por maltrato en su manejo o falta de mantenimiento. FLETE: En los casos en el que el flete esté incluido, esté solo será dentro del área metropolitana y se considerará de nuestras instalaciones a la obra a donde vaya a ser entregado el equipo. En caso que la dirección de entrega tenga alguna característica por la cual se necesitan maniobras especiales estas serán a cargo y responsabilidad del cliente. Las entregas se harán en un horario abierto de 9:30 a las 17:00 horas. Flete por cobrar. El embalaje tendrá un costo extra. La entrega de los equipos se hará a pie de camión, sin considerar maniobras a otros pisos. NO se realizarán ningún embarque, si el equipo no se encuentra totalmente liquidado. /MONTAJE E INTERCONEXIÓN: Montaje y embalaje del equipo y/o mobiliario NO está incluido, este deberá ser cotizado cuando se requiere y considera en: armado en obra de los muebles y equipos que lo requieran, colgado de campanas, fijación de repisas y muebles a muro (en su caso), y nivelación del equipo, proporcionando la mano de obra, maquinaria y herramientas de campo necesarias para los trabajos. Cotización válida por 3 días, los precios cotizados estan sujetos a cambios sin previo aviso. PARA CUALQUIER ACLARACIÓN COMUNIQUESE A LOS TELÉFONOS ARRIBA MENCIONADOS, CON EL AGENTE QUE LE ATENDIÓ O CON EL DEPARTAMENTO DE ATENCIÓN A CLIENTES.
                            </th>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
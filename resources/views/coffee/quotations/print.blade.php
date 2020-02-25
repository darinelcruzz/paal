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
        
        <link rel="stylesheet" href="{{ asset('css/printable.css') }}" media="all">

        <link rel="icon" href="{{ asset("/img/coffee.ico") }}" />
    </head>

    <body onload="window.print();">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <td style="text-align: center;">
                                <img width="100px" src="{{ asset('/img/coffee.png') }}">
                            </td>
                            <td width="60%">
                                <big><b>COFFEE DEPOT</b></big>
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
                            <td class="title">No. Asesor</td>
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
                        $subtotal = 0;
                        $shipping = 0;
                    @endphp

                    <tbody>
                    @foreach (unserialize($quotation->products) as $item)
                        @php
                            $product = App\Product::find($item['i'])
                        @endphp
                        @if($product->family != 'ENVÍOS')
                            <tr>
                                <td class="centered">{{ $item['q'] }}</td>
                                <td class="centered">{{ $product->code }}</td>
                                <td class="centered">{{ $product->description }}</td>
                                <td style="text-align: right;">{{ number_format($item['p'], 2) }}</td>
                                <td class="centered">{{ $item['d'] }} %</td>
                                <td style="text-align: right;">{{ number_format($item['t'], 2) }}</td>
                            </tr>
                            @php
                                $subtotal += $item['t'];
                            @endphp
                        @else
                            @php
                                $shipping += $item['p'];
                            @endphp
                        @endif
                    @endforeach

                    @if($quotation->special_products)
                        @foreach (unserialize($quotation->special_products) as $product)
                            <tr>
                                <td>{{ $product['q'] }}</td>
                                <td>N/A</td>
                                <td>{{ $product['i'] }}</td>
                                <td>{{ number_format($product['p'], 2) }}</td>
                                <td>{{ number_format($product['d'], 2) }}</td>
                                <td>{{ number_format($product['t'], 2) }}</td>
                            </tr>
                            @php
                                $subtotal += $product['t'];
                            @endphp
                        @endforeach
                    @endif

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
                            <th style="color: red"><big>TOTAL</big></th>
                            <th style="color: red; text-align: right;"><big>{{ number_format($quotation->amount, 2) }}</big></th>
                        </tr>

                        <tr>
                            <td colspan="6">
                                &nbsp;
                            </td>
                        </tr>

                        <tr>
                            <th colspan="6" class="terms-and-conditions">
                                TIEMPO DE ENTREGA: EL TIEMPO DE ENTREGA DE LOS EQUIPOS SE CONTARÁ A PARTIR DE LA RECEPCIÓN DEL 50 % DE ANTICIPO, ASÍ COMO EL RESPECTIVO PEDIDO FIRMADO POR EL CLIENTE. EN CASO DE SER UN EQUIPO O MOBILIARIO ESPECIAL, SE DEBERÁ CONTAR ADEMÁS CON LOS DATOS Y ESPECIFICACIONES NECESARIAS PARA SU FABRICACIÓN. TODA CANCELACIÓN DE EQUIPO CAUSARA UNA PENALIDAD DEL 50 % DEL VALOR TOTA. EN TODOS LOS PEDIDOS DE MOBILIARIO, COMERCIALIZACIÓN O EQUIPOS DE FABRICACIÓN ESPECIAL, NO SE ACEPTAN CANCELACIONES, DEVOLUCIONES, NI CAMBIOS UNA VEZ FINCADO EL PEDIDO. LOS PRECIOS COTIZADOS ESTARÁN SUJETOS A CAMBIOS SIN PREVIO AVISO. /SERVICIO Y GARANTIA: TODOS LOS EQUIPOS VENDIDOS CONTARÁN CON UN AÑO DE GARANTIA A PARTIR DE LA FECHA DE LA FACTURA CUBRIENDO SOLO DEFECTOS DE FABRICACIÓN. TODAS LAS PARTES PARA EL CONTROL Y FLUJO DE CORRIENTE ELÉCTRICA, GOZARÁN DE UN PERÍODO DE 90 DÍAS. LA GARANTIA NO CUBRE LOS MUEBLES Y EQUIPOS DESCOOMPUESTOS POR MALTRATO EN SU MANEJO O FALTA DE MANTENIMIENTO. FLETE: EN LOS CASOS EN EL QUE EL FLETE ESTÉ INCLUIDO, ESTÉ SOLO SERÁ DENTRO DEL ÁREA METROPOLITANA Y SE CONSIDERARÁ DE NUESTRAS INSTALACIONES A LA OBRA A DONDE VAYA A SER ENTREGADO EL EQUIPO. EN CASO QUE LA DIRECCIÓN DE ENTREGA TENGA ALGUNA CARACTERÍSTICA POR LA CUAL SE NECESITAN MANIOBRAS ESPECIALES ESTAS SERÁN A CARGO Y RESPONSABILIDAD DEL CLIENTE. LAS ENTREGAS SE HARÁN EN UN HORARIO ABIERTO DE 9:30 A LAS 17:00 HORAS. FLETE POR COBRAR. EL EMBALAJE TENDRÁ UN COSTO EXTRA. LA ENTREGA DE LOS EQUIPOS SE HARÁ A PIE DE CAMIÓN, SIN CONSIDERAR MANIOBRAS A OTROS PISOS. NO SE REALIZARÁN NINGÚN EMBARQUE, SI EL EQUIPO NO SE ENCUENTRA TOTALMENTE LIQUIDADO. /MONTAJE E INTERCONEXIÓN: MONTAJE Y EMBALAJE DEL EQUIPO Y/O MOBILIARIO NO ESTÁ INCLUIDO, ESTE DEBERÁ SER COTIZADO CUANDO SE REQUIERE Y CONSIDERA EN: ARMADO EN OBRA DE LOS MUEBLES Y EQUIPOS QUE LO REQUIERAN, COLGADO DE CAMPANAS, FIJACIÓN DE REPISAS Y MUEBLES A MURO (EN SU CASO), Y NIVELACIÓN DEL EQUIPO, PROPORCIONANDO LA MANO DE OBRA, MAQUINARIA Y HERRAMIENTAS DE CAMPO NECESARIAS PARA LOS TRABAJOS. COTIZACIÓN VÁLIDA POR 3 DÍAS, LOS PRECIOS COTIZADOS ESTAN SUJETOS A CAMBIOS SIN PREVIO AVISO. PARA CUALQUIER ACLARACIÓN COMUNIQUESE A LOS TELÉFONOS ARRIBA MENCIONADOS, CON EL AGENTE QUE LE ATENDIÓ O CON EL DEPARTAMENTO DE ATENCIÓN A CLIENTES.
                            </th>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
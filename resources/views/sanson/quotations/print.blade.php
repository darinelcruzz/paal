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
                                <img width="100px" src="{{ asset('/img/sanson-pdf.png') }}">
                            </td>
                            <td width="60%">
                                <big><b>SAN-SON</b></big>
                                SUCURSAL CHIAPAS<br>
                                16 Poniente Norte #138<br>
                                Col. Las Arboledas, C.P. 29030 <br>
                                <i class="fa fa-phone"></i> 01 (961) 1215704 | 1213404&nbsp;&nbsp;&nbsp;&nbsp;
                                <i class="fa fa-whatsapp"></i> 961 249 8806<br>
                                <i class="fa fa-envelope"></i> ventas@sansonchiapas.com <br>
                                <i class="fa fa-facebook"></i> SAN-SON CHIAPAS
                            </td>
                            <td>                                
                                <table style="text-align: right">
                                    <tbody>
                                        <tr style="text-align: right;">
                                            <td><b>COTIZACIÓN</b></td>
                                        </tr>
                                        <tr style="background-color: rgb(78, 78, 78); color: white; text-align: right">
                                            <td>&nbsp;&nbsp;MAQUINARIA&nbsp;&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                {{ substr("0000{$quotation->id}", -4) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table width="100%">
                    <tbody>
                        <tr>
                            <th class="title">&nbsp;No. Asesor</th>
                            <td>&nbsp;{{ auth()->user()->id }}</td>
                            <th class="title">&nbsp;Email</th>
                            <td>&nbsp;ventas@sansonchiapas.com</td>
                            <th class="title">&nbsp;Fecha de expedición</th>
                            <td style="width: 15%; text-align: right;">&nbsp;{{ fdate($quotation->updated_at, 'd/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th class="title">&nbsp;Nombre</th>
                            <td colspan="3">&nbsp;{{ auth()->user()->name }}</td>
                            <th class="title">&nbsp;Vigencia</th>
                            <td style="width: 15%; text-align: right;">&nbsp;{{ date('d/m/Y', strtotime($quotation->updated_at) + 3 * 24 * 60 * 60) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6">&nbsp;</td>
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
                            <th colspan="4" style="text-align: center">DATOS DEL CLIENTE</th>
                            <th style="width: 40%; text-align: center">OBSERVACIONES</th>
                        </tr>
                        <tr>
                            <td class="title" style="width: 10%"> &nbsp;Empresa</td>
                            <td style="font-size: 10px;" colspan="3"> 
                                &nbsp;{{ ucwords(strtolower($quotation->client->company == 'internet' ? $quotation->client_name: $quotation->client->name)) }}
                            </td>
                            <td rowspan="6" style="width: {{ strlen($quotation->client->name) > 20 ? '35%': '40%' }}; font-size: 10px;">
                                PRECIOS CON VIGENCIA DE 3 DÍAS HÁBILES. <br>
                                EN CASO DE COMPRA, CONFIRMAR EXISTENCIAS DE LOS EQUIPOS O EN SU CASO DE NO TENER EXISTENCIA VERIFICAR LOS TIEMPOS DE ENTREGA.
                            </td>
                        </tr>
                        <tr>
                            <td class="title"> &nbsp;Solicitante</td>
                            <td style="font-size: 10px;" colspan="3">
                                &nbsp;{{ ucwords(strtolower($quotation->client->company == 'internet' ? $quotation->client_name: $quotation->client->name)) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="title"> &nbsp;Dirección</td>
                            <td> &nbsp;{{ ucwords(strtolower($quotation->client->address)) }}</td>
                            <td class="title"> &nbsp;Lugar</td>
                            <td> &nbsp;{{ ucwords(strtolower($quotation->client->city)) }}</td>
                        </tr>
                        <tr>
                            <td class="title"> &nbsp;Email</td>
                            <td> &nbsp;{{ $quotation->client->company == 'internet' ? $quotation->email: $quotation->client->email }}</td>
                            <td class="title"> &nbsp;Teléfono</td>
                            <td> &nbsp;{{ $quotation->client->phone }}</td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
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
                            <th class="centered" style="width: 25%">DESCRIPCIÓN</th>
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
                                <td>
                                    {{ $movement->product->description }}
                                    @if($movement->product->features)
                                        <br>
                                        {!! str_replace(',', '<br>', $movement->product->features) !!}
                                    @endif
                                </td>
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
                    </tbody>
                </table>

                <table class="table">
                    <tbody>
                        <tr>
                            <th colspan="2" style="text-align: center">Firma</th>
                            <td colspan="2" style="text-align: center; width: 50%">
                                Todos los productos que vendemos están protegidos por nuestro programa de garantía, servicio y refacciones <br><br>
                            </td>
                            <td>
                                Envío <br>
                                I.V.A. <br>
                                <span style="color: red"><big>TOTAL</big></span>
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($shipping, 2) }} <br>
                                {{ number_format($quotation->iva, 2) }} <br>
                                <span style="color: red; text-align: right;"><big>{{ number_format($quotation->amount, 2) }}</big></span>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="6" class="terms-and-conditions">
                                NUESTROS REPRESENTANTES DE VENTA NO ESTÁN AUTORIZADOS A RECIBIR PAGOS HECHOS. SOLO ACEPTAMOS ESTOS PAGOS DIRECTAMENTE EN LA CAJA DE NUESTRAS SUCURSALES Y USTED DEBERÁ RECIBIR UN COMPROBANTE DE RECIBO DE EFECTIVO, MEMBRETADO, FOLIADO, Y FIRMADO POR LA CAJERA Y EL GERENTE DE LA SUCURSAL; SI USTED EFECTUA SU PAGO A NUESTRO REPRESENTANTE, ESTE DEBERÁ SER CON CHEQUE NOMINATIVO A FAVOR DE GRUPO FINANCIERO PAAL S.A. DE C.V. CON LA LEYENDA "PARA ABONO EN CUENTA DEL BENEFICIARIO". NO NOS HACEMOS REPONSABLES POR PAGOS QUE NO CUMPLAN CON ESTOS REQUISITOS. LOS PRECIOS COTIZADOS EN DOLARES O EUROS SE TOMARÁN AL TIPO DE CAMBIO VIGENTE EL DÍA DEL PAGO.
                            </th>
                        </tr>
                        <tr>
                            <th colspan="6" class="terms-and-conditions">
                                TIEMPO DE ENTREGA: EL TIEMPO DE ENTREGA DE LOS EQUIPOS SE CONTARÁ A PARTIR DE LA RECEPCIÓN DEL 50 % DE ANTICIPO, ASÍ COMO EL RESPECTIVO PEDIDO FIRMADO POR EL CLIENTE. EN CASO DE SER UN EQUIPO O MOBILIARIO ESPECIAL, SE DEBERÁ CONTAR ADEMÁS CON LOS DATOS Y ESPECIFICACIONES NECESARIAS PARA SU FABRICACIÓN. TODA CANCELACIÓN DE EQUIPO CAUSARA UNA PENALIDAD DEL 50 % DEL VALOR TOTA. EN TODOS LOS PEDIDOS DE MOBILIARIO, COMERCIALIZACIÓN O EQUIPOS DE FABRICACIÓN ESPECIAL, NO SE ACEPTAN CANCELACIONES, DEVOLUCIONES, NI CAMBIOS UNA VEZ FINCADO EL PEDIDO. LOS PRECIOS COTIZADOS ESTARÁN SUJETOS A CAMBIOS SIN PREVIO AVISO. /SERVICIO Y GARANTIA: TODOS LOS EQUIPOS VENDIDOS CONTARÁN CON UN AÑO DE GARANTIA A PARTIR DE LA FECHA DE LA FACTURA CUBRIENDO SOLO DEFECTOS DE FABRICACIÓN. TODAS LAS PARTES PARA EL CONTROL Y FLUJO DE CORRIENTE ELÉCTRICA, GOZARÁN DE UN PERÍODO DE 90 DÍAS. LA GARANTIA NO CUBRE LOS MUEBLES Y EQUIPOS DESCOOMPUESTOS POR MALTRATO EN SU MANEJO O FALTA DE MANTENIMIENTO. FLETE: EN LOS CASOS EN EL QUE EL FLETE ESTÉ INCLUIDO, ESTÉ SOLO SERÁ DENTRO DEL ÁREA METROPOLITANA Y SE CONSIDERARÁ DE NUESTRAS INSTALACIONES A LA OBRA A DONDE VAYA A SER ENTREGADO EL EQUIPO. EN CASO QUE LA DIRECCIÓN DE ENTREGA TENGA ALGUNA CARACTERÍSTICA POR LA CUAL SE NECESITAN MANIOBRAS ESPECIALES ESTAS SERÁN A CARGO Y RESPONSABILIDAD DEL CLIENTE. LAS ENTREGAS SE HARÁN EN UN HORARIO ABIERTO DE 9:30 A LAS 17:00 HORAS. FLETE POR COBRAR. EL EMBALAJE TENDRÁ UN COSTO EXTRA. LA ENTREGA DE LOS EQUIPOS SE HARÁ A PIE DE CAMIÓN, SIN CONSIDERAR MANIOBRAS A OTROS PISOS. NO SE REALIZARÁN NINGÚN EMBARQUE, SI EL EQUIPO NO SE ENCUENTRA TOTALMENTE LIQUIDADO. /MONTAJE E INTERCONEXIÓN: MONTAJE Y EMBALAJE DEL EQUIPO Y/O MOBILIARIO NO ESTÁ INCLUIDO, ESTE DEBERÁ SER COTIZADO CUANDO SE REQUIERE Y CONSIDERA EN: ARMADO EN OBRA DE LOS MUEBLES Y EQUIPOS QUE LO REQUIERAN, COLGADO DE CAMPANAS, FIJACIÓN DE REPISAS Y MUEBLES A MURO (EN SU CASO), Y NIVELACIÓN DEL EQUIPO, PROPORCIONANDO LA MANO DE OBRA, MAQUINARIA Y HERRAMIENTAS DE CAMPO NECESARIAS PARA LOS TRABAJOS. COTIZACIÓN VÁLIDA POR 3 DÍAS, LOS PRECIOS COTIZADOS ESTAN SUJETOS A CAMBIOS SIN PREVIO AVISO. PARA CUALQUIER ACLARACIÓN COMUNIQUESE A LOS TELÉFONOS ARRIBA MENCIONADOS, CON EL AGENTE QUE LE ATENDIÓ O CON EL DEPARTAMENTO DE ATENCIÓN A CLIENTES.
                            </th>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <img width="100px" src="{{ asset('/img/bancomer.jpeg') }}">
                            </td>
                            <td colspan="2">
                                GRUPO FINANCIERO PAAL. S.A. DE C.V.<br>
                                GFP140325SX0 <br>
                            </td>
                            <td colspan="2">
                                NO. DE CUENTA: 0115253314<br>
                                CLABE: 0121 0000 1152 5331 47
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

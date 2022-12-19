<html translate="no">
<head>
    <meta charset="UTF-8">
    <title>Productos Efectivo</title>
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
</head>

<body onload="window.print();">

    <div class="row">
        <div class="col-md-12">
            <table width="100%">
                <thead>
                    <tr>
                        <th><small>CANT</small></th>
                        <th><small>PRODUCTO</small></th>
                        <th style="text-align: right;"><small>PRECIO</small></th>
                        <th style="text-align: right;"><small>IMPORTE</small></th>
                    </tr>
                </thead>

                @php
                    $total = 0;
                @endphp

                <tbody>
                    @foreach($movements as $description => $prices)
                        @foreach($prices as $price => $elements)
                        <tr>
                            <td style="text-align: center;">{{ $elements->sum('quantity') }}</td>
                            <td>{{ $description }}</td>
                            <td style="text-align: right;">{{ number_format($price, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($elements->sum('quantity') * $price, 2) }}</td>
                            @php
                                $total += $elements->sum('quantity') * $price;
                            @endphp
                        </tr>
                        @endforeach()
                    @endforeach()
                </tbody>

                <tfoot>
                    <tr>
                        <th style="text-align: right;" colspan="3"><small>SUBTOTAL</small></th>
                        <th style="text-align: right;">{{ number_format($total + $rounding, 2) }}</th>
                    </tr>
                    <tr>
                        <th style="text-align: right;" colspan="3"><small>I.V.A.</small></th>
                        <th style="text-align: right;">{{ number_format($iva, 2) }}</th>
                    </tr>
                    <tr>
                        <th style="text-align: right;" colspan="3"><small>TOTAL</small></th>
                        <th style="text-align: right;">{{ number_format($total + $rounding + $iva, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
        
</body>
</html>

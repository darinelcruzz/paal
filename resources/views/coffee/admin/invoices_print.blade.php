<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
      Depositos pendientes
  </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset("/img/coffee.ico") }}" />
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
  {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"> --}}
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/Ionicons/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}">


  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">

  <link href="{{ asset('css/flag-icon.css') }}" rel="stylesheet">

</head>

<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <img width="50px" src="{{ asset('/img/coffee.png') }}">&nbsp;&nbsp; COFFEE DEPOT | SUCURSAL CHIAPAS
          <small class="pull-right">{{ date('d-m-Y') }}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-6 invoice-col">
        <strong>Dirección</strong>
        <address>
          	Blvd Angel Albino Corzo #955<br>
	        Loc A y B COl. Las Palmas CP 29040 <br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-6 invoice-col">
        <strong>Contacto</strong>
        <address>
          	<i class="fa fa-phone"></i> 01 (961) 121 34 04 <br>
	        <i class="fa fa-whatsapp"></i> 961 330 65 28<br>
	        <i class="fa fa-envelope"></i> ventas@coffeedepotchiapas.com.mx <br>
        </address>
      </div>
    </div>
    <!-- /.row -->

    <h4 align="center">DEPOSITOS A REALIZAR</h4>

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Fecha</th>
            <th>I.V.A.</th>
            <th>Importe</th>
          </tr>
          </thead>
          <tbody>

          	@php
          		$amount = 0;
          		$iva = 0;
          	@endphp

            @foreach($invoices as $date => $sales)
            	<tr>
                    <td>{{ fdate($date, 'd \d\e F Y', 'Y-m-d') }}</td>
                    <td>$ {{ number_format($sales->sum('iva'), 2) }}</td>
                    <td>$ {{ number_format($sales->sum('amount'), 2) }}</td>
                </tr>
                @php
	              	$amount += $sales->sum('amount');
	              	$iva += $sales->sum('iva');
	             @endphp     
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        <p class="lead">OBSERVACIONES:</p>

        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
          jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
        </p>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">A depositar</p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td>$ {{ number_format($amount - $iva, 2) }}</td>
            </tr>
            <tr>
              <th>I.V.A.</th>
              <td>$ {{ number_format($iva, 2) }}</td>
            </tr>
            <tr>
              <th>Total:</th>
              <td>$ {{ number_format($amount, 2) }}</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>

</html>
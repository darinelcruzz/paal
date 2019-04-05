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
{{-- <body> --}}
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-md-12">
        <table class="table">
          <thead>
          <tr>
            <th colspan="2">              
              <h4 class="page-header">
                <b>BANCOMER BBVA</b> <br>
                GRUPO FINANCIERO PAAL SA DE CV <br>
                CUENTA 0196214193
              </h4>
            </th>
          </tr>
          </thead>
          
        </table>
        
      </div>
      <!-- /.col -->
    </div>

    <h4 align="center">DEPOSITOS A REALIZAR</h4>

    <!-- Table row -->
    <div class="row">
      <div class="col-md-12 table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th style="border-bottom: double;">F E C H A</th>
            <th style="text-align: right; border-bottom: double;">I M P O R T E</th>
          </tr>
          </thead>
          <tbody>

          	@php
          		$amount = 0;
          	@endphp

            @foreach($invoices as $date => $sales)
                <tr>
                    <td>{{ fdate($date, 'd/m/Y', 'Y-m-d') }}</td>
                    <td style="text-align: right;">$ {{ number_format($sales->sum('amount'), 2) }}</td>
                  </tr>
                  @php
                    $amount += $sales->sum('amount');
                 @endphp
            @endforeach
          </tbody>

          <tfoot>
            <tr>
              <td>&nbsp;</td>
              <td style="border-top: double;">
                <span class="pull-left"><b>T O T A L</b></span>
                <span class="pull-right">$ {{ number_format($amount, 2) }}</span>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>

</html>
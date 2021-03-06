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
              <h3>
                <b>BANCOMER BBVA</b> <br>
                <small>GRUPO FINANCIERO PAAL SA DE CV <br>
                CUENTA <b>0196214193</b></small>
              </h3>
            </th>
          </tr>
          </thead>
          
        </table>
        
      </div>
      <!-- /.col -->
    </div>

    <h5 align="center">DEPOSITOS A REALIZAR</h5>

    <!-- Table row -->
    <div class="row">
      <div class="col-md-12 table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th style="border-bottom: double;">F E C H A</th>
            <th style="border-bottom: double; text-align: center;">I M P O R T E</th>
          </tr>
          </thead>
          <tbody>

          	@php
          		$amount = 0;
          	@endphp

            @foreach($invoices as $date => $sales)

               @php
                  $subamount = 0;
                  foreach ($sales as $sale) {
                      $subamount += $sale->payments->sum('cash');
                  }
               @endphp

                @if ($subamount)
                  <tr>
                    <td>{{ fdate($date, 'd/m/Y', 'Y-m-d') }}</td>
                    <td style="text-align: center;">$ {{ number_format($subamount, 2) }}</td>
                  </tr>
                @endif

                @php
                  $amount += $subamount;
               @endphp

            @endforeach
          </tbody>

          <tfoot>
            <tr style="border-top: double;">
              <th>T O T A L</th>
              <td style="text-align: center;">
                $ {{ number_format($amount, 2) }}
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
@extends('paal.root')

@push('pageTitle')
    Ingresos | Recibo
@endpush


@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="invoice">
              <!-- title row -->
              <div class="row">
                <div class="col-xs-12">
                  <h2 class="page-header">
                    <i class="fa fa-globe"></i> PAAL
                  </h2>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Cliente
                  <address>
                    <strong>{{ App\Client::find($info['client_id'])->name }}</strong><br>
                    {{ App\Client::find($info['client_id'])->address }}<br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>#007612</b><br>
                  {{ Date::now()->format('d/M/Y') }}<br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->


              <div class="row">
                <div class="col-xs-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cantidad</th>
                            <th>Producto</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < count($info['products']); $i++)
                            <tr>
                                <td>{{ $info['quantities'][$i] }}</td>
                                <td>{{ App\Product::find($info['products'][$i])->description }}</td>
                                <td>$ {{ $info['subtotals'][$i] }}</td>
                            </tr>
                        @endfor
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Total:</th>
                            <td>$ {{ $info['total'] }}</td>
                        </tr>
                    </tfoot>
                  </table>
                </div>

              </div>
              <!-- /.row -->

              
              <div class="row no-print">
                <div class="col-xs-12">
                    <button onclick="printTicket()" class="btn btn-default">
                        <i class="fa fa-print"></i> Imprimir
                    </button>
                </div>
              </div>
            </section>
        </div>
    </div>

@endsection

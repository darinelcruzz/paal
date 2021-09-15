@extends('coffee.root')

@push('pageTitle', 'Coffee | Marketing')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <solid-box title="CLIENTES ({{ $clientsTotal }})" color="danger">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th style="width: 15%; text-align: center;"><small>CANTIDAD</small></th>
                            <th style="width: 15%; text-align: center;"><i class="fa fa-percentage"></i></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th><small>COMPRARON ESTE MES</small></th>
                            <td style="text-align: center;">{{ $clientsOfThisMonth }}</td>
                            <td style="text-align: right;">{{ number_format(($clientsOfThisMonth / $clientsTotal) * 100, 2) }}</td>
                        </tr>
                        <tr>
                            <th><small>COMPRARON ESTE MES Y EL ANTERIOR</small></th>
                            <td style="text-align: center;">{{ $clientsOfLastTwoMonths }}</td>
                            <td style="text-align: right;">{{ number_format(($clientsOfLastTwoMonths / $clientsTotal) * 100, 2) }}</td>
                        </tr>
                        <tr>
                            <th><small>NUEVOS</small></th>
                            <td style="text-align: center;">{{ $newClients }}</td>
                            <td style="text-align: right;">{{ number_format(($newClients / $clientsTotal) * 100, 2) }}</td>
                        </tr>
                        <tr>
                            <th><small>DE REGRESO</small></th>
                            <td style="text-align: center;">{{ $clientsOfThisMonth - $clientsOfLastTwoMonths - $newClients }}</td>
                            <td style="text-align: right;">{{ number_format((($clientsOfThisMonth - $clientsOfLastTwoMonths - $newClients) / $clientsTotal) * 100, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </solid-box>
        </div>

        <div class="col-md-3">
            <solid-box title="COTIZACIONES ({{ $quotationsTotal }})" color="warning">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th style="width: 15%; text-align: center;"><small>CANTIDAD</small></th>
                            <th style="width: 15%; text-align: center;"><i class="fa fa-percentage"></i></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th><small>EQUIPOS</small></th>
                            <td style="text-align: center;">{{ $equipmentQuotations }}</td>
                            <td style="text-align: right;">{{ number_format(($equipmentQuotations / $quotationsTotal) * 100, 2) }}</td>
                        </tr>
                        <tr>
                            <th><small>CAMPAÑAS</small></th>
                            <td style="text-align: center;">{{ $campaigns }}</td>
                            <td style="text-align: right;">{{ number_format(($campaigns / $quotationsTotal) * 100, 2) }}</td>
                        </tr>
                        <tr>
                            <th><small>VENTAS</small></th>
                            <td style="text-align: center;">{{ $salesFromQuotations }}</td>
                            <td style="text-align: right;">{{ number_format(($salesFromQuotations / $quotationsTotal) * 100, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="TOP 5 PRODUCTOS" color="primary">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><small>DESCRIPCIÓN</small></th>
                            <th style="width: 15%; text-align: center;"><small>CANTIDAD</small></th>
                            <th style="width: 15%; text-align: right;"><small>MONTO</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($topProducts as $product => $values)
                        <tr>
                            <td>{{ $product }}</td>
                            <td style="text-align: center;">{{ $values['quantity'] }}</td>
                            <td style="text-align: right;">{{ number_format($values['amount'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </solid-box>
        </div>
    </div>

@endsection

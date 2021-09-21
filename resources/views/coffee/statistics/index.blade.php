@extends('coffee.root')

@push('pageTitle', 'Coffee | Marketing')

@section('content')

    <div class="row">
        <div class="col-md-4">
            <solid-box title="CLIENTES ({{ $clientsTotal }})" color="danger">
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <th><small>FRECUENTES</small></th>
                            <td style="text-align: right;">{{ $clientsOfThisMonth }}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;<small>ACTIVOS</small></td>
                            <td style="text-align: right;">{{ $clientsOfLastTwoMonths }}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;<small>DE REGRESO</small></td>
                            <td style="text-align: right;">{{ $clientsOfThisMonth - $clientsOfLastTwoMonths - $newClients }}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;<small>NUEVOS</small></td>
                            <td style="text-align: right;">{{ $newClients }}</td>
                        </tr>
                        <tr>
                            <th><small>NO FRECUENTES</small></th>
                            <td style="text-align: right;">{{ $clientsTotal - $clientsOfThisMonth }}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;<small>NUEVOS</small></td>
                            <td style="text-align: right;">{{ 0 }}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;<small>HABITUALES</small></td>
                            <td style="text-align: right;">{{ 0 }}</td>
                        </tr>
                    </tbody>
                </table>
            </solid-box>
        </div>

        {{-- <div class="col-md-3">
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
        </div> --}}

        {{-- <div class="col-md-6">
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

    <div class="row"> --}}
        
        <div class="col-md-6">
            <solid-box title="TOP 5 CLIENTES" color="danger">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><small>CLIENTE</small></th>
                            <th style="width: 15%; text-align: center;"><small>COMPRAS</small></th>
                            <th style="width: 15%; text-align: right;"><small>MONTO</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($topClients as $client)
                        <tr>
                            <td>
                                <a href="{{ route('coffee.client.show', [$client['id'], 'ventas']) }}">
                                    {{ $client['name'] }}
                                </a>
                            </td>
                            <td style="text-align: center;">{{ $client['quantity'] }}</td>
                            <td style="text-align: right;">{{ number_format($client['amount'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </solid-box>
        </div>
    </div>

@endsection

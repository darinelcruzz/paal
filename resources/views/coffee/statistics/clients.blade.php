@extends('coffee.root')

@push('pageTitle', 'Coffee | Marketing')

@section('content')

    <div class="row">
        <div class="col-md-4">
            <solid-box title="CLIENTES" color="danger">
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <th><small>FRECUENTES</small></th>
                            <th style="text-align: right;width: 5%;"></th>
                            <th style="text-align: right;">{{ $usualClients->count() }}</th>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;<small>ACTIVOS</small></td>
                            <td style="width: 5%;">
                            </td>
                            <td style="text-align: right;">{{ $usualClients->count() - $clientsComingBack->count() - $newClients->count() }}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;<small>DE REGRESO</small></td>
                            <td style="width: 5%;">
                                <a data-toggle="modal" data-target="#clients-comingback">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <modal title="DE REGRESO" color="danger" id="clients-comingback">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-condensed spanish-simple">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70%;"><small>NOMBRE</small></th>
                                                    <th style="text-align: center;width: 10%;"><small>COMPRAS</small></th>
                                                    <th style="text-align: right;width: 20%;"><small>MONTO</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($clientsComingBack as $key => $values)
                                                <tr>
                                                    <td style="width: 70%;">
                                                        <a href="{{ route('coffee.client.show', [$values['id'], 'ventas']) }}" target="_BLANK">
                                                            <small>{{ strtoupper($values['name']) }}</small>
                                                        </a>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        {{ $values['quantity'] }}
                                                    </td>
                                                    <td style="text-align: right;">{{ number_format($values['amount'], 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </modal>
                            </td>
                            <td style="text-align: right;">{{ $clientsComingBack->count() }}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;<small>NUEVOS</small></td>
                            <td style="width: 5%;">
                                <a data-toggle="modal" data-target="#new-clients">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <modal title="NUEVOS" color="danger" id="new-clients">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-condensed spanish-simple">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70%;"><small>NOMBRE</small></th>
                                                    <th style="text-align: center;width: 10%;"><small>COMPRAS</small></th>
                                                    <th style="text-align: right;width: 20%;"><small>MONTO</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($newClients as $key => $values)
                                                <tr>
                                                    <td style="width: 70%;">
                                                        <a href="{{ route('coffee.client.show', [$values['id'], 'ventas']) }}" target="_BLANK">
                                                            <small>{{ strtoupper($values['name']) }}</small>
                                                        </a>
                                                    </td>
                                                    <td style="text-align: center;">{{ $values['quantity'] }}</td>
                                                    <td style="text-align: right;">{{ number_format($values['amount'], 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </modal>
                            </td>
                            <td style="text-align: right;">{{ $newClients->count() }}</td>
                        </tr>
                        <tr>
                            <th><small>NO FRECUENTES</small></th>
                            <th style="text-align: right;width: 5%;"></th>
                            <th style="text-align: right;">{{ $unusualClients->count() + $newUnusualClients->count() }}</th>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;<small>NUEVOS</small></td>
                            <td style="width: 5%;">
                                <a data-toggle="modal" data-target="#new-unusual-clients">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <modal title="NUEVOS NO FRECUENTES" color="danger" id="new-unusual-clients">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-condensed spanish-simple">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70%;"><small>NOMBRE</small></th>
                                                    <th style="text-align: center;width: 10%;"><small>COMPRAS</small></th>
                                                    <th style="text-align: right;width: 20%;"><small>MONTO</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($newUnusualClients as $key => $values)
                                                <tr>
                                                    <td style="width: 70%;">
                                                        <a href="{{ route('coffee.client.show', [$values['id'], 'ventas']) }}" target="_BLANK">
                                                            <small>{{ strtoupper($values['name']) }}</small>
                                                        </a>
                                                    </td>
                                                    <td style="text-align: center;">{{ $values['quantity'] }}</td>
                                                    <td style="text-align: right;">{{ number_format($values['amount'], 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </modal>
                            </td>
                            <td style="text-align: right;">{{ $newUnusualClients->count() }}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;<small>HABITUALES</small></td>
                            <td style="text-align: right;width: 5%;"></td>
                            <td style="text-align: right;">{{ $unusualClients->count() }}</td>
                        </tr>
                    </tbody>
                </table>
            </solid-box>
        </div>
        
        <div class="col-md-6">
            <solid-box title="TOP 5 CLIENTES" color="danger">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 70%;"><small>NOMBRE</small></th>
                            <th style="width: 15%; text-align: center;"><small>COMPRAS</small></th>
                            <th style="width: 15%; text-align: right;"><small>MONTO</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($topClients as $client)
                        <tr>
                            <td>
                                <a href="{{ route('coffee.client.show', [$client['id'], 'ventas']) }}" target="_BLANK">
                                    {{ ucwords(strtolower($client['name'])) }}
                                </a>
                            </td>
                            <td style="text-align: center;">{{ $client['quantity'] }}</td>
                            <td style="text-align: right;">{{ number_format($client['amount'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th style="text-align: right;">{{ number_format($topClients->sum('amount'), 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </solid-box>
        </div>
    </div>

@endsection

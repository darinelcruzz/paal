@extends('coffee.root')

@push('pageTitle', 'Corte mensual')

@section('content')

    <div class="row">
        <div class="col-md-4">
            <icon-box title="total mensual" color="green" icon="usd" company="coffee" model="index" type="total" date="{{ date('Y-m') }}"></icon-box>
            {{-- <icon-box title="por depositar" color="red" icon="piggy-bank" company="coffee" model="index" type="depositar" date="{{ date('Y-m') }}"></icon-box> --}}
            <icon-box title="promedio" color="primary" icon="chart-line" company="coffee" model="index" type="promedio" date="{{ date('Y-m') }}"></icon-box>
            <icon-box title="envíos" color="yellow" icon="shipping-fast" company="coffee" model="index" type="envíos" date="{{ date('Y-m') }}"></icon-box>
        </div>
        <div class="col-md-8">
            <solid-box title="Comparación ventas" color="warning">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="text-align: center;"><small>TOTAL MENSUAL</small></th>
                                <th style="text-align: center;"><small>MES ANTERIOR</small></th>
                                <th style="text-align: center;"><small>PROMEDIO</small></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th><small>MONTO</small></th>
                                <td style="text-align: center;">{{ number_format($ingresses->sum('amount'), 2) }}</td>
                                <td style="text-align: center;">{{ number_format($ingresses2->sum('amount'), 2) }}</td>
                                <td style="text-align: center;">{{ number_format($ingresses3->sum('amount') / (date('m') - 1), 2) }}</td>
                            </tr>
                            <tr>
                                <th><small>VENTAS</small></th>
                                <td style="text-align: center;">{{ $ingresses->count() }}</td>
                                <td style="text-align: center;">{{ $ingresses2->count() }}</td>
                                <td style="text-align: center;">{{ number_format($ingresses3->count() / (date('m') - 1), 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </solid-box>

            <div class="row">
                <div class="col-md-6">
                    <solid-box title="Top 5 ventas" color="primary">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">&nbsp;</th>
                                        <th><small>CLIENTE</small></th>
                                        <th style="width: 5%"><small>FOLIO</small></th>
                                        <th style="width: 15%; text-align: right;"><small>MONTO</small></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($topSales as $sale)
                                    <tr>
                                        <td>#{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('coffee.client.show', [$sale->client, 'ventas']) }}" target="_blank">
                                                {{ $sale->quotation->client_name ?? $sale->client->name }}
                                            </a>
                                        </td>
                                        <td>{{ $sale->folio }}</td>
                                        <td style="text-align: right;">{{ number_format($sale->amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </solid-box>                    
                </div>

                <div class="col-md-6">
                    <solid-box title="Top 5 productos vendidos" color="success">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">&nbsp;</th>
                                        <th><small>DESCRIPCIÓN</small></th>
                                        <th style="width: 15%; text-align: center;"><small>CANTIDAD</small></th>
                                        <th style="width: 15%; text-align: right;"><small>MONTO</small></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($topProducts as $product => $values)
                                    <tr>
                                        <td>#{{ $loop->iteration }}</td>
                                        <td>{{ $product }}</td>
                                        <td style="text-align: center;">{{ $values['quantity'] }}</td>
                                        <td style="text-align: right;">{{ number_format($values['amount'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </solid-box>                    
                </div>
            </div>

        </div>

    </div>

    

@endsection

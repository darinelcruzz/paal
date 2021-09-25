@extends('coffee.root')

@push('pageTitle', 'Análisis | Envíos')

@section('content')

    <div class="row">
        <div class="col-md-5">
            <solid-box title="ESTADOS" color="danger">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><small>ESTADO</small></th>
                            <th style="text-align: center; width: 5%;"><small><i class="fa fa-eye"></i></small></th>
                            <th style="text-align: center; width: 15%;"><small>ENVÍOS</small></th>
                            <th style="text-align: right; width: 25%;"><small>MONTO</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($shippingsByState as $state => $shippings)
                        <tr>
                            <td>{{ $state == '' ? 'NO AÑADIDO': $state }}</td>
                            <td style="text-align: center;">
                                <a href="#" style="text-decoration: none;">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">{{ $shippings->count() }}</td>
                            <td style="text-align: right;">{{ number_format($shippings->sum(function ($shipping) { return $shipping->ingress->amount; }), 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="2"></th>
                            <th style="text-align: center;">{{ $shippingsByState->sum(function ($shippings) { return $shippings->count();}) }}</th>
                            <th style="text-align: right;">{{ number_format($shippingsByState->sum(function ($shippings) { return $shippings->sum(function ($shipping) {return $shipping->ingress->amount;}); }), 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </solid-box>
        </div>

        <div class="col-md-5">
            <solid-box title="ESTADOS" color="danger">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><small>ESTADO</small></th>
                            <th style="text-align: center; width: 5%;"><small><i class="fa fa-eye"></i></small></th>
                            <th style="text-align: center; width: 15%;"><small>ENVÍOS</small></th>
                            <th style="text-align: right; width: 25%;"><small>MONTO</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach(['Chiapas', 'Tabasco', 'Oaxaca', 'Veracruz', 'Puebla'] as $item)
                        <tr>
                            <td>{{ $item }}</td>
                            <td style="text-align: center;">
                                <a href="#" style="text-decoration: none;">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">{{ random_int(10, 50) }}</td>
                            <td style="text-align: right;">{{ number_format(random_int(1000, 30000) * 0.987, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="2"></th>
                            <th style="text-align: center;">{{ 100 }}</th>
                            <th style="text-align: right;">{{ number_format(0, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </solid-box>
        </div>

        <div class="col-md-2">
            <div class="btn-group-vertical">
                <button class="btn btn-success">
                <a href="{{ route('coffee.statistics.sales', 'TOTAL') }}" style="color: inherit;">
                    TOTAL<br>
                    {{ $shippings->count() }} - {{ number_format($shippings->sum(function ($shipping) { return $shipping->ingress->amount;}), 2) }}
                </a>
                </button>
                @foreach($shippingsByCompany as $label => $values)
                <button class="btn btn-{{ ['danger', 'warning', 'primary', 'info', 'default'][$loop->index] }}">
                <a href="{{ route('coffee.statistics.sales', strtolower($label)) }}" style="color: inherit;">
                    {{ strtoupper($label) }}<br>
                    {{ $values['quantity'] }} - {{ number_format($values['amount'], 2) }}
                </a>
                </button>
                @endforeach
            </div>
        </div>
    </div>

@endsection

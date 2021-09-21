@extends('coffee.root')

@push('pageTitle', 'Análisis | Ventas')

@section('content')

    <div class="row">
        

        <div class="col-md-5">
            <solid-box 
                title="{{ $category == 'TOTAL' ? 'TOTAL MENSUAL': $category }}" 
                color="{{ ['TOTAL' => 'success', 'INSUMOS' => 'danger', 'ACCESORIOS' => 'warning', 'VASOS' => 'info', 'EQUIPO' => 'primary', 'REFACCIONES' => 'default', 'BARRAS' => 'default', 'CURSOS' => 'default', 'OTROS' => 'default'][$category] }}">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><small>{{ $category == 'TOTAL' ? 'CATEGORÍAS': 'FAMILIAS'}}</small></th>
                            <th style="text-align: center; width: 15%;"><small>CANTIDAD</small></th>
                            <th style="text-align: right; width: 25%;"><small>MONTO</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($groups as $group => $values)
                        <tr>
                            <td>{{ $group }}</td>
                            <td style="text-align: center;">{{ $values['quantity'] }}</td>
                            <td style="text-align: right;">{{ number_format($values['amount'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th style="text-align: center;">{{ $groups->sum('quantity') }}</th>
                            <th style="text-align: right;">{{ number_format($groups->sum('amount'), 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </solid-box>
        </div>

        <div class="col-md-5">
            <solid-box title="TOP 5" color="success">
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
            </solid-box>
        </div>

        <div class="col-md-2">
            <div class="btn-group-vertical">
                @foreach(['TOTAL' => 'success', 'INSUMOS' => 'danger', 'ACCESORIOS' => 'warning', 'VASOS' => 'info', 'EQUIPO' => 'primary', 'REFACCIONES' => 'github', 'BARRAS' => 'vk', 'CURSOS' => 'foursquare', 'OTROS' => 'tumblr'] as $label => $color)
                <button class="btn btn-{{ $color }}">
                <a href="{{ route('coffee.statistics.sales', strtolower($label)) }}" style="color: white;">
                    {{ $label == 'EQUIPO' ? 'EQUIPOS': $label }}<br>
                    <product-quantity-and-amount category="{{ $label }}" date="{{ $date }}"></product-quantity-and-amount>
                </a>
                </button>
                @endforeach
            </div>
        </div>
    </div>

@endsection

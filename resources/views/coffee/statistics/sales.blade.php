@extends('coffee.root')

@push('pageTitle', 'Análisis | Ventas')

@push('headerTitle')
    {!! Form::open(['method' => 'post', 'route' => 'coffee.statistics.sales']) !!}
        <div class="row">
            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <input type="month" name="date" class="form-control" value="{{ $date }}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
        </div>

    {!! Form::close() !!}
@endpush

@section('content')

    <div class="row">
        <div class="col-md-5">
            <solid-box 
                title="{{ $category == 'TOTAL' ? 'TOTAL MENSUAL': $category }}" 
                color="{{ ['TOTAL' => 'success', 'INSUMOS' => 'danger', 'ACCESORIOS' => 'warning', 'VASOS' => 'info', 'EQUIPO' => 'primary', 'REFACCIONES' => 'danger', 'BARRAS' => 'warning', 'CURSOS' => 'primary', 'OTROS' => 'default'][$category] }}">
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
            <solid-box title="TOP 5" color="{{ ['TOTAL' => 'success', 'INSUMOS' => 'danger', 'ACCESORIOS' => 'warning', 'VASOS' => 'info', 'EQUIPO' => 'primary', 'REFACCIONES' => 'danger', 'BARRAS' => 'warning', 'CURSOS' => 'primary', 'OTROS' => 'default'][$category] }}">
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
                @foreach(['TOTAL' => 'success', 'INSUMOS' => 'danger', 'ACCESORIOS' => 'warning', 'VASOS' => 'info', 'EQUIPO' => 'primary', 'REFACCIONES' => 'danger', 'BARRAS' => 'warning', 'CURSOS' => 'primary', 'OTROS' => 'info'] as $label => $color)
                {{-- <a href="{{ route('coffee.statistics.sales', strtolower($label)) }}" style="color: white;"> --}}
                <a type="button" href="{{ route('coffee.statistics.sales', strtolower($label)) }}" class="btn btn-{{ $color }}">
                    {{ $label == 'EQUIPO' ? 'EQUIPOS': $label }}<br>
                    <product-quantity-and-amount category="{{ $label }}" date="{{ $date }}"></product-quantity-and-amount>
                </a>
                {{-- </a> --}}
                @endforeach
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-md-10">
            <solid-box title="GRÁFICA" color="{{ ['TOTAL' => 'success', 'INSUMOS' => 'danger', 'ACCESORIOS' => 'warning', 'VASOS' => 'info', 'EQUIPO' => 'primary', 'REFACCIONES' => 'danger', 'BARRAS' => 'warning', 'CURSOS' => 'primary', 'OTROS' => 'default'][$category] }}">
                <div id="chart" style="height: 300px;"></div>
            </solid-box>
        </div>
    </div> --}}

@endsection

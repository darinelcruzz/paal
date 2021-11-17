@extends('coffee.root')

@push('pageTitle', 'Análisis | Envíos')

@push('headerTitle')
    {!! Form::open(['method' => 'post', 'route' => ['coffee.statistics.shippings', $company]]) !!}
        <div class="row">
            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <input type="month" name="date" class="form-control" value="{{ $date }}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-{{ $color }} btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endpush

@section('content')

    <div class="row">
        <div class="col-md-10">

            <div class="row">
                <div class="col-md-6">
                    <solid-box title="{{ ucwords($company ?? 'TODOS') }}" color="{{ $color }}">
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
                                @foreach($shippingsByState as $state => $collection)
                                <tr>
                                    <td>{{ $state == '' ? 'NO AÑADIDO': $state }}</td>
                                    <td>
                                        <a data-toggle="modal" data-target="#cities{{ $loop->index }}">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <modal title="{{ $state }}" color="{{ $color }}" id="cities{{ $loop->index }}">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 70%;"><small>CIUDAD</small></th>
                                                            <th style="text-align: center;width: 10%;"><small>ENVÍOS</small></th>
                                                            <th style="text-align: right;width: 20%;"><small>MONTO</small></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($collection->groupBy(function ($shipping) {return strtoupper($shipping->address->city);}) as $city => $values)
                                                        {{-- @dd($city, $values) --}}
                                                        <tr>
                                                            <td style="width: 70%;">
                                                                <small>{{ $city }}</small>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                {{ $values->count() }}
                                                            </td>
                                                            <td style="text-align: right;">{{ number_format($values->sum(function ($shipping)
                                                            {
                                                                return $shipping->ingress->amount;
                                                            }), 2) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </modal>
                                    </td>
                                    <td style="text-align: center;">{{ $collection->count() }}</td>
                                    <td style="text-align: right;">{{ number_format($collection->sum(function ($shipping) { return $shipping->ingress->amount; }), 2) }}</td>
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
                <div class="col-md-6">
                    <solid-box title="TOP 5 LUGARES" color="{{ $color }}">
                        <table class="table table-striped table-bordered table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 5%;"><small>#</small></th>
                                    <th><small>CIUDAD</small></th>
                                    <th style="text-align: center; width: 15%;"><small>ENVÍOS</small></th>
                                    <th style="text-align: right; width: 25%;"><small>MONTO</small></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($topPlaces as $city => $collection)
                                <tr>
                                    <td>#{{ $loop->iteration }}</td>
                                    <td>{{ $city == '' ? 'NO AÑADIDO': $city }}</td>
                                    <td style="text-align: center;">{{ $collection->count() }}</td>
                                    <td style="text-align: right;">{{ number_format($collection->sum(function ($shipping) { return $shipping->ingress->amount; }), 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align: center;">{{ $topPlaces->sum(function ($shippings) { return $shippings->count();}) }}</th>
                                    <th style="text-align: right;">{{ number_format($topPlaces->sum(function ($shippings) { return $shippings->sum(function ($shipping) {return $shipping->ingress->amount;}); }), 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </solid-box>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <solid-box title="{{ strtoupper($company ?? 'TODOS') }}" color="{{ $color }}">
                        <div id="chart" style="height: 500px;"></div>
                    </solid-box>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="btn-group-vertical">
                <button class="btn btn-success">
                <a href="{{ route('coffee.statistics.shippings', [null, $date]) }}" style="color: inherit;">
                    TOTAL<br>
                    {{ $total->count() }} - {{ number_format($total->sum(function ($shipping) { return $shipping->ingress->amount;}), 2) }}
                </a>
                </button>
                @foreach($shippingsByCompany as $label => $values)
                <button class="btn btn-{{ ['danger', 'warning', 'primary', 'info', 'default'][$loop->index] }}">
                <a href="{{ route('coffee.statistics.shippings', [strtolower($label), $date]) }}" style="color: inherit;">
                    {{ strtoupper($label) }}<br>
                    {{ $values['quantity'] }} - {{ number_format($values['amount'], 2) }}
                </a>
                </button>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@section('chartisan')

<script>
  const chart = new Chartisan({
    el: '#chart',
    url: "@chart('shippings')" + "?company={{ $company ?? 'todos' }}",
    hooks: new ChartisanHooks()
        .colors(['#dd4b39', '#00c0ef', '#f39c12', '#3c8dbc', '#b5bbc8', '#00a65a', '#001F3F', '#39CCCC', '#605ca8', '#ff851b', '#D81B60', '#444444'])
        .legend({ position: 'bottom' })
        .datasets('bar'),
  });
</script>

@endsection

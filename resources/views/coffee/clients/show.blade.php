@extends('coffee.root')

@push('pageTitle', 'Clientes | Detalle')

@push('headerTitle')
    <div class="row">
        <div class="col-md-6">
            {{  $name }}
            <span class="pull-right">
                <a href="{{ route('coffee.client.show', [$client, $spanish == 'ventas' ? 'cotizaciones': 'ventas']) }}" class="btn btn-xs btn-{{ $spanish != 'ventas' ? 'danger': 'warning' }}">
                    <i class="fa fa-random"></i>&nbsp;&nbsp;{{ $spanish == 'ventas' ? 'COTIZACIONES': 'VENTAS' }}
                </a>
            </span>
        </div>
        <div class="col-md-6">
            {!! Form::open(['method' => 'post', 'route' => ['coffee.client.show', $client, $spanish]]) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <input type="date" name="start" class="form-control" value="{{ request('start') ?? date('Y-m-d', time() - 60*60*24*31) }}">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-{{ $spanish == 'cotizaciones' ? 'warning': 'danger' }} btn-flat"><i class="fa fa-angle-double-right"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <input type="date" name="end" class="form-control" value="{{ request('end') ?? date('Y-m-d') }}">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-{{ $spanish == 'cotizaciones' ? 'warning': 'danger' }} btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-9">
            <solid-box title="{{ strtoupper($spanish) }}" color="{{ $spanish == 'cotizaciones' ? 'warning': 'danger' }}">

                <table class="table table-striped table-bordered spanish">
                    <thead>
                        <tr>
                            <th style="width: 5%"><small>ID</small></th>
                            <th style="width: 5%"><small><i class="fa fa-cogs"></i></small></th>
                            <th style="width: 12%"><small>FECHA</small></th>
                            <th style="width: 10%"><small>TIPO</small></th>
                            <th style="text-align: right; width: 10%;"><small>IVA</small></th>
                            <th style="text-align: right; width: 18%;"><small>IMPORTE</small></th>
                            @if($spanish == 'cotizaciones')
                            <th style="text-align: right; width: 10%;"><small>VENTA</small></th>
                            <th style="text-align: right; width: 10%;"><small>EDICIONES</small></th>
                            @else
                            <th style="text-align: right; width: 10%;"><small>REFERENCIA</small></th>
                            <th style="text-align: right; width: 10%;"><small>MÉTODO</small></th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @php
                        $salesCount = 0;
                        $salesTotal = 0;
                        $itemsCount = $collection->count();
                        $itemsTotal = $collection->sum('amount');
                        @endphp
                        @foreach($collection as $item)
                        @php
                        $salesCount += $item->sale ? 1: 0;
                        $salesTotal += $item->sale ? $item->amount: 0;
                        @endphp
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <dropdown icon="cogs" color="{{ $spanish == 'cotizaciones' ? 'warning': 'danger' }}">
                                    <li>
                                        <a data-toggle="modal" data-target="#{{ strtolower(substr($model, 4)) }}-modal" v-on:click="upmodel({{ $item->toJson() }})">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Detalles
                                        </a>
                                    </li>
                                    @if($spanish == 'cotizaciones')
                                        <ddi to="{{ route('coffee.' . strtolower(substr($model, 4)) . '.download', $item) }}" icon="file-pdf" text="Imprimir" target="_blank"></ddi>
                                    @endif
                                    @if (!$item->sale)
                                        @if($spanish == 'cotizaciones')
                                            <ddi to="{{ route('coffee.' . strtolower(substr($model, 4)) . '.edit', $item) }}" icon="edit" text="Editar"></ddi>
                                        @endif
                                        <ddi to="{{ route('coffee.retainer.create', $item) }}" icon="hand-holding-usd" text="Anticipo"></ddi>
                                        @if($item->type && $spanish == 'cotizaciones')
                                            <ddi to="{{ route('coffee.' . strtolower(substr($model, 4)) . '.transform', [$item, $item->type]) }}" icon="mug-hot" text="Crear venta"></ddi>
                                        @elseif($spanish == 'cotizaciones')
                                            <ddi to="{{ route('coffee.' . strtolower(substr($model, 4)) . '.transform', $item) }}" icon="mug-hot" text="Crear venta"></ddi>
                                        @endif
                                    @endif
                                </dropdown>
                            </td>
                            <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                            <td style="text-align: center;">
                                <label class="label label-{{ ['proyecto' => 'primary', 'no equipo' => 'danger', 'equipo' => 'warning'][$item->type ?? 'no equipo'] }}">
                                    {{ strtoupper($item->type) }}
                                </label>
                            </td>
                            <td style="text-align: right;">{{ number_format($item->iva, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($item->amount, 2) }}</td>
                            @if($spanish == 'cotizaciones')
                            <td style="text-align: center">
                                <label class="label label-{{ $item->sale ? 'success': 'default' }}">
                                    {!! strtoupper($item->sale->folio ?? '<small>SIN VENTA</small>') !!}
                                </label>
                            </td>
                            <td style="text-align: center">
                                @if ($item->editions_count)
                                    <code style="color: blue">{{ $item->editions_count }}</code>
                                @else
                                    <code>0</code>
                                @endif
                            </td>
                            @else
                            <td style="text-align: center;">{{ $item->reference }}</td>
                            <td style="text-align: center;"><small>{{ strtoupper($item->method) }}</small></th>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </solid-box>

            <modal title="Productos" color="{{ $spanish == 'cotizaciones' ? 'warning': 'danger' }}" id="{{ strtolower(substr($model, 4)) }}-modal">
                <movements :model="model"></movements>
            </modal>
        </div>

        <div class="col-md-3">
            @if($spanish == 'cotizaciones')
            <div class="small-box bg-red">
                <div class="inner">
                    <p>{{ $itemsCount }} EN TOTAL</p>
                    <h3><em><small style="color: inherit;">{{ number_format($itemsTotal, 2) }}</small></em></h3>
                </div>
                <div class="icon">
                    <i class="fa fa-file-pdf"></i>
                </div>
            </div>
            <div class="small-box bg-green">
                <div class="inner">
                    <p>{{ $salesCount }} VENTAS ({{ number_format($salesCount * 100 / ($itemsCount > 0 ? $itemsCount: 1)) }} %)</p>
                    <h3><em><small style="color: inherit;">{{ number_format($salesTotal, 2) }}</small></em></h3>
                </div>
                <div class="icon">
                    <i class="fa fa-mug-hot"></i>
                </div>
            </div>
            <div class="small-box bg-gray">
                <div class="inner">
                    <p>{{ $itemsCount - $salesCount }} SIN VENTA ({{ number_format(100 - ($salesCount * 100 / ($itemsCount > 0 ? $itemsCount: 1))) }} %)</p>
                    <h3><em><small style="color: inherit;">{{ number_format($itemsTotal - $salesTotal, 2) }}</small></em></h3>
                </div>
                <div class="icon">
                    <i class="fa fa-chart-pie"></i>
                </div>
            </div>
            @else
            <div class="small-box bg-green">
                <div class="inner">
                    <p>{{ $itemsCount }} EN TOTAL</p>
                    <h3><em><small style="color: inherit;">{{ number_format($itemsTotal, 2) }}</small></em></h3>
                </div>
                <div class="icon">
                    <i class="fa fa-mug-hot"></i>
                </div>
            </div>
            @endif
        </div>
    </div>

@endsection
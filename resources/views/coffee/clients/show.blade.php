@extends('coffee.root')

@push('pageTitle', 'Clientes | Detalle')

@push('headerTitle')
    <div class="row">
        <div class="col-md-6">
            {{ $client->name }}
        </div>
        <div class="col-md-6">
            {!! Form::open(['method' => 'post', 'route' => ['coffee.client.show', $client]]) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <input type="date" name="start" class="form-control" value="{{ request('start') ?? date('Y-m-d', time() - 60*60*24*31) }}">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-danger btn-flat"><i class="fa fa-angle-double-right"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <input type="date" name="end" class="form-control" value="{{ request('end') ?? date('Y-m-d') }}">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
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
            <solid-box title="COTIZACIONES" color="warning">

                <table class="table table-striped table-bordered spanish">
                    <thead>
                        <tr>
                            <th style="width: 5%"><small>ID</small></th>
                            <th style="width: 5%"><small><i class="fa fa-cogs"></i></small></th>
                            <th style="width: 12%"><small>FECHA</small></th>
                            <th style="width: 10%"><small>TIPO</small></th>
                            <th style="text-align: right; width: 10%;"><small>IVA</small></th>
                            <th style="text-align: right; width: 18%;"><small>IMPORTE</small></th>
                            <th style="text-align: right; width: 10%;"><small>VENTA</small></th>
                            <th style="text-align: right; width: 10%;"><small>EDICIONES</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                        $salesCount = 0;
                        $salesTotal = 0;
                        $quotationsCount = $quotations->count();
                        $quotationsTotal = $quotations->sum('amount');
                        @endphp
                        @foreach($quotations as $quotation)
                        @php
                        $salesCount += $quotation->sale ? 1: 0;
                        $salesTotal += $quotation->sale ? $quotation->amount: 0;
                        @endphp
                        <tr>
                            <td>{{ $quotation->id }}</td>
                            <td>
                                <dropdown icon="cogs" color="warning">
                                    <li>
                                        <a data-toggle="modal" data-target="#quotation-modal" v-on:click="upmodel({{ $quotation->toJson() }})">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Detalles
                                        </a>
                                    </li>
                                    <ddi to="{{ route('coffee.quotation.download', $quotation) }}" icon="file-pdf" text="Imprimir" target="_blank"></ddi>
                                    @if (!$quotation->sale)
                                        <ddi to="{{ route('coffee.quotation.edit', $quotation) }}" icon="edit" text="Editar"></ddi>
                                        <ddi to="{{ route('coffee.retainer.create', $quotation) }}" icon="hand-holding-usd" text="Anticipo"></ddi>
                                        @if($quotation->type)
                                            <ddi to="{{ route('coffee.quotation.transform', [$quotation, $quotation->type]) }}" icon="mug-hot" text="Crear venta"></ddi>
                                        @else
                                            <ddi to="{{ route('coffee.quotation.transform', $quotation) }}" icon="mug-hot" text="Crear venta"></ddi>
                                        @endif
                                    @endif
                                </dropdown>
                            </td>
                            <td>{{ date('d/m/Y', strtotime($quotation->created_at)) }}</td>
                            <td style="text-align: center;">
                                <label class="label label-{{ ['proyecto' => 'primary', 'insumos' => 'danger', 'equipo' => 'warning'][$quotation->type ?? 'insumos'] }}">
                                    {{ strtoupper($quotation->type) }}
                                </label>
                            </td>
                            <td style="text-align: right;">{{ number_format($quotation->iva, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($quotation->amount, 2) }}</td>
                            <td style="text-align: center">
                                <label class="label label-{{ $quotation->sale ? 'success': 'default' }}">
                                    {!! strtoupper($quotation->sale->folio ?? '<small>SIN VENTA</small>') !!}
                                </label>
                            </td>
                            <td style="text-align: center">
                                @if ($quotation->editions_count)
                                    <code style="color: blue">{{ $quotation->editions_count }}</code>
                                @else
                                    <code>0</code>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </solid-box>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-red">
                <div class="inner">
                    <p>{{ $quotationsCount }} EN TOTAL</p>
                    <h3><em><small style="color: inherit;">{{ number_format($quotationsTotal, 2) }}</small></em></h3>
                </div>
                <div class="icon">
                    <i class="fa fa-file-pdf"></i>
                </div>
            </div>
            <div class="small-box bg-green">
                <div class="inner">
                    <p>{{ $salesCount }} VENTAS ({{ number_format($salesCount * 100 / ($quotationsCount > 0 ? $quotationsCount: 1)) }} %)</p>
                    <h3><em><small style="color: inherit;">{{ number_format($salesTotal, 2) }}</small></em></h3>
                </div>
                <div class="icon">
                    <i class="fa fa-mug-hot"></i>
                </div>
            </div>
            <div class="small-box bg-gray">
                <div class="inner">
                    <p>{{ $quotationsCount - $salesCount }} SIN VENTA ({{ number_format(100 - ($salesCount * 100 / ($quotationsCount > 0 ? $quotationsCount: 1))) }} %)</p>
                    <h3><em><small style="color: inherit;">{{ number_format($quotationsTotal - $salesTotal, 2) }}</small></em></h3>
                </div>
                <div class="icon">
                    <i class="fa fa-chart-pie"></i>
                </div>
            </div>
        </div>
    </div>

@endsection
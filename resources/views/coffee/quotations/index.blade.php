@extends('coffee.root')

@push('pageTitle', 'Cotizaciones')

@section('content')

    <div class="row">
        <div class="col-md-3">

            {!! Form::open(['method' => 'post', 'route' => ['coffee.quotation.index', $type]]) !!}
                
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
            
        </div>

        <div class="col-md-3">
            <label class="btn btn-{{ $color }} btn-bg btn-block">
               TOTAL: {{ $total }}
            </label>
        </div>

        <div class="col-md-3">
            <label class="btn btn-success btn-bg btn-block">
               VENTAS: {{ $sales }} | {{ round($sales * 100 / ($total ? $total : 1)) }} %
            </label>
        </div>

        <div class="col-md-3">
            <label class="btn btn-default btn-bg btn-block">
                SIN VENTAS: {{ $total - $sales }} | {{ round(($total - $sales) * 100 / ($total ? $total : 1)) }} %
            </label>
        </div>
    </div>

    <br>

    <div class="row">

        <div class="col-md-12">

            <solid-box title="{{ ucfirst($type ?? 'Cotizaciones') }}" color="{{ $color }}" button>

                <data-table example="1">

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>','fecha', 'cliente', 'tipo', 'IVA', 'total', 'ventas', 'ediciones') }}

                    <template slot="body">
                        @foreach($quotations as $quotation)
                            <tr>
                                <td>{{ $quotation->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="{{ $color }}">
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
                                <td>{{ fdate($quotation->created_at, 'd/m/Y') }}</td>
                                <td style="width: 40%">
                                    <a href="#" target="_blank">
                                        {{ $quotation->client_name ?? $quotation->client->name }}
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    @if ($quotation->type)
                                        <label class="label label-{{ $quotation->typeLabel }}">{{ strtoupper($quotation->type) }}</label>
                                    @else
                                        <label class="label label-{{$quotation->products_list_type == 'insumos' ? 'danger': 'warning'}}">{{ strtoupper($quotation->products_list_type) }}</label>
                                    @endif
                                </td>
                                <td style="text-align: right">{{ number_format($quotation->iva, 2) }}</td>
                                <td style="text-align: right">
                                    {{ number_format($quotation->amount, 2) }}
                                    @if($quotation->retainers->count() > 0)
                                        <br>
                                        <small style="color: gray"><em>p.p.</em> {{ number_format($quotation->amount - $quotation->retainers->sum('amount'), 2) }}</small>
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    <span class="label label-{{ $quotation->sale ? 'success': 'default' }}">
                                        <small>{{ $quotation->sale ? 'VENTA': 'SIN VENTA' }}</small>
                                    </span>
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
                    </template>

                </data-table>

            </solid-box>

            <modal title="Productos" color="{{ $color }}" id="quotation-modal">
                <movements :model="model"></movements>
            </modal>
        </div>
    </div>

    @include('sweet::alert')

@endsection

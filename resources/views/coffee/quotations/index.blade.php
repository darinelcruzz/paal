@extends('coffee.root')

@push('pageTitle', 'Cotizaciones')

@section('content')

    <div class="row">
        <div class="col-md-3">

            {!! Form::open(['method' => 'post', 'route' => ['coffee.quotation.index', $status, $type]]) !!}
                
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

        @if($status == 'terminada')
        <div class="col-md-3">
            <label class="btn btn-{{ $color }} btn-bg btn-block">
               TOTAL: {{ $total }}
            </label>
        </div>

        <div class="col-md-3">
            <label class="btn btn-success btn-bg btn-block">
               VENTAS: {{ $sales }} | {{ round($sales * 100 / ($total > 0 ? $total : 1)) }} %
            </label>
        </div>

        <div class="col-md-3">
            <label class="btn btn-default btn-bg btn-block">
                SIN VENTAS: {{ $total - $sales }} | {{ round(($total - $sales) * 100 / ($total > 0 ? $total : 1)) }} %
            </label>
        </div>
        @endif
    </div>

    <br>

    <div class="row">

        <div class="col-md-12">

            @if(count($vias) > 0)
            <div class="btn-group">
              
              <button type="button" class="btn btn-sm btn-google btn-social">
                <i class="fab fa-google"></i>{{ count($vias['google'] ?? []) }}
              </button>
              
              <button type="button" class="btn btn-sm btn-facebook btn-social">
                <i class="fab fa-facebook"></i>{{ count($vias['facebook'] ?? []) }}
              </button>
              
              <button type="button" class="btn btn-sm btn-vk btn-social">
                <i class="fa fa-wifi"></i> {{ count($vias['página web'] ?? []) }}
              </button>
              
              <button type="button" class="btn btn-sm btn-foursquare btn-social">
                <i class="fa fa-comments"></i> {{ count($vias['recomendación'] ?? []) }}
              </button>
              
              <button type="button" class="btn btn-sm btn-github btn-social">
                <i class="fa fa-question"></i> {{ count($vias['otro'] ?? []) }}
              </button>

            </div>
            <br><br>
            @endif

            <solid-box title="{{ ucfirst($type ? $type: ( $status == 'terminada' ? 'Cotizaciones': 'Precotizaciones')) }}" color="{{ $color }}">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered spanish">
                        <thead>
                            <tr>
                                <th><small>ID</small></th>
                                <th><small><i class="fa fa-cogs"></i></small></th>
                                <th><small>FECHA</small></th>
                                <th><small>CLIENTE</small></th>
                                <th><small>TIPO</small></th>
                                <th v-if="'campañas' == '{{ $type }}'"><small>VIA</small></th>
                                <th><small>IVA</small></th>
                                <th><small>TOTAL</small></th>
                                <th><small>VENTA</small></th>
                                @if($status == 'terminada')<th><small>EDICIONES</small></th>@endif
                            </tr>
                        </thead>

                        <tbody>
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
                                                @if($status == 'terminada')
                                                    <ddi to="{{ route('coffee.retainer.create', $quotation) }}" icon="hand-holding-usd" text="Anticipo"></ddi>
                                                    @if($quotation->type)
                                                        <ddi to="{{ route('coffee.quotation.transform', [$quotation, $quotation->type]) }}" icon="mug-hot" text="Crear venta"></ddi>
                                                    @else
                                                        <ddi to="{{ route('coffee.quotation.transform', $quotation) }}" icon="mug-hot" text="Crear venta"></ddi>
                                                    @endif
                                                @else
                                                    <ddi to="{{ route('coffee.quotation.move', $quotation) }}" icon="share" text="Hacer cotización"></ddi>
                                                @endif
                                            @endif
                                        </dropdown>
                                    </td>
                                    <td>{{ fdate($quotation->created_at, 'd/m/Y') }}</td>
                                    <td style="width: 40%">
                                        <a href="{{ route('coffee.client.show', [$quotation->client, 'cotizaciones']) }}" target="_blank">
                                            {{ $quotation->client_name ?? $quotation->client->name }}
                                        </a>
                                    </td>
                                    <td style="text-align: center">
                                        @if ($quotation->type)
                                            <label class="label label-{{ $quotation->typeLabel }}"><small>{{ strtoupper($quotation->type) }}</small></label>
                                        @else
                                            <label class="label label-{{$quotation->products_list_type == 'insumos' ? 'danger': 'warning'}}"><small>{{ strtoupper($quotation->products_list_type) }}</small></label>
                                        @endif
                                    </td>
                                    <td style="text-align: center" v-if="'campañas' == '{{ $type }}'">
                                        <label class="label btn-{{ $quotation->via_label }}"><small>{{ strtoupper($quotation->via ?? 'S/E') }}</small></label>
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
                                    @if($status == 'terminada')
                                    <td style="text-align: center">
                                        @if ($quotation->editions_count)
                                            <code style="color: blue">{{ $quotation->editions_count }}</code>
                                        @else
                                            <code>0</code>
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                    </tbody>
                    </table>
                </div>
            </solid-box>

            <modal title="Productos" color="{{ $color }}" id="quotation-modal">
                <movements :model="model" type="quotation"></movements>
            </modal>
        </div>
    </div>

@endsection

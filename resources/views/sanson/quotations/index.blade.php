@extends('sanson.root')

@push('pageTitle', 'Cotizaciones')

@section('content')

    <div class="row">
        <div class="col-md-3">

            {!! Form::open(['method' => 'post', 'route' => ['sanson.quotation.index', $type]]) !!}
                
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
               VENTAS: {{ $sales }} | {{ round($sales * 100 / ($total == 0 ? 1: $total)) }} %
            </label>
        </div>

        <div class="col-md-3">
            <label class="btn btn-default btn-bg btn-block">
                SIN VENTAS: {{ $total- $sales }} | {{ round(($total- $sales) * 100 / ($total == 0 ? 1: $total)) }} %
            </label>
        </div>
    </div>

    <br>

    <div class="row">

        <div class="col-md-12">

            <solid-box title="{{ ucfirst($type ?? 'Cotizaciones') }}" color="{{ $color }}">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered spanish">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><i class="fa fa-cogs"></i></th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>IVA</th>
                                <th>Total</th>
                                <th>Ventas</th>
                                <th>Ediciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($quotations as $quotation)
                                <tr>
                                    <td>{{ $quotation->id }}</td>
                                    <td>
                                        <dropdown icon="cogs" color="{{ $color }}">
                                            {{-- <ddi to="{{ route('sanson.quotation.show', $quotation) }}" icon="eye" text="Detalles"></ddi> --}}
                                            <li>
                                                <a data-toggle="modal" data-target="#quotation-modal" v-on:click="upmodel({{ $quotation->toJson() }})">
                                                    <i class="fa fa-eye" aria-hidden="true"></i> Detalles
                                                </a>
                                            </li>
                                            <ddi to="{{ route('sanson.quotation.download', $quotation) }}" icon="file-pdf" text="Imprimir" target="_blank"></ddi>
                                            @if (!$quotation->is_canceled)
                                                <ddi to="{{ route('sanson.quotation.edit', $quotation) }}" icon="edit" text="Editar"></ddi>
                                                @if($quotation->type)
                                                    <ddi to="{{ route('sanson.quotation.transform', [$quotation, $quotation->type]) }}" icon="mug-hot" text="Crear venta"></ddi>
                                                @else
                                                    <ddi to="{{ route('sanson.quotation.transform', $quotation) }}" icon="mug-hot" text="Crear venta"></ddi>
                                                @endif
                                            @endif
                                        </dropdown>
                                    </td>
                                    <td>{{ fdate($quotation->created_at, 'd/m/Y') }}</td>
                                    <td style="width: 40%">{{ $quotation->client_name ?? $quotation->client->name }}</td>
                                    <td>
                                        <label class="label label-{{$quotation->type == 'proyecto' ? 'primary': 'info'}}">{{ strtoupper($quotation->type) }}</label>
                                    </td>
                                    <td>{{ number_format($quotation->iva, 2) }}</td>
                                    <td>{{ number_format($quotation->amount, 2) }}</td>
                                    <td style="text-align: center">
                                        <span class="label label-{{ $quotation->sale ? 'success': 'default' }}">
                                            <small>{{ $quotation->sale ? 'VENTA': 'SIN VENTA' }}</small>
                                        </span>
                                    </td>
                                    <td>
                                        @if ($quotation->editions_count)
                                            <code style="color: blue">EDICIONES: {{ $quotation->editions_count }}</code>
                                        @else
                                            <code>0</code>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </solid-box>

            <modal title="Productos" color="{{ $color }}" id="quotation-modal">
                <movements :model="model"></movements>
            </modal>
        </div>
    </div>

    @include('sweet::alert')

@endsection

@extends('coffee.root')

@push('pageTitle', 'Cotizaciones | Internet')

@section('content')

    <div class="row">
        <div class="col-md-3">

            {!! Form::open(['method' => 'post', 'route' => 'coffee.quotation.internet']) !!}
                
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
            
        </div>

        <div class="col-md-3">
            <label class="btn btn-danger btn-bg btn-block">
               TOTAL: {{ $total }}
            </label>
        </div>

        <div class="col-md-3">
            <label class="btn btn-success btn-bg btn-block">
               VENTAS: {{ $sales }} | {{ round(($sales * 100) / ($total == 0 ? 1: $total)) }} %
            </label>
        </div>

        <div class="col-md-3">
            <label class="btn btn-default btn-bg btn-block">
                SIN VENTAS: {{ ($total - $sales) }} | {{ round((($total - $sales) * 100) / ($total == 0 ? 1: $total)) }} %
            </label>
        </div>
    </div>

    <br>

    <div class="row">

        <div class="col-md-12">

            <solid-box title="INTERNAS ({{ $quotations->where('client_id', 658)->count() }})" color="primary" button>

                <data-table example="1">

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>','fecha', 'cliente', 'tipo', 'IVA', 'total', 'ventas', 'ediciones') }}

                    <template slot="body">
                        @foreach($quotations->where('client_id', 658) as $quotation)
                            <tr>
                                <td>{{ $quotation->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="primary">
                                        <ddi to="{{ route('coffee.quotation.show', $quotation) }}" icon="eye" text="Detalles"></ddi>
                                        <ddi to="{{ route('coffee.quotation.download', $quotation) }}" icon="file-pdf" text="Imprimir" target="_blank"></ddi>
                                        @if (!$quotation->is_canceled)
                                            <ddi to="{{ route('coffee.quotation.edit', $quotation) }}" icon="edit" text="Editar"></ddi>
                                            @if($quotation->type)
                                                <ddi to="{{ route('coffee.quotation.transform', [$quotation, $quotation->type]) }}" icon="mug-hot" text="Crear venta"></ddi>
                                            @else
                                                <ddi to="{{ route('coffee.quotation.transform', $quotation) }}" icon="mug-hot" text="Crear venta"></ddi>
                                            @endif
                                        @endif
                                    </dropdown>
                                </td>
                                <td>{{ fdate($quotation->created_at, 'd/m/Y') }}</td>
                                <td style="width: 40%">{{ $quotation->client_name }}</td>
                                <td>
                                    @if ($quotation->type)
                                        <label class="label label-{{$quotation->type == 'insumos' ? 'danger': 'warning'}}">{{ strtoupper($quotation->type) }}</label>
                                    @else
                                        <label class="label label-{{$quotation->products_list_type == 'insumos' ? 'danger': 'warning'}}">{{ strtoupper($quotation->products_list_type) }}</label>
                                    @endif
                                </td>
                                <td style="text-align: right">{{ number_format($quotation->iva, 2) }}</td>
                                <td style="text-align: right">{{ number_format($quotation->amount, 2) }}</td>
                                <td style="text-align: center">
                                    <span class="label label-{{ count($quotation->sales) > 0 ? 'success': 'default' }}">
                                        <small>{{ count($quotation->sales) > 0 ? 'VENTA': 'SIN VENTA' }}</small>
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

            <solid-box title="EXTERNAS ({{ $quotations->where('client_id', 659)->count() }})" color="info" button collapsed>

                <data-table example="1">

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>','fecha', 'cliente', 'tipo', 'IVA', 'total', 'ventas', 'ediciones') }}

                    <template slot="body">
                        @foreach($quotations->where('client_id', 659) as $quotation)
                            <tr>
                                <td>{{ $quotation->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="info">
                                        <ddi to="{{ route('coffee.quotation.show', $quotation) }}" icon="eye" text="Detalles"></ddi>
                                        <ddi to="{{ route('coffee.quotation.download', $quotation) }}" icon="file-pdf" text="Ver PDF"></ddi>
                                        @if (!$quotation->is_canceled)
                                            <ddi to="{{ route('coffee.quotation.edit', $quotation) }}" icon="edit" text="Editar"></ddi>
                                            @if($quotation->type)
                                                <ddi to="{{ route('coffee.quotation.transform', [$quotation, $quotation->type]) }}" icon="mug-hot" text="Crear venta"></ddi>
                                            @else
                                                <ddi to="{{ route('coffee.quotation.transform', $quotation) }}" icon="mug-hot" text="Crear venta"></ddi>
                                            @endif
                                        @endif
                                    </dropdown>
                                </td>
                                <td>{{ fdate($quotation->created_at, 'd/m/Y') }}</td>
                                <td style="width: 40%">{{ $quotation->client_name }}</td>
                                <td>
                                    @if ($quotation->type)
                                        <label class="label label-{{$quotation->type == 'insumos' ? 'danger': 'warning'}}">{{ strtoupper($quotation->type) }}</label>
                                    @else
                                        <label class="label label-{{$quotation->products_list_type == 'insumos' ? 'danger': 'warning'}}">{{ strtoupper($quotation->products_list_type) }}</label>
                                    @endif
                                </td>
                                <td style="text-align: right">{{ number_format($quotation->iva, 2) }}</td>
                                <td style="text-align: right">{{ number_format($quotation->amount, 2) }}</td>
                                <td style="text-align: center">
                                    <span class="label label-{{ count($quotation->sales) > 0 ? 'success': 'default' }}">
                                        <small>{{ count($quotation->sales) > 0 ? 'VENTA': 'SIN VENTA' }}</small>
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
        </div>
    </div>

    @include('sweet::alert')

@endsection

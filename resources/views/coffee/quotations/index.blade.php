@extends('coffee.root')

@push('pageTitle', 'Cotizaciones')

@section('content')

    <div class="row">
        <div class="col-md-3">

            {!! Form::open(['method' => 'post', 'route' => 'coffee.quotation.index']) !!}
                
                <div class="row">
                    <div class="col-md-3">                        
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}
            
        </div>

        <div class="col-md-3">
            <label class="btn btn-warning btn-bg btn-block">
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

            <solid-box title="Cotizaciones" color="warning">

                <data-table example="1">

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>','fecha', 'cliente', 'tipo', 'IVA', 'total', 'ventas', 'ediciones') }}

                    <template slot="body">
                        @foreach($quotations as $quotation)
                            <tr>
                                <td>{{ $quotation->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="warning">
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
                                <td style="width: 40%">{{ $quotation->client->name }}</td>
                                <td style="text-align: center">
                                    @if ($quotation->type)
                                        <label class="label label-{{ $quotation->type == 'insumos' ? 'danger': 'warning'}}">{{ strtoupper($quotation->type) }}</label>
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

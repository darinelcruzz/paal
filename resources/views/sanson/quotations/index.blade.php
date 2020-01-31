@extends('sanson.root')

@push('pageTitle')
    Cotizaciones
@endpush

@push('headerTitle')
    
@endpush

@section('content')

    <div class="row">
        <div class="col-md-3">

            {!! Form::open(['method' => 'post', 'route' => 'sanson.quotation.index']) !!}
                
                <div class="row">
                    <div class="col-md-3">                        
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}
            
        </div>

        <div class="col-md-3">
            <label class="btn btn-info btn-bg btn-block">
               TOTAL: {{ $all }}
            </label>
        </div>

        <div class="col-md-3">
            <label class="btn btn-success btn-bg btn-block">
               VENTAS: {{ $quotations_with_sales }} | {{ round($quotations_with_sales * 100 / $all) }} %
            </label>
        </div>

        <div class="col-md-3">
            <label class="btn btn-default btn-bg btn-block">
                SIN VENTAS: {{ $quotations_without_sales }} | {{ round($quotations_without_sales * 100 / $all) }} %
            </label>
        </div>
    </div>

    <br>

    <div class="row">

        <div class="col-md-12">

            <solid-box title="Cotizaciones" color="info">

                <data-table example="1">

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>','fecha', 'cliente', 'tipo', 'IVA', 'total', 'ventas', 'ediciones') }}

                    <template slot="body">
                        @foreach($quotations as $quotation)
                            <tr>
                                <td>{{ $quotation->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="info">
                                        <ddi to="{{ route('sanson.quotation.show', $quotation) }}" icon="eye" text="Detalles"></ddi>
                                        <ddi to="{{ route('sanson.quotation.download', $quotation) }}" icon="file-pdf" text="Ver PDF"></ddi>
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
                                <td>{{ fdate($quotation->created_at, 'd M Y') }}</td>
                                <td style="width: 40%">{{ $quotation->client->name }}</td>
                                <td>
                                    @if ($quotation->type)
                                        <label class="label label-{{$quotation->type == 'insumos' ? 'danger': 'info'}}">{{ strtoupper($quotation->type) }}</label>
                                    @else
                                        <label class="label label-{{$quotation->products_list_type == 'insumos' ? 'danger': 'info'}}">{{ strtoupper($quotation->products_list_type) }}</label>
                                    @endif
                                </td>
                                <td>$ {{ number_format($quotation->iva, 2) }}</td>
                                <td>$ {{ number_format($quotation->amount, 2) }}</td>
                                <td>
                                    <span class="label label-{{ count($quotation->sales) > 0 ? 'success': 'default' }}">
                                        {{ count($quotation->sales) > 0 ? 'VENTA': 'SIN VENTA' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($quotation->editions_count)
                                        <code style="color: blue">EDICIONES: {{ $quotation->editions_count }}</code>
                                    @else
                                        <code>SIN EDITAR</code>
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

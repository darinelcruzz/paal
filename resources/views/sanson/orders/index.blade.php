@extends('sanson.root')

@push('pageTitle', 'Órdenes | Lista')

@push('headerTitle')
    <a href="{{ route('sanson.order.create') }}" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-10">
            <solid-box title="Órdenes de compras" color="info">
                
                <data-table>

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>', 'fecha', 'proveedor', 'monto', 'estado') }}

                    <template slot="body">
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    <dropdown color="info" icon="cogs">
                                        <ddi to="{{ route('sanson.order.show', $order) }}" icon="eye" text="Detalles"></ddi>
                                        {{-- <ddi to="{{ route('sanson.order.edit', $order) }}" icon="edit" text="Editar"></ddi> --}}
                                    </dropdown>
                                </td>
                                <td>{{ $order->ordered_at }}</td>
                                <td>{{ $order->provider->name }}</td>
                                <td>{{ number_format($order->amount, 2) }}</td>
                                <td>
                                    <span class="label label-warning">PENDIENTE</span>
                                </td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection

@extends('coffee.root')

@push('pageTitle', 'Órdenes | Lista')

@push('headerTitle')
    <a href="{{ route('coffee.order.create') }}" class="btn btn-danger btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-10">
            <solid-box title="Órdenes de compra" color="danger">
                
                <data-table>

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>', 'fecha', 'proveedor', 'monto', 'estado', 'compras') }}

                    <template slot="body">
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    <dropdown color="danger" icon="cogs">
                                        <ddi to="{{ route('coffee.order.show', $order) }}" icon="eye" text="Detalles"></ddi>
                                        <ddi to="{{ route('coffee.order.transform', $order) }}" icon="edit" text="Crear compra"></ddi>
                                    </dropdown>
                                </td>
                                <td>{{ $order->ordered_at }}</td>
                                <td>{{ $order->provider->name }}</td>
                                <td>{{ number_format($order->amount, 2) }}</td>
                                <td>
                                    <span class="label label-warning">PENDIENTE</span>
                                </td>
                                <td style="text-align: center">
                                    <span class="label label-{{ count($order->purchases) > 0 ? 'success': 'default' }}">
                                        <small>{{ count($order->purchases) > 0 ? 'COMPRA': 'SIN COMPRA' }}</small>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection

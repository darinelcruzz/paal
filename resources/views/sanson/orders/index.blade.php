@extends('sanson.root')

@push('pageTitle', 'Órdenes | Lista')

@push('headerTitle')
    <a href="{{ route('sanson.order.create') }}" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            <solid-box title="Órdenes de compra" color="info">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered spanish">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><i class="fa fa-cogs"></i></th>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Estado</th>
                                <th>Importe</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        <dropdown color="info" icon="cogs">
                                            <ddi to="{{ route('sanson.order.show', $order) }}" icon="eye" text="Detalles"></ddi>
                                            <ddi to="{{ route('sanson.order.print', $order) }}" icon="print" text="Imprimir" target="_blank"></ddi>
                                            <ddi v-if="0 == {{ $order->is_completed ? 1: 0 }}" to="{{ route('sanson.order.transform', $order) }}" icon="edit" text="Crear compra"></ddi>
                                        </dropdown>
                                    </td>
                                    <td>{{ $order->ordered_at }}</td>
                                    <td>{{ $order->provider->name }}</td>
                                    <td style="text-align: center">
                                        <span class="label label-{{ count($order->purchases) > 0 ? ($order->is_completed ? 'success': 'warning'): 'default' }}">
                                            {{ count($order->purchases) > 0 ? ($order->is_completed ? 'C. COMPLETA': 'C. PARCIAL'): 'SIN COMPRA' }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">{{ number_format($order->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </solid-box>
        </div>
    </div>

@endsection

@extends('sanson.root')

@push('pageTitle')
    Orden de compra | Detalles
@endpush

@section('content')
    <div class="row">
        <div class="col-md-10">
            <solid-box title="Orden de compra #{{ $order->id }}" color="info" button>
                <div class="row">
                    <div class="col-xs-6">
                        {!! Field::text('provider_id', $order->provider->name, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'user']) !!}
                    </div>
                    <div class="col-xs-6">
                        {!! Field::text('ordered_at', fdate($order->ordered_at, 'd M Y', 'Y-m-d'), ['label' => 'Fecha', 'tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'calendar-alt']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        {!! Field::text('amount', number_format($order->amount, 2), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'money']) !!}
                    </div>
                    <div class="col-xs-6">
                        {!! Field::text('iva', number_format($order->iva, 2), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'usd']) !!}
                    </div>
                </div>

                <h4 style="text-align:center;">PRODUCTOS</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th style="text-align: center;">Cantidad</th>
                                <th style="text-align: center;">Descuento</th>
                                <th style="text-align: right;">Importe</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($order->movements as $movement)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $movement->product->description }}</td>
                                <td>{{ number_format($movement->price, 2) }}</td>
                                <td style="text-align: center;">{{ $movement->quantity }}</td>
                                <td style="text-align: center;">
                                    {{ number_format($movement->price * ($movement->discount/100), 2) }} ({{ $movement->discount }}%)
                                </td>
                                <td style="text-align: right;">{{ number_format($movement->total, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="4"></th>
                                <th style="text-align: center;">Subtotal</th>
                                <td style="text-align: right;">{{ number_format($order->movements->sum('total'), 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="4"></th>
                                <th style="text-align: center;">IVA</th>
                                <td style="text-align: right;">{{ number_format($order->iva, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="4"></th>
                                <th style="text-align: center;">Total</th>
                                <td style="text-align: right;">{{ number_format($order->amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <a href="{{ route('sanson.order.index') }}" class="btn btn-info pull-left">
                    <i class="fa fa-backward"></i>&nbsp; HISTORIAL
                </a>
                <a href="{{ route('sanson.order.transform', $order) }}" class="btn btn-primary pull-right">CREAR VENTA</a>
            </solid-box>
        </div>
    </div>

@endsection

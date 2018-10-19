@extends('paal.root')

@push('pageTitle')
    Ingresos | Detalles
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <solid-box title="Ingreso #{{ $ingress->id }}" color="primary" button>
                <div class="row">
                    <div class="col-xs-6">
                        {!! Field::text('client_id', $ingress->client->name, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'user']) !!}
                    </div>
                    <div class="col-xs-6">
                        {!! Field::text('company', ucfirst($ingress->company), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'industry']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        {!! Field::text('bought_at', $ingress->bought_at, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'calendar']) !!}
                    </div>
                    <div class="col-xs-6">
                        {!! Field::text('amount', '$ ' . number_format($ingress->amount, 2), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'money']) !!}
                    </div>
                </div>

                <template v-if="{{ $ingress->retainer == 0 ? 0: 1}}">
                    <div class="row">
                        <div class="col-xs-4">
                            {!! Field::text('methodA', $ingress->retainer_method, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'credit-card']) !!}
                        </div>
                        <div class="col-xs-4">
                            {!! Field::text('referenceA', $ingress->referenceA, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'registered']) !!}
                        </div>
                        <div class="col-xs-4">
                            {!! Field::text('retainer', '$ ' . number_format($ingress->retainer, 2), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'money']) !!}
                        </div>
                    </div>
                </template>

                <template v-if="{{ $ingress->status == 'pagado' ? 1: 0}}">
                    <div class="row">
                        <div class="col-xs-4">
                            {!! Field::text('method', $ingress->pay_form, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'credit-card']) !!}
                        </div>
                        <div class="col-xs-4">
                            {!! Field::text('reference', $ingress->reference, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'registered']) !!}
                        </div>
                        <div class="col-xs-4">
                            {!! Field::text('paid_at', $ingress->paid_at, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'registered']) !!}
                        </div>
                    </div>
                </template>

                <hr><hr>

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Descuento</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>

                            <tbody>
                            @php
                                $subtotal = 0;
                            @endphp
                            @foreach (unserialize($ingress->products) as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ App\Product::find($product['i'])->description }}</td>
                                    <td>$ {{ number_format($product['p'], 2) }}</td>
                                    <td>{{ $product['q'] }}</td>
                                    <td>$ {{ number_format($product['d'], 2) }}</td>
                                    <td>$ {{ number_format($product['t'], 2) }}</td>
                                </tr>
                                @php
                                    $subtotal += $product['t'];
                                @endphp
                            @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="4"></th>
                                    <th>Subtotal</th>
                                    <td>$ {{ number_format($subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="4"></th>
                                    <th>IVA</th>
                                    <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="4"></th>
                                    <th>Total</th>
                                    <td>$ {{ number_format($ingress->amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </solid-box>
        </div>
    </div>

@endsection

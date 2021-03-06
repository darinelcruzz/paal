@extends('paal.root')

@push('pageTitle')
    Ingresos | Detalles
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <solid-box title="Ingreso #{{ $ingress->folio }}" color="primary" button>
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

                <h4 style="text-align:center;">
                    PAGOS 
                    <a href="{{ route('coffee.ingress.payments', $ingress) }}" target="_blank">
                        <i class="fa fa-print" aria-hidden="true"></i>
                    </a>
                </h4>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Fecha</th>
                                <th>Efectivo</th>
                                <th>Transferencia</th>
                                <th>Cheque</th>
                                <th>T. Débito</th>
                                <th>T. Crédito</th>
                                <th>Referencia</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($ingress->payments as $payment)
                            <tr>
                                <td>{{ strtoupper($payment->type) }}</td>
                                <td>{{ fdate($payment->created_at, 'd M Y') }}</td>
                                <td>{{ $payment->cash > 0 ? number_format($payment->cash, 2): '' }}</td>
                                <td>{{ $payment->transfer > 0 ? number_format($payment->transfer, 2): '' }}</td>
                                <td>{{ $payment->check > 0 ? number_format($payment->check, 2): '' }}</td>
                                <td>{{ $payment->debit_card > 0 ? number_format($payment->debit_card, 2): '' }}</td>
                                <td>{{ $payment->credit_card > 0 ? number_format($payment->credit_card, 2): '' }}</td>
                                <td>{{ $payment->reference }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h4 style="text-align:center;">PRODUCTOS</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Descripción</th>
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
            </solid-box>
        </div>
    </div>

@endsection

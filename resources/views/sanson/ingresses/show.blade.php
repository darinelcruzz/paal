@extends('sanson.root')

@push('pageTitle', 'Ventas | Detalles')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <solid-box title="Venta #{{ $ingress->folio }}" color="info" button>
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
                        {!! Field::text('bought_at', fdate($ingress->bought_at, 'd M Y', 'Y-m-d'), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'calendar-alt']) !!}
                    </div>
                    <div class="col-xs-6">
                        {!! Field::text('amount', '$ ' . number_format($ingress->amount, 2), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'money']) !!}
                    </div>
                </div>

                <h4 style="text-align:center;">
                    PAGOS 
                    <a href="{{ route('sanson.payment.print', $ingress) }}" target="_blank">
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
                                <th style="text-align: center;">No. T / Ref</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($ingress->payments as $payment)
                            <tr>
                                <td>{{ $loop->index == 0 ? ($ingress->retainer > 0 ? 'ANTICIPO': 'CONTADO'): 'ABONO' }}</td>
                                <td>{{ fdate($payment->created_at, 'd M Y') }}</td>
                                <td>{{ $payment->cash > 0 ? number_format($payment->cash, 2): '' }}</td>
                                <td>{{ $payment->transfer > 0 ? number_format($payment->transfer, 2): '' }}</td>
                                <td>{{ $payment->check > 0 ? number_format($payment->check, 2): '' }}</td>
                                <td>{{ $payment->debit_card > 0 ? number_format($payment->debit_card, 2): '' }}</td>
                                <td>{{ $payment->credit_card > 0 ? number_format($payment->credit_card, 2): '' }}</td>
                                <td style="text-align: center;">
                                    {{ $payment->card_number }} <br>
                                    {{ $payment->reference }}
                                </td>
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
                                <th style="text-align: center;">Cantidad</th>
                                <th style="text-align: center;">Descuento</th>
                                <th style="text-align: right;">Importe</th>
                            </tr>
                        </thead>
                        </thead>

                        <tbody>
                        @foreach ($ingress->movements as $movement)
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
                                <td style="text-align: right;">{{ number_format($ingress->movements->sum('total'), 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="4"></th>
                                <th style="text-align: center;">IVA</th>
                                <td style="text-align: right;">{{ number_format($ingress->iva, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="4"></th>
                                <th style="text-align: center;">Total</th>
                                <td style="text-align: right;">{{ number_format($ingress->amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('sanson.ingress.index') }}" class="btn btn-info pull-left">REGRESAR AL HISTORIAL</a>
                    </div>
                </div>
            </solid-box>
        </div>
    </div>

@endsection

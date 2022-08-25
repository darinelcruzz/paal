@extends('coffee.root')

@push('pageTitle', 'Cotizaciones | Detalles')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <solid-box title="Cotización #{{ $quotation->id }}" color="warning" button>
                <div class="row">
                    @if($quotation->client_name)
                        <div class="col-xs-6">
                            {!! Field::text('client_id', $quotation->client_name, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'user']) !!}
                        </div>
                    @else
                        <div class="col-xs-6">
                            {!! Field::text('client_id', $quotation->client->name, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'user']) !!}
                        </div>
                    @endif
                    <div class="col-xs-6">
                        {!! Field::text('company', ucfirst($quotation->company), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'industry']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        {!! Field::text('created_at', fdate($quotation->created_at, 'd M Y'), ['label' => 'Fecha', 'tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'calendar-alt']) !!}
                    </div>
                    <div class="col-xs-6">
                        {!! Field::text('amount', '' . number_format($quotation->amount, 2), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'money']) !!}
                    </div>
                </div>

                <h4 style="text-align:center;">PRODUCTOS</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Descripción</th>
                                <th style="text-align: right;">Precio</th>
                                <th style="text-align: center;">Cantidad</th>
                                <th style="text-align: center;">Descuento</th>
                                <th style="text-align: right;">Importe</th>
                            </tr>
                        </thead>

                        <tbody>
                        @php
                            $subtotal = 0;
                            $iteration = 1;
                        @endphp

                        @foreach ($quotation->movements as $movement)
                            <tr>
                                <td>{{ $iteration }}</td>
                                <td>{{ $movement->description ?? $movement->product->description }}</td>
                                <td style="text-align: right;">{{ number_format($movement->price, 2) }}</td>
                                <td style="text-align: center;">{{ $movement->quantity }}</td>
                                <td style="text-align: right;">{{ number_format($movement->discount, 2) }}</td>
                                <td style="text-align: right;">{{ number_format($movement->total, 2) }}</td>
                            </tr>
                            @php
                                $subtotal += $movement->total;
                                $iteration += 1;
                            @endphp
                        @endforeach

                        @if($quotation->products)
                            @foreach (unserialize($quotation->products) as $product)
                                <tr>
                                    <td>{{ $iteration }}</td>
                                    <td>{{ App\Product::find($product['i'])->description ?? 'ERROR' }}</td>
                                    <td>{{ number_format($product['p'], 2) }}</td>
                                    <td style="text-align: center;">{{ $product['q'] }}</td>
                                    <td style="text-align: right;">{{ number_format($product['d'], 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($product['t'], 2) }}</td>
                                </tr>
                                @php
                                    $subtotal += $product['t'];
                                    $iteration += 1;
                                @endphp
                            @endforeach
                        @endif

                        @if($quotation->special_products)
                            @foreach (unserialize($quotation->special_products) as $product)
                                <tr>
                                    <td>{{ $iteration }}</td>
                                    <td>{{ $product['i'] }}</td>
                                    <td style="text-align: right;">{{ number_format($product['p'], 2) }}</td>
                                    <td style="text-align: center;">{{ $product['q'] }}</td>
                                    <td style="text-align: right;">{{ number_format($product['d'], 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($product['t'], 2) }}</td>
                                </tr>
                                @php
                                    $subtotal += $product['t'];
                                    $iteration += 1;
                                @endphp
                            @endforeach
                        @endif
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="4"></th>
                                <th style="text-align: center;">Subtotal</th>
                                <td style="text-align: right;">{{ number_format($subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="4"></th>
                                <th style="text-align: center;">IVA</th>
                                <td style="text-align: right;">{{ number_format($quotation->iva, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="4"></th>
                                <th style="text-align: center;">Total</th>
                                <td style="text-align: right;">{{ number_format($quotation->amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <a href="{{ route($quotation->company . '.quotation.index', $quotation->status) }}" class="btn btn-danger pull-left">
                    <i class="fa fa-backward"></i>&nbsp; {{ $quotation->status == 'terminada' ? 'HISTORIAL': 'PRECOTIZACIONES'}}
                </a>
                <a href="{{ route('coffee.quotation.transform', $quotation) }}" class="btn btn-warning pull-right">CREAR VENTA</a>
            </solid-box>
        </div>
    </div>

@endsection

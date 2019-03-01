@extends('coffee.root')

@push('pageTitle')
    Cotizaciones | Detalles
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <solid-box title="Cotización #{{ $quotation->id }}" color="warning" button>
                <div class="row">
                    <div class="col-xs-6">
                        {!! Field::text('client_id', $quotation->client->name, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'user']) !!}
                    </div>
                    <div class="col-xs-6">
                        {!! Field::text('company', ucfirst($quotation->company), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'industry']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        {!! Field::text('created_at', fdate($quotation->created_at, 'd M Y'), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'calendar-alt']) !!}
                    </div>
                    <div class="col-xs-6">
                        {!! Field::text('amount', '$ ' . number_format($quotation->amount, 2), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'money']) !!}
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
                                <th>Cantidad</th>
                                <th>Descuento</th>
                                <th>Importe</th>
                            </tr>
                        </thead>

                        <tbody>
                        @php
                            $subtotal = 0;
                        @endphp
                        @foreach (unserialize($quotation->products) as $product)
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

                        @if($quotation->special_products)
                            @foreach (unserialize($quotation->special_products) as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product['i'] }}</td>
                                    <td>$ {{ number_format($product['p'], 2) }}</td>
                                    <td>{{ $product['q'] }}</td>
                                    <td>$ {{ number_format($product['d'], 2) }}</td>
                                    <td>$ {{ number_format($product['t'], 2) }}</td>
                                </tr>
                                @php
                                    $subtotal += $product['t'];
                                @endphp
                            @endforeach
                        @endif
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
                                <td>$ {{ number_format($quotation->iva, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="4"></th>
                                <th>Total</th>
                                <td>$ {{ number_format($quotation->amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <a href="{{ route('coffee.quotation.transform', $quotation) }}" class="btn btn-warning pull-left">CREAR VENTA</a>
            </solid-box>
        </div>
    </div>

@endsection

@extends('sanson.root')

@push('pageTitle')
    Cotizaciones | Detalles
@endpush

@section('content')
    <div class="row">
        <div class="col-md-10">
            <solid-box title="Cotización #{{ $quotation->id }}" color="info" button>
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
                        {!! Field::text('type', ucfirst($quotation->type), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'industry']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        {!! Field::text('created_at', fdate($quotation->created_at, 'd M Y'), ['label' => 'Fecha', 'tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'calendar-alt']) !!}
                    </div>
                    <div class="col-xs-6">
                        {!! Field::text('amount', number_format($quotation->amount, 2), ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'money']) !!}
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
                        @php
                            $subtotal = 0;
                        @endphp
                        @foreach ($quotation->movements as $movement)
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
                            @php
                                $subtotal += $movement->total
                            @endphp
                        @endforeach
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

                <a href="{{ $quotation->index_page }}" class="btn btn-info pull-left">
                    <i class="fa fa-backward"></i>&nbsp; HISTORIAL
                </a>
                <a href="{{ route('sanson.quotation.transform', $quotation) }}" class="btn btn-primary pull-right">CREAR VENTA</a>
            </solid-box>
        </div>
    </div>

@endsection

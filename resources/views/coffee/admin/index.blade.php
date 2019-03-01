@extends('coffee.root')

@push('pageTitle')
    Admin
@endpush

@section('content')
    <div class="row">
        <div class="col-md-2">

            <money-box color="danger" icon="fas fa-clock">
                Diario <br>
                <b>$ {{ number_format($payments->sum('cash') + $payments->sum('credit_card') + $payments->sum('debit_card') + $payments->sum('transfer') + $payments->sum('check'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="far fa-money-bill-alt">
                Efectivo <br>
                <b>$ {{ number_format($payments->sum('cash'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fa fa-credit-card">
                T. Débito <br>
                <b>$ {{ number_format($payments->sum('debit_card'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fab fa-cc-visa">
                T. Crédito <br>
                <b>$ {{ number_format($payments->sum('credit_Card'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fas fa-exchange-alt">
                Transferencia <br>
                <b>$ {{ number_format($payments->sum('transfer'), 2) }}</b>
            </money-box>

            <money-box color="warning" icon="fas fa-money-check-alt">
                Cheque <br>
                <b>$ {{ number_format($payments->sum('check'), 2) }}</b>
            </money-box>
        </div>


        <div class="col-md-8">

            {!! Form::open(['method' => 'post', 'route' => 'coffee.admin.index']) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        {{-- {!! Field::date('date', $date, ['label' => 'Seleccione fecha', 'tpl' => 'withicon'], ['icon' => 'calendar']) !!} --}}
                        <div class="input-group input-group-sm">
                            <input type="date" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}

            <br>

            <solid-box title="CON FACTURA" color="default" button collapsed>
                
                <data-table example="1">

                    {{ drawHeader('folio','fecha venta', 'cliente', 'estado', 'IVA', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0
                        @endphp

                        @foreach($invoiced as $ingress)
                            <tr>
                                <td>{{ $ingress->folio }}</td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>
                                    <span class="label label-{{ $ingress->statusColor }}">
                                        {{ ucfirst($ingress->status) }}
                                    </span>
                                </td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                            </tr>
                            @php
                                $total += $ingress->amount
                            @endphp
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <td colspan="4"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="EFECTIVO SIN FACTURA" color="d" button collapsed>
                
                <data-table example="2">

                    {{ drawHeader('folio', '<i class="fa fa-eye"></i>', 'fecha venta', 'cliente', 'estado', 'IVA', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0
                        @endphp

                        @foreach($paid as $ingress)
                            @if ($ingress->method == 'cash')
                            <tr>
                                <td>{{ $ingress->folio }}</td>
                                <td>
                                    <a href="" data-toggle="modal" data-target="#modal-e{{ $ingress->id }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <modal title="Lista de productos" id="modal-e{{ $ingress->id }}">
                                        <sale-products-list sale="{{ $ingress->id }}" 
                                            amount="{{ $ingress->amount }}"
                                            iva="{{ $ingress->iva }}">
                                        </sale-products-list>
                                    </modal>
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>
                                    <span class="label label-{{ $ingress->statusColor }}">
                                        {{ ucfirst($ingress->status) }}
                                    </span>
                                </td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                            </tr>
                            @php
                                $total += $ingress->amount
                            @endphp
                            @endif
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <td colspan="5"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="TARJETA SIN FACTURA" color="default" button collapsed>
                
                <data-table example="3">

                    {{ drawHeader('folio', '<i class="fa fa-eye"></i>', 'fecha venta', 'cliente', 'estado', 'IVA', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0
                        @endphp

                        @foreach($paid as $ingress)
                            @if ($ingress->method == 'credit_card' || $ingress->method == 'debit_card')
                            <tr>
                                <td>{{ $ingress->folio }}</td>
                                <td>
                                    <a href="" data-toggle="modal" data-target="#modal-tj{{ $ingress->id }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <modal title="Lista de productos" id="modal-tj{{ $ingress->id }}">
                                        <sale-products-list sale="{{ $ingress->id }}" 
                                            amount="{{ $ingress->amount }}"
                                            iva="{{ $ingress->iva }}">
                                        </sale-products-list>
                                    </modal>
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>
                                    <span class="label label-{{ $ingress->statusColor }}">
                                        {{ ucfirst($ingress->status) }}
                                    </span>
                                </td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                            </tr>
                            @php
                                $total += $ingress->amount
                            @endphp
                            @endif
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <td colspan="5"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="TRANSFERENCIA SIN FACTURA" color="d" button collapsed>
                
                <data-table example="4">

                    {{ drawHeader('folio', '<i class="fa fa-eye"></i>', 'fecha venta', 'cliente', 'estado', 'IVA', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0
                        @endphp

                        @foreach($paid as $ingress)
                            @if ($ingress->method == 'transfer')
                            <tr>
                                <td>{{ $ingress->folio }}</td>
                                <td>
                                    <a href="" data-toggle="modal" data-target="#modal-tr{{ $ingress->id }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <modal title="Lista de productos" id="modal-tr{{ $ingress->id }}">
                                        <sale-products-list sale="{{ $ingress->id }}" 
                                            amount="{{ $ingress->amount }}"
                                            iva="{{ $ingress->iva }}">
                                        </sale-products-list>
                                    </modal>
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>
                                    <span class="label label-{{ $ingress->statusColor }}">
                                        {{ ucfirst($ingress->status) }}
                                    </span>
                                </td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                            </tr>
                            @php
                                $total += $ingress->amount
                            @endphp
                            @endif
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <td colspan="5"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="ABONOS Y ANTICIPOS" color="default" button collapsed>
                
                <data-table example="5">

                    {{ drawHeader('folio','tipo', 'cliente', 'estado', 'cantidad', 'total') }}

                    <template slot="body">
                        @php
                            $total = 0
                        @endphp

                        @foreach($deposits as $deposit)
                            <tr>
                                <td>{{ $deposit->ingress->folio }}</td>
                                <td>{{ ucfirst($deposit->type) }}</td>
                                <td>{{ $deposit->ingress->client->name }}</td>
                                <td>
                                    <span class="label label-{{ $deposit->ingress->statusColor }}">
                                        {{ ucfirst($deposit->ingress->status) }}
                                    </span>
                                </td>
                                <td>{!! $deposit->methods !!}</td>
                                <td>$ {{ number_format($deposit->total, 2) }}</td>
                            </tr>
                            @php
                                $total += $deposit->amount
                            @endphp
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <td colspan="4"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                    </template>
                    
                </data-table>

            </solid-box>
        </div>


        <div class="col-md-2">
            <money-box color="primary" icon="fas fa-calendar-alt">
                Mensual <br>
                <b>$ {{ number_format($month->sum('cash') + $month->sum('credit_card') + $month->sum('debit_card') + $month->sum('transfer') + $month->sum('check'), 2) }}</b>
            </money-box>

            <money-box color="info" icon="far fa-money-bill-alt">
                Efectivo <br>
                <b>$ {{ number_format($month->sum('cash'), 2) }}</b>
            </money-box>

            <money-box color="info" icon="fa fa-credit-card">
                T. Débito <br>
                <b>$ {{ number_format($month->sum('debit_card'), 2) }}</b>
            </money-box>

            <money-box color="info" icon="fab fa-cc-visa">
                T. Crédito <br>
                <b>$ {{ number_format($month->sum('credit_Card'), 2) }}</b>
            </money-box>

            <money-box color="info" icon="fas fa-exchange-alt">
                Transferencia <br>
                <b>$ {{ number_format($month->sum('transfer'), 2) }}</b>
            </money-box>

            <money-box color="info" icon="fas fa-money-check-alt">
                Cheque <br>
                <b>$ {{ number_format($month->sum('check'), 2) }}</b>
            </money-box>
            
        </div>
    </div>

@endsection
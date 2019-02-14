@extends('coffee.root')

@push('pageTitle')
    Admin
@endpush

@section('content')
    <div class="row">
        <div class="col-md-2">
            {{-- <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="far fa-money-bill-alt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">EFECTIVO</span>
                    <span class="info-box-number">$ {{ number_format($payments->sum('cash'), 2) }}</span>
                </div>
            </div>
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-credit-card"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Tarjeta de débito</span>
                    <span class="info-box-number">$ {{ number_format($payments->sum('debit_card'), 2) }}</span>
                </div>
            </div>
            <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="fab fa-cc-visa"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Tarjeta de crédito</span>
                    <span class="info-box-number">$ {{ number_format($payments->sum('credit_card'), 2) }}</span>
                </div>
            </div>
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fas fa-exchange-alt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Transferencia</span>
                    <span class="info-box-number">$ {{ number_format($payments->sum('transfer'), 2) }}</span>
                </div>
            </div>
            <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="fas fa-money-check-alt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Cheque</span>
                    <span class="info-box-number">$ {{ number_format($payments->sum('check'), 2) }}</span>
                </div>
            </div> --}}

            <div class="box box-warning box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <div class="row">
                            <div class="col-md-4">
                                <i class="far fa-money-bill-alt fa-2x"></i>
                            </div>
                            <div class="col-md-8">
                                Efectivo <br>
                                <b>$ {{ number_format($payments->sum('cash'), 2) }}</b>
                            </div>
                        </div>
                    </h3>
                </div>
                <div class="box-body"></div>
            </div>

            <div class="box box-danger box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <div class="row">
                            <div class="col-md-4">
                                <i class="fa fa-credit-card fa-2x"></i>
                            </div>
                            <div class="col-md-8">
                                T. Débito <br>
                                <b>$ {{ number_format($payments->sum('debit_card'), 2) }}</b>
                            </div>
                        </div>
                    </h3>
                </div>
                <div class="box-body"></div>
            </div>

            <div class="box box-warning box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <div class="row">
                            <div class="col-md-4">
                                <i class="fab fa-cc-visa fa-2x"></i>
                            </div>
                            <div class="col-md-8">
                                T. Crédito <br>
                                <b>$ {{ number_format($payments->sum('credit_card'), 2) }}</b>
                            </div>
                        </div>
                    </h3>
                </div>
                <div class="box-body"></div>
            </div>

            <div class="box box-danger box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <div class="row">
                            <div class="col-md-3">
                                <i class="fas fa-exchange-alt fa-2x"></i>
                            </div>
                            <div class="col-md-9">
                                Transferencia <br>
                                <b>$ {{ number_format($payments->sum('transfer'), 2) }}</b>
                            </div>
                        </div>
                    </h3>
                </div>
                <div class="box-body"></div>
            </div>

            <div class="box box-warning box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <div class="row">
                            <div class="col-md-4">
                                <i class="fas fa-money-check-alt fa-2x"></i>
                            </div>
                            <div class="col-md-8">
                                Cheque <br>
                                <b>$ {{ number_format($payments->sum('check'), 2) }}</b>
                            </div>
                        </div>
                    </h3>
                </div>
                <div class="box-body"></div>
            </div>

            <div class="box box-primary box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <div class="row">
                            <div class="col-md-3">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <div class="col-md-9">
                                Total Diario <br>
                                <b>$ {{ number_format($payments->sum('cash') + $payments->sum('credit_card') + $payments->sum('debit_card') + $payments->sum('transfer') + $payments->sum('check'), 2) }}</b>
                            </div>
                        </div>
                    </h3>
                </div>
                <div class="box-body"></div>
            </div>

            <div class="box box-success box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <div class="row">
                            <div class="col-md-3">
                                <i class="fas fa-calendar-alt fa-2x"></i>
                            </div>
                            <div class="col-md-9">
                                Total Mensual <br>
                                <b>$ {{ number_format($month->sum('cash') + $month->sum('credit_card') + $month->sum('debit_card') + $month->sum('transfer') + $month->sum('check'), 2) }}</b>
                            </div>
                        </div>
                    </h3>
                </div>
                <div class="box-body"></div>
            </div>

        </div>


        <div class="col-md-10">

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

            <solid-box title="CON FACTURA" color="danger" button collapsed>
                
                <data-table example="1">

                    {{ drawHeader('ID','fecha venta', 'cliente', 'IVA', 'total', 'estado') }}

                    <template slot="body">
                        @foreach($invoiced as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ fdate($sale->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $sale->client->name }}</td>
                                <td>$ {{ number_format($sale->iva, 2) }}</td>
                                <td>$ {{ number_format($sale->amount, 2) }}</td>
                                <td>
                                    <span class="label label-{{ $sale->statusColor }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="EFECTIVO SIN FACTURA" color="warning" button collapsed>
                
                <data-table example="2">

                    {{ drawHeader('ID','fecha venta', 'cliente', 'IVA', 'total', 'estado') }}

                    <template slot="body">
                        @foreach($paid as $ingress)
                            @if ($ingress->method == 'cash')
                            <tr>
                                <td>{{ $ingress->id }}</td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                                <td>
                                    <span class="label label-{{ $ingress->statusColor }}">
                                        {{ ucfirst($ingress->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="TARJETA SIN FACTURA" color="danger" button collapsed>
                
                <data-table example="3">

                    {{ drawHeader('ID','fecha venta', 'cliente', 'IVA', 'total', 'estado') }}

                    <template slot="body">
                        @foreach($paid as $ingress)
                            @if ($ingress->method == 'credit_card' || $ingress->method == 'debit_card')
                            <tr>
                                <td>{{ $ingress->id }}</td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                                <td>
                                    <span class="label label-{{ $ingress->statusColor }}">
                                        {{ ucfirst($ingress->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="TRANSFERENCIA SIN FACTURA" color="warning" button collapsed>
                
                <data-table example="4">

                    {{ drawHeader('ID','fecha venta', 'cliente', 'IVA', 'total', 'estado') }}

                    <template slot="body">
                        @foreach($paid as $ingress)
                            @if ($ingress->method == 'transfer')
                            <tr>
                                <td>{{ $ingress->id }}</td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                                <td>
                                    <span class="label label-{{ $ingress->statusColor }}">
                                        {{ ucfirst($ingress->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>

            <solid-box title="ABONOS Y ANTICIPOS" color="danger" button collapsed>
                
                <data-table example="5">

                    {{ drawHeader('ID','tipo', 'cliente', 'cantidad', 'total', 'estado') }}

                    <template slot="body">
                        @foreach($deposits as $deposit)
                            <tr>
                                <td>{{ $deposit->ingress->id }}</td>
                                <td>{{ ucfirst($deposit->type) }}</td>
                                <td>{{ $deposit->ingress->client->name }}</td>
                                <td>{!! $deposit->methods !!}</td>
                                <td>$ {{ number_format($deposit->total, 2) }}</td>
                                <td>
                                    <span class="label label-{{ $deposit->ingress->statusColor }}">
                                        {{ ucfirst($deposit->ingress->status) }}
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
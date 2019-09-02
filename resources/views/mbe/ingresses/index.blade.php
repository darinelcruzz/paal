@extends('mbe.root')

@push('pageTitle')
    Corte diario
@endpush

@section('content')
    <div class="row">
        
        <div class="col-md-9">

            {!! Form::open(['method' => 'post', 'route' => ['mbe.ingress.index', $status]]) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="date" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <a href="{{ route('mbe.ingress.index', 'factura') }}" class="btn btn-success">CON FACTURA</a>
                        <a href="{{ route('mbe.ingress.index', 'efectivo') }}" class="btn btn-primary">EFECTIVO SIN</a>
                        <a href="{{ route('mbe.ingress.index', 'tarjeta') }}" class="btn btn-info">TARJETA SIN</a>
                        <a href="{{ route('mbe.ingress.index', 'transferencia') }}" class="btn btn-warning">TRANSFERENCIA SIN</a>
                    </div>
                </div>

            {!! Form::close() !!}

            <br>

            <solid-box title="{{ strtoupper($status) }}" color="{{ $color }}">
                
                <data-table>

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>', 'cliente', 'IVA', 'total') }}

                    <template slot="body">
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td>{{ $ingress->folio }}</td>
                                <td>{{ $ingress->folio }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>


        <div class="col-md-3">
            <money-box color="success" icon="fas fa-clock">
                Total <br>
                {{-- <b>$ {{ number_format($payments->sum('cash') + $payments->sum('credit_card') + $payments->sum('debit_card') + $payments->sum('transfer') + $payments->sum('check'), 2) }}</b> --}}
                <b>$ 100.00</b>
            </money-box>

            <money-box color="warning" icon="far fa-money-bill-alt">
                Efectivo <br>
                <b>$ {{ 100.00 }}</b>
            </money-box>

            <money-box color="warning" icon="fa fa-credit-card">
                T. Débito <br>
                <b>$ {{ 100.00 }}</b>
            </money-box>

            <money-box color="warning" icon="fab fa-cc-visa">
                T. Crédito <br>
                <b>$ {{ 100.00 }}</b>
            </money-box>

            <money-box color="warning" icon="fas fa-exchange-alt">
                Transferencia <br>
                <b>$ {{ 100.00 }}</b>
            </money-box>

            <money-box color="warning" icon="fas fa-money-check-alt">
                Cheque <br>
                <b>$ {{ 100.00 }}</b>
            </money-box>
        </div>
    </div>

@endsection
{{-- @extends('mbe.root')

@push('pageTitle')
    Ingresos | Lista
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Ingresos" color="success" button>
                <a href="{{ route('mbe.ingress.create') }}" class="btn btn-success btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
                <br>
                <br>
                <data-table example="1">

                    {{ drawHeader('ID', 'cliente', 'compra', 'pago', 'I.V.A.', 'total', 'método', 'estado') }}

                    <template slot="body">
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td>{{ $ingress->id }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ fdate($ingress->paid_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                                <td>{{ $ingress->method_name }}</td>
                                <td><span class="label label-{{ $ingress->status_color }}">{{ strtoupper($ingress->status) }}</span></td>
                            </tr>
                        @endforeach
                    </template>

                </data-table>

            </solid-box>
        </div>
    </div>

@endsection --}}

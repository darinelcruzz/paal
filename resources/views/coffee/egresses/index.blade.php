@extends('coffee.root')

@push('pageTitle')
    Egresos | Lista
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">                
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::open(['method' => 'post', 'route' => 'coffee.egress.index']) !!}
                            <div class="input-group input-group-sm">
                                <input type="month" name="date" class="form-control" value="{{ $date }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="col-md-3">
                        <label class="btn btn-success btn-bg btn-block">
                            $ {{ number_format($egresses->where('status', 'pagado')->sum('amount')) }}
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label class="btn btn-warning btn-bg btn-block">
                            $ {{ number_format($alltime->where('status', 'pendiente')->sum('amount') + $alltime->where('status', 'pendiente')->sum('iva'), 2) }}
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label class="btn btn-danger btn-bg btn-block">
                            $ {{ number_format($alltime->where('status', 'vencido')->sum('amount') + $alltime->where('status', 'vencido')->sum('iva'), 2) }}
                        </label>
                    </div>
                </div>

            <br>

            <solid-box title="Egresos pagados" color="success" button>

                <data-table example="ordered">

                    {{ drawHeader('pago (s)', 'folio', '<i class="fa fa-cogs"></i>', 'proveedor','compra', 'I.V.A.', 'total') }}

                    <template slot="body">

                        @foreach($checks as $check)
                            <tr style="text-align: center;">
                                <td>{{ fdate($check->charged_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>CH {{ $check->folio }}</td>
                                <td>
                                    <dropdown color="success" icon="cogs">
                                        <ddi to="{{ Storage::url($check->pdf) }}" icon="file-pdf" text="Ver factura" target="_blank"></ddi>
                                        <ddi to="{{ route('coffee.check.show', $check) }}" icon="eye" text="Detalles"></ddi>
                                    </dropdown>
                                </td>
                                <td>CAJA CHICA</td>
                                <td>{{ fdate($check->charged_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>$ {{ number_format($check->iva, 2) }}</td>
                                <td>$  {{ number_format($check->total, 2) }}</td>
                            </tr>
                        @endforeach

                        @foreach($egresses as $egress)
                            <tr style="text-align: center;">
                                <td>
                                    @if($egress->payment_date)
                                        {{ fdate($egress->payment_date, 'd M Y', 'Y-m-d') }}
                                        | {{ $egress->mfolio }}
                                    @endif
                                    @if($egress->second_payment_date)
                                        {{ fdate($egress->second_payment_date, 'd M Y', 'Y-m-d') }}
                                        | <br>{{ $egress->nfolio }}
                                    @endif
                                </td>
                                <td>{{ $egress->folio }}</td>
                                <td>
                                    @include('coffee.egresses._dropdown', ['color' => 'success'])
                                </td>
                                <td>{{ $egress->provider->name }} {{ $egress->provider_name != null ? " ($egress->provider_name)": ''}}</td>
                                <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                                <td>$ {{ number_format($egress->iva, 2) }}</td>
                                <td>$ {{ number_format($egress->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr style="text-align: center;">
                            <td colspan="4"></td>
                            <th>Total</th>
                            <td>$ {{ number_format($egresses->sum('iva'), 2) }}</td>
                            <td>$ {{ number_format($egresses->sum('amount'), 2) }}</td>
                        </tr>
                    </template>

                </data-table>

            </solid-box>

            <br>

            <solid-box title="Pendientes de pagar" color="warning" button>

                <data-table example="1">

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>', 'emisión', 'proveedor', 'I.V.A.', 'total') }}

                    <template slot="body">
                        @foreach($unpaid as $egress)
                            @if(!$egress->check_id)
                                <tr style="text-align: center;">
                                    <td>
                                        {{ $egress->folio }}
                                    </td>
                                    <td>
                                        @include('coffee.egresses._dropdown', ['color' => 'warning'])
                                    </td>
                                    <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                                    <td>{{ $egress->provider->name }}
                                        {{ $egress->returned_to != null ? " | REPOSICIÓN": '' }}
                                        {{ $egress->provider_name != null ? " ($egress->provider_name)": '' }}</td>
                                    <td>$ {{ number_format($egress->iva, 2) }}</td>
                                    <td>$  {{ number_format($egress->amount, 2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </template>

                </data-table>

            </solid-box>
        </div>
    </div>

@endsection

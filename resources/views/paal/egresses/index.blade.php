@extends('paal.root')

@push('pageTitle')
    Egresos | {{ ucfirst($status) . 's' }}
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">                
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::open(['method' => 'post', 'route' => ['paal.egress.index', $company, $status]]) !!}
                            <div class="input-group input-group-sm">
                                <input type="month" name="date" class="form-control" value="{{ $date }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-{{ $company == 'coffee' ? 'danger': 'success' }} btn-flat"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="col-md-1">
                        <a href="{{ route('paal.egress.index', [$company == 'coffee' ? 'mbe': 'coffee', $status]) }}" class="btn btn-primary btn-xs">
                            <i class="fa fa-random fa-2x"></i>
                        </a>
                    </div>

                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{ route('paal.egress.index', [$company, 'pagado']) }}" class="btn btn-success btn-block">
                                    $ {{ number_format($paid->sum('amount')  + $checkssum, 2) }}
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('paal.egress.index', [$company, 'pendiente']) }}" class="btn btn-warning btn-block">
                                    $ {{ number_format($alltime->where('status', 'pendiente')->sum('amount'), 2) }}
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('paal.egress.index', [$company, 'vencido']) }}" class="btn btn-danger btn-block">
                                    $ {{ number_format($alltime->where('status', 'vencido')->sum('amount'), 2) }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            <br>
            
            <solid-box title="{{ ucfirst($status) }}s" color="{{ $color}}" label="{{ strtoupper($company) }}">

                <data-table example="ordered">

                    {{ drawHeader('pago (s)', 'folio', '<i class="fa fa-cogs"></i>', 'proveedor','compra', 'I.V.A.', 'total') }}

                    <template slot="body">

                        @foreach($checks as $check)
                            <tr style="text-align: center;">
                                <td>{{ fdate($check->charged_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>CH {{ $check->folio }}</td>
                                <td>
                                    <dropdown color="{{ $color }}" icon="cogs">
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
                                    @include('paal.egresses._dropdown')
                                </td>
                                <td>
                                    {{ $egress->provider->name ?? $egress->provider_name }} {{ $egress->provider_name != null ? " ($egress->provider_name)": ''}}
                                    <br>{{ $egress->provider->rfc }}
                                </td>
                                <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                                <td>$ {{ number_format($egress->iva, 2) }}</td>
                                <td>$ {{ number_format($egress->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </template>

                </data-table>

            </solid-box>
            
            {{-- @elseif($status == 'pendiente')

                <solid-box title="Pendientes de pagar" color="warning" button>

                    <data-table example="1">

                        {{ drawHeader('emisión', 'folio', '<i class="fa fa-cogs"></i>', 'proveedor', 'I.V.A.', 'total') }}

                        <template slot="body">
                            @foreach($pending as $egress)
                                @if(!$egress->check_id)
                                    <tr style="text-align: center;">
                                        <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                                        <td>
                                            {{ $egress->folio }}
                                        </td>
                                        <td>
                                            @include('coffee.egresses._dropdown', ['color' => 'warning'])
                                        </td>
                                        <td>
                                            {{ $egress->provider->name ?? '' }}
                                            {{ $egress->receiver != null ? "REPOSICIÓN (HECTOR, $egress->provider_name)": "" }}
                                        </td>
                                        <td>$ {{ number_format($egress->iva, 2) }}</td>
                                        <td>$  {{ number_format($egress->amount, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </template>

                    </data-table>

                </solid-box>

            @else

                <solid-box title="Vencidos" color="danger" button>

                    <data-table example="1">

                        {{ drawHeader('emisión', 'folio', '<i class="fa fa-cogs"></i>', 'proveedor', 'I.V.A.', 'total') }}

                        <template slot="body">
                            @foreach($expired as $egress)
                                @if(!$egress->check_id)
                                    <tr style="text-align: center;">
                                        <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                                        <td>
                                            {{ $egress->folio }}
                                        </td>
                                        <td>
                                            @include('coffee.egresses._dropdown', ['color' => 'danger'])
                                        </td>
                                        <td>{{ $egress->provider->name ?? '' }}
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
            @endif --}}
        </div>
    </div>

@endsection

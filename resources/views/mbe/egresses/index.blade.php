@extends('mbe.root')

@push('pageTitle')
    Egresos | {{ ucfirst($status) . 's' }}
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">                
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::open(['method' => 'post', 'route' => ['mbe.egress.index', $status]]) !!}
                            <div class="input-group input-group-sm">
                                <input type="month" name="date" class="form-control" value="{{ $date }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('mbe.egress.index', 'pagado') }}">
                            <label class="btn btn-success btn-bg btn-block">
                                {{ number_format($paid->sum(function ($ingress) { return $ingress->mbe ?? $ingress->amount;})  + $checkssum) }}
                            </label>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('mbe.egress.index', 'pendiente') }}">
                            <label class="btn btn-warning btn-bg btn-block">
                                {{ number_format($alltime->where('status', 'pendiente')->sum(function ($ingress) { return $ingress->mbe ?? $ingress->amount;}) + $alltime->where('status', 'pendiente')->sum('iva'), 2) }}
                            </label>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('mbe.egress.index', 'vencido') }}">
                            <label class="btn btn-danger btn-bg btn-block">
                                {{ number_format($alltime->where('status', 'vencido')->sum(function ($ingress) { return $ingress->mbe ?? $ingress->amount;}) + $alltime->where('status', 'vencido')->sum('iva'), 2) }}
                            </label>
                        </a>
                    </div>
                </div>

            <br>

            @if($status == 'pagado')
                <solid-box title="Pagados" color="success" button>

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
                                            <ddi to="{{ route('mbe.check.show', $check) }}" icon="eye" text="Detalles"></ddi>
                                        </dropdown>
                                    </td>
                                    <td>CAJA CHICA</td>
                                    <td>{{ fdate($check->charged_at, 'd M Y', 'Y-m-d') }}</td>
                                    <td>{{ number_format($check->iva, 2) }}</td>
                                    <td>{{ number_format($check->total, 2) }}</td>
                                </tr>
                            @endforeach

                            @foreach($paid as $egress)
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
                                        @include('mbe.egresses._dropdown', ['color' => 'success'])
                                    </td>
                                    <td>{{ $egress->provider->name ?? $egress->provider_name }} {{ $egress->provider_name != null ? " ($egress->provider_name)": ''}}
                                        <br>{{ $egress->provider->rfc }}
                                    </td>
                                    <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                                    <td>{{ number_format($egress->iva, 2) }}</td>
                                    <td>
                                        @if($egress->provider->type == 'pd')
                                            {{ number_format($egress->mbe, 2) }}
                                        @else
                                            {{ number_format($egress->amount, 2) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </template>

                    </data-table>

                </solid-box>
            
            @elseif($status == 'pendiente')

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
                                            @include('mbe.egresses._dropdown', ['color' => 'warning'])
                                        </td>
                                        <td>
                                            {{ $egress->provider->name }}
                                            {{ $egress->provider_name != null ? "($egress->provider_name" . ($egress->receiver != null ? ", $egress->return_name)": ')') : "" }}
                                            <br>{{ $egress->provider->rfc }}
                                        </td>
                                        <td>{{ number_format($egress->iva, 2) }}</td>
                                        <td>
                                            @if($egress->provider->type == 'pd')
                                                {{ number_format($egress->mbe, 2) }}
                                            @else
                                                {{ number_format($egress->amount, 2) }}
                                            @endif
                                        </td>
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
                                            @include('mbe.egresses._dropdown', ['color' => 'danger'])
                                        </td>
                                        <td>{{ $egress->provider->name ?? '' }}
                                            {{ $egress->returned_to != null ? " | REPOSICIÓN": '' }}
                                            {{ $egress->provider_name != null ? " ($egress->provider_name)": '' }}</td>
                                        <td>{{ number_format($egress->iva, 2) }}</td>
                                        <td> {{ number_format($egress->amount, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </template>

                    </data-table>

                </solid-box>
            @endif
        </div>
    </div>

@endsection

@extends('coffee.root')

@push('pageTitle')
    Egresos | {{ ucfirst($status) . 's' }}
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">                
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::open(['method' => 'post', 'route' => ['coffee.egress.index', $status]]) !!}
                            <div class="input-group input-group-sm">
                                <input type="month" name="date" class="form-control" value="{{ $date }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('coffee.egress.index', ['pagado', $date]) }}">
                            <label class="btn btn-success btn-bg btn-block">
                                {{ number_format($paid->sum(function ($egress) { return $egress->coffee != 0 ? $egress->coffee: $egress->amount;})  + $checkssum) }}
                            </label>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('coffee.egress.index', ['pendiente', $date]) }}">
                            <label class="btn btn-warning btn-bg btn-block">
                                {{ number_format($pending->sum(function ($egress) { return $egress->coffee != 0 ? $egress->coffee: $egress->amount;}), 2) }}
                            </label>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('coffee.egress.index', ['vencido', $date]) }}">
                            <label class="btn btn-danger btn-bg btn-block">
                                {{ number_format($expired->sum(function ($egress) { return $egress->coffee != 0 ? $egress->coffee: $egress->amount;}), 2) }}
                            </label>
                        </a>
                    </div>
                </div>

            <br>

            @if($status == 'pagado')
                <solid-box title="Pagados" color="success" button>

                    <data-table example="ordered">

                        {{ drawHeader('pago (s)', 'folio', '<i class="fa fa-cogs"></i>', 'tipo', 'proveedor','compra', 'I.V.A.', 'total') }}

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
                                    <td></td>
                                    <td>CAJA CHICA</td>
                                    <td>{{ fdate($check->charged_at, 'd M Y', 'Y-m-d') }}</td>
                                    <td>{{ number_format($check->iva, 2) }}</td>
                                    <td> {{ number_format($check->total, 2) }}</td>
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
                                            <br>
                                            {{ fdate($egress->second_payment_date, 'd M Y', 'Y-m-d') }}
                                            | {{ $egress->nfolio }}
                                        @endif
                                    </td>
                                    <td>{{ $egress->folio }}</td>
                                    <td>
                                        @include('coffee.egresses._dropdown', ['color' => 'success'])
                                    </td>
                                    <td>
                                        @if($egress->type)
                                            <span class="label label-{{ $egress->type == 'insumos' ? 'success': ($egress->type == 'publicidad' ? 'primary' :'danger') }}">
                                                {{ strtoupper($egress->type) }}
                                            </span>
                                        @elseif($egress->coffee > 0)
                                            <span class="label label-default">PARCIAL</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $egress->provider->name ?? $egress->provider_name }} {{ $egress->provider_name != null ? " ($egress->provider_name)": ''}}
                                        <br><code>{{ $egress->provider->rfc }}</code>
                                    </td>
                                    <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                                    <td>{{ number_format($egress->iva, 2) }}</td>
                                    <td>
                                        @if($egress->provider->type == 'pd')
                                            {{ number_format($egress->coffee, 2) }}
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

                        {{ drawHeader('vencimiento', 'emisión', 'folio', '<i class="fa fa-cogs"></i>', 'tipo', 'proveedor', 'I.V.A.', 'total', 'adeudo') }}

                        <template slot="body">
                            @foreach($pending as $egress)
                                @if(!$egress->check_id)
                                @php
                                    $egress->checkExpiration();
                                @endphp
                                    <tr style="text-align: center;">
                                        <td>{{ fdate($egress->expiration, 'd M Y', 'Y-m-d') }}</td>
                                        <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                                        <td>
                                            {{ $egress->folio }}
                                        </td>
                                        <td>
                                            @include('coffee.egresses._dropdown', ['color' => 'warning'])
                                        </td>
                                        <td>
                                            @if($egress->type)
                                                <span class="label label-{{ $egress->type == 'insumos' ? 'success': ($egress->type == 'publicidad' ? 'primary' :'danger') }}">
                                                    {{ strtoupper($egress->type) }}
                                                </span>
                                            @elseif($egress->coffee > 0)
                                                <span class="label label-default">PARCIAL</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $egress->provider->name }}
                                            {{ $egress->provider_name != null ? "($egress->provider_name" . ($egress->receiver != null ? ", $egress->return_name)": ')') : "" }}
                                            <br><code>{{ $egress->provider->rfc }}</code>
                                        </td>
                                        <td>{{ number_format($egress->iva, 2) }}</td>
                                        <td>
                                            @if($egress->provider->type == 'pd')
                                                {{ number_format($egress->coffee, 2) }}
                                            @else
                                                {{ number_format($egress->amount, 2) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($egress->provider->type == 'pd')
                                                {{ number_format($egress->coffee, 2) }}
                                            @else
                                                {{ number_format($egress->debt, 2) }}
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

                        {{ drawHeader('emisión', 'folio', '<i class="fa fa-cogs"></i>', 'tipo', 'proveedor', 'I.V.A.', 'total', 'adeudo') }}

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
                                        <td>
                                            {{ $egress->type }}
                                        </td>
                                        <td>{{ $egress->provider->name ?? '' }}
                                            {{ $egress->returned_to != null ? " | REPOSICIÓN": '' }}
                                            {{ $egress->provider_name != null ? " ($egress->provider_name)": '' }}
                                            <br><code>{{ $egress->provider->rfc }}</code>
                                        </td>
                                        <td>{{ number_format($egress->iva, 2) }}</td>
                                        <td>
                                            @if($egress->provider->type == 'pd')
                                                {{ number_format($egress->coffee, 2) }}
                                            @else
                                                {{ number_format($egress->amount, 2) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($egress->provider->type == 'pd')
                                                {{ number_format($egress->coffee, 2) }}
                                            @else
                                                {{ number_format($egress->debt, 2) }}
                                            @endif
                                        </td>
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

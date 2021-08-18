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
                        <a href="{{ route('mbe.egress.index', ['pagado', $date]) }}">
                            <label class="btn btn-success btn-bg btn-block">
                                {{ number_format($paid->sum(function ($ingress) { return $ingress->mbe > 0 ? $ingress->mbe: $ingress->amount;})  + $checkssum, 2) }}
                            </label>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('mbe.egress.index', ['pendiente', $date]) }}">
                            <label class="btn btn-warning btn-bg btn-block">
                                {{ number_format($pending->where('check_id', null)->sum(function ($ingress) { return $ingress->mbe != 0 ? $ingress->mbe: $ingress->amount;}), 2) }}
                            </label>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('mbe.egress.index', ['vencido', $date]) }}">
                            <label class="btn btn-danger btn-bg btn-block">
                                {{ number_format($expired->sum(function ($egress) { return $egress->mbe != 0 ? $egress->mbe: $egress->amount;}), 2) }}
                            </label>
                        </a>
                    </div>
                </div>

            <br>

            @if($status == 'pagado')
                <solid-box title="PAGADOS" color="success" button>

                    @php
                        $paidTotal = 0;
                    @endphp

                    <table class="table table-striped table-bordered spanish">

                        <thead>
                            <tr>
                                <th><small>PAGO(S)</small></th>
                                <th style="width: 5%;"><i class="fa fa-cogs"></i></th>
                                <th style="width: 10%;"><small>FOLIO</small></th>
                                <th><small>PROVEEDOR</small></th>
                                <th style="text-align: right; width: 10%;"><small>F.COMPRA</small></th>
                                <th style="text-align: right;width: 8%;"><small>I.V.A.</small></th>
                                <th style="text-align: right;"><small>IMPORTE</small></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($checks as $check)
                                <tr>
                                    <td>{{ fdate($check->charged_at, 'd M Y', 'Y-m-d') }}</td>
                                    <td>
                                        <dropdown color="success" icon="cogs">
                                            <ddi to="{{ Storage::url($check->pdf) }}" icon="file-pdf" text="Ver factura" target="_blank"></ddi>
                                            <ddi to="{{ route('mbe.check.show', $check) }}" icon="eye" text="Detalles"></ddi>
                                        </dropdown>
                                    </td>
                                    <td>CH {{ $check->folio }}</td>
                                    <td>CAJA CHICA</td>
                                    <td style="text-align: right;"><small>{{ strtoupper(fdate($check->charged_at, 'd M Y', 'Y-m-d')) }}</small></td>
                                    <td style="text-align: right;">{{ number_format($check->iva, 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($check->total, 2) }}</td>
                                </tr>
                                @php
                                    $paidTotal += $check->total;
                                @endphp
                            @endforeach

                            @foreach($paid as $egress)
                                <tr>
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
                                    <td>
                                        @include('mbe.egresses._dropdown', ['color' => 'success'])
                                    </td>
                                    <td>{{ $egress->folio }}</td>
                                    <td>
                                        {{ $egress->provider_name ?? $egress->provider->name }} <code>{{ $egress->provider->rfc }}</code>
                                    </td>
                                    <td style="text-align: right;"><small>{{ strtoupper(fdate($egress->emission, 'd M Y', 'Y-m-d')) }}</small></td>
                                    <td style="text-align: right;">{{ number_format($egress->iva, 2) }}</td>
                                    <td style="text-align: right;">
                                        @if($egress->provider->type == 'pd')
                                            {{ number_format($egress->mbe, 2) }}
                                        @else
                                            {{ number_format($egress->amount, 2) }}
                                        @endif
                                    </td>
                                </tr>

                                @php
                                    if($egress->provider->type == 'pd') {
                                        $paidTotal += $egress->mbe;
                                    }
                                    else {
                                        $paidTotal += $egress->amount;
                                    }
                                @endphp
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th></th><th></th><th></th><th></th><th></th>
                                <th style="text-align: right;"><small>TOTAL</small></th>
                                <th style="text-align: right;">{{ number_format($paidTotal, 2) }}</th>
                            </tr>
                        </tfoot>

                    </table>

                </solid-box>
            
            @elseif($status == 'pendiente')

                <solid-box title="Pendientes de pagar" color="warning" button>

                    @php
                        $pendingTotal = 0;
                    @endphp

                    <table class="table table-striped table-bordered spanish">

                        <thead>
                            <tr>
                                <th style="width: 10%;"><small>F. EMISIÓN</small></th>
                                <th style="width: 5%;"><i class="fa fa-cogs"></i></th>
                                <th style="width: 10%;"><small>FOLIO</small></th>
                                <th><small>PROVEEDOR</small></th>
                                <th style="text-align: right;width: 8%;"><small>I.V.A.</small></th>
                                <th style="text-align: right;"><small>IMPORTE</small></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($pending as $egress)
                                @if(!$egress->check_id)
                                    <tr>
                                        <td><small>{{ strtoupper(fdate($egress->emission, 'd M Y', 'Y-m-d')) }}</small></td>
                                        <td>
                                            @include('mbe.egresses._dropdown', ['color' => 'warning'])
                                        </td>
                                        <td>{{ $egress->folio }}</td>
                                        <td>
                                            {{ $egress->provider_name ?? $egress->provider->name }}
                                            <code>{{ $egress->provider->rfc ?? '' }}</code>
                                        </td>
                                        <td style="text-align: right;">{{ number_format($egress->iva, 2) }}</td>
                                        <td style="text-align: right;">
                                            @if($egress->provider->type == 'pd')
                                                {{ number_format($egress->mbe, 2) }}
                                            @else
                                                {{ number_format($egress->amount, 2) }}
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        if($egress->provider->type == 'pd') {
                                            $pendingTotal += $egress->mbe;
                                        } else {
                                            $pendingTotal += $egress->amount;
                                        }
                                    @endphp
                                @endif
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th></th><th></th><th></th><th></th>
                                <th style="text-align: right;"><small>TOTAL</small></th>
                                <th style="text-align: right;">{{ number_format($pendingTotal, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>

                </solid-box>

            @else

                <solid-box title="Vencidos" color="danger" button>
                    @php
                        $expiredTotal = 0;
                    @endphp

                    <table class="table table-striped table-bordered spanish">
                        <thead>
                            <tr>
                                <th style="width: 10%;"><small>F. EMISIÓN</small></th>
                                <th style="width: 5%;"><i class="fa fa-cogs"></i></th>
                                <th style="width: 10%;"><small>FOLIO</small></th>
                                <th><small>PROVEEDOR</small></th>
                                <th style="text-align: right;width: 8%;"><small>I.V.A.</small></th>
                                <th style="text-align: right;"><small>IMPORTE</small></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($expired as $egress)
                                @if(!$egress->check_id)
                                    <tr>
                                        <td><small>{{ strtoupper(fdate($egress->emission, 'd M Y', 'Y-m-d')) }}</small></td>
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
                                        <td>
                                            @if($egress->provider->type == 'pd')
                                                {{ number_format($egress->mbe, 2) }}
                                            @else
                                                {{ number_format($egress->amount, 2) }}
                                            @endif
                                        </td>
                                    </tr>

                                    @php
                                        if($egress->provider->type == 'pd') {
                                            $expiredTotal += $egress->mbe;
                                        } else {
                                            $expiredTotal += $egress->amount;
                                        }
                                    @endphp
                                @endif
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th></th><th></th><th></th><th></th>
                                <th style="text-align: right;"><small>TOTAL</small></th>
                                <th style="text-align: right;">{{ number_format($expiredTotal, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>

                </solid-box>
            @endif
        </div>
    </div>

@endsection

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
                                {{ number_format($paid->sum(function ($egress) { return $egress->coffee != 0 ? $egress->coffee: $egress->amount;})  + $checkssum, 2) }}
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
                                <th style="width: 8%;"><small>TIPO</small></th>
                                <th><small>PROVEEDOR</small></th>
                                <th style="text-align: right; width: 10%;"><small>F.COMPRA</small></th>
                                <th style="text-align: right;width: 8%;"><small>I.V.A.</small></th>
                                <th style="text-align: right;"><small>IMPORTE</small></th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($checks as $check)
                            <tr>
                                <td><small>{{ strtoupper(fdate($check->charged_at, 'd M Y', 'Y-m-d')) }}</small></td>
                                <td>
                                    <dropdown color="success" icon="cogs">
                                        <ddi to="{{ Storage::url($check->pdf) }}" icon="file-pdf" text="Ver factura" target="_blank"></ddi>
                                        <ddi to="{{ route('coffee.check.show', $check) }}" icon="eye" text="Detalles"></ddi>
                                    </dropdown>
                                </td>
                                <td>CH {{ $check->folio }}</td>
                                <td>CHEQUE</td>
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
                                    @foreach($egress->payments as $payment)
                                        <small>{{ strtoupper(fdate($payment->paid_at, 'd M Y', 'Y-m-d')) }} - {{ $payment->folio }}</small> 
                                        @if(!$loop->last)
                                        <br>
                                        @endif
                                    @endforeach
                                    {{-- @if($egress->payment_date)
                                        
                                    @endif
                                    @if($egress->second_payment_date)
                                        <br>
                                        <small>{{ strtoupper(fdate($egress->second_payment_date, 'd M Y', 'Y-)m-d</small>') }}
                                        | {{ $egress->nfolio }}
                                    @endif --}}
                                </td>
                                <td>
                                    @include('coffee.egresses._dropdown', ['color' => 'success'])
                                </td>
                                <td>{{ $egress->folio }}</td>
                                <td>
                                    @if($egress->type)
                                        <span class="label label-{{ $egress->type == 'insumos' ? 'success': ($egress->type == 'publicidad' ? 'primary' :'danger') }}">
                                            <small>{{ strtoupper($egress->type) }}</small>
                                        </span>
                                    @elseif($egress->coffee > 0)
                                        <span class="label label-default"><small>PARCIAL</small></span>
                                    @endif
                                </td>
                                <td>
                                    {{ $egress->provider_name ?? $egress->provider->name }}
                                    <code>{{ $egress->provider->rfc }}</code>
                                </td>
                                <td style="text-align: right;"><small>{{ strtoupper(fdate($egress->emission, 'd M Y', 'Y-m-d')) }}</small></td>
                                <td style="text-align: right;">{{ number_format($egress->iva, 2) }}</td>
                                <td style="text-align: right;">
                                    @if($egress->provider->type == 'pd')
                                        {{ number_format($egress->coffee, 2) }}
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
                                <th></th><th></th><th></th><th></th><th></th><th></th>
                                <th style="text-align: right;"><small>TOTAL</small></th>
                                <th style="text-align: right;">{{ number_format($paidTotal, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>

                </solid-box>
            
            @elseif($status == 'pendiente')

                <solid-box title="PENDIENTES" color="warning" button>
                    @php
                        $pendingTotal = 0;
                        $pendingTotalDebt = 0;
                    @endphp
                    <table class="table table-striped table-bordered spanish">

                        {{-- {{ drawHeader('vencimiento', 'emisión', 'folio', '<i class="fa fa-cogs"></i>', 'tipo', 'proveedor', 'I.V.A.', 'total', 'adeudo') }} --}}
                        <thead>
                            <tr>
                                <th><small>VENCIMIENTO</small></th>
                                <th style="width: 5%;"><i class="fa fa-cogs"></i></th>
                                <th style="width: 10%;"><small>FOLIO</small></th>
                                <th style="width: 8%;"><small>TIPO</small></th>
                                <th><small>PROVEEDOR</small></th>
                                <th style="text-align: right; width: 10%;"><small>EMISIÓN</small></th>
                                <th style="text-align: right;width: 8%;"><small>I.V.A.</small></th>
                                <th style="text-align: right;"><small>IMPORTE</small></th>
                                <th style="text-align: right;"><small>ADEUDO</small></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($pending as $egress)
                                @if(!$egress->check_id)
                                @php
                                    $egress->checkExpiration();
                                @endphp
                                    <tr>
                                        <td><small>{{ strtoupper(fdate($egress->expiration, 'd M Y', 'Y-m-d')) }}</small></td>
                                        <td>
                                            @include('coffee.egresses._dropdown', ['color' => 'warning'])
                                        </td>
                                        <td>{{ $egress->folio }}</td>
                                        <td>
                                            @if($egress->type)
                                                <span class="label label-{{ $egress->type == 'insumos' ? 'success': ($egress->type == 'publicidad' ? 'primary' :'danger') }}">
                                                    <small>{{ strtoupper($egress->type) }}</small>
                                                </span>
                                            @elseif($egress->coffee > 0)
                                                <span class="label label-default"><small>PARCIAL</small></span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $egress->provider_name ??  $egress->provider->name }} <code>{{ $egress->provider->rfc }}</code>
                                        </td>
                                        <td style="text-align: right;"><small>{{ strtoupper(fdate($egress->emission, 'd M Y', 'Y-m-d')) }}</small></td>
                                        <td style="text-align: right;">{{ number_format($egress->iva, 2) }}</td>
                                        <td style="text-align: right;">
                                            @if($egress->provider->type == 'pd')
                                                {{ number_format($egress->coffee, 2) }}
                                            @else
                                                {{ number_format($egress->amount, 2) }}
                                            @endif
                                        </td>
                                        <td style="text-align: right;">
                                            @if($egress->provider->type == 'pd')
                                                {{ number_format($egress->coffee, 2) }}
                                            @else
                                                {{ number_format($egress->debt, 2) }}
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        if($egress->provider->type == 'pd') {
                                            $pendingTotal += $egress->coffee;
                                            $pendingTotalDebt += $egress->debt;
                                        } else {
                                            $pendingTotal += $egress->amount;
                                            $pendingTotalDebt += $egress->debt;
                                        }
                                    @endphp
                                @endif
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th></th><th></th><th></th><th></th><th></th><th></th>
                                <th style="text-align: right;"><small>TOTAL</small></th>
                                <th style="text-align: right;">{{ number_format($pendingTotal, 2) }}</th>
                                <th style="text-align: right;">{{ number_format($pendingTotalDebt, 2) }}</th>
                            </tr>
                        </tfoot>

                    </table>

                </solid-box>

            @else

                <solid-box title="VENCIDOS" color="danger" button>

                    <table class="table table-striped table-bordered spanish">

                        @php
                            $expiredTotal = 0;
                            $expiredTotalDebt = 0;
                        @endphp
                        <thead>
                            <tr>
                                <th style="width: 10%;"><small>EMISIÓN</small></th>
                                <th style="width: 5%;"><i class="fa fa-cogs"></i></th>
                                <th style="width: 10%;"><small>FOLIO</small></th>
                                <th style="width: 8%;"><small>TIPO</small></th>
                                <th><small>PROVEEDOR</small></th>
                                <th style="text-align: right;width: 8%;"><small>I.V.A.</small></th>
                                <th style="text-align: right;"><small>IMPORTE</small></th>
                                <th style="text-align: right;"><small>ADEUDO</small></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($expired as $egress)
                                @if(!$egress->check_id)
                                    <tr>
                                        <td><small>{{ strtoupper(fdate($egress->emission, 'd M Y', 'Y-m-d')) }}</small></td>
                                        <td>
                                            @include('coffee.egresses._dropdown', ['color' => 'danger'])
                                        </td>
                                        <td>{{ $egress->folio }}</td>
                                        <td>
                                            @if($egress->type)
                                                <span class="label label-{{ $egress->type == 'insumos' ? 'success': ($egress->type == 'publicidad' ? 'primary' :'danger') }}">
                                                    <small>{{ strtoupper($egress->type) }}</small>
                                                </span>
                                            @elseif($egress->coffee > 0)
                                                <span class="label label-default"><small>PARCIAL</small></span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $egress->provider_name ?? $egress->provider->name }}<code>{{ $egress->provider->rfc }}</code>
                                        </td>
                                        <td style="text-align: right;">{{ number_format($egress->iva, 2) }}</td>
                                        <td style="text-align: right;">
                                            @if($egress->provider->type == 'pd')
                                                {{ number_format($egress->coffee, 2) }}
                                            @else
                                                {{ number_format($egress->amount, 2) }}
                                            @endif
                                        </td>
                                        <td style="text-align: right;">
                                            @if($egress->provider->type == 'pd')
                                                {{ number_format($egress->coffee, 2) }}
                                            @else
                                                {{ number_format($egress->debt, 2) }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th></th><th></th><th></th><th></th><th></th>
                                <th style="text-align: right;"><small>TOTAL</small></th>
                                <th style="text-align: right;">{{ number_format($expiredTotal, 2) }}</th>
                                <th style="text-align: right;">{{ number_format($expiredTotalDebt, 2) }}</th>
                            </tr>
                        </tfoot>

                    </table>

                </solid-box>
            @endif
        </div>
    </div>

@endsection

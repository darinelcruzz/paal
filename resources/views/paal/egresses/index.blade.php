@extends('paal.root')

@push('pageTitle', 'Egresos')

@section('content')
    <div class="row">
        <div class="col-md-12">                
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::open(['method' => 'post', 'route' => 'paal.egress.index']) !!}
                            <div class="input-group input-group-sm">
                                <input type="month" name="date" class="form-control" value="{{ $date }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

            <br>
                <solid-box title="EGRESOS" color="primary" button>
                    <table class="table table-striped table-bordered spanish">

                        <thead>
                            <tr>
                                <th style="width: 10%;"><small>EMISIÓN</small></th>
                                <th style="width: 10%;"><small>VENCIMIENTO</small></th>
                                <th style="width: 5%;"><i class="fa fa-cogs"></i></th>
                                <th style="width: 10%;"><small>FOLIO</small></th>
                                <th style="width: 8%;"><small>TIPO</small></th>
                                <th style="width: 8%;"><small>ESTADO</small></th>
                                <th><small>PROVEEDOR</small></th>
                                <th style="text-align: right;width: 10%;"><small>I.V.A.</small></th>
                                <th style="text-align: right;"><small>IMPORTE</small></th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($checks as $check)
                            <tr>
                                <td><small>{{ strtoupper(fdate($check->charged_at, 'd M Y', 'Y-m-d')) }}</small></td>
                                <td><small>{{ strtoupper(fdate($check->charged_at, 'd M Y', 'Y-m-d')) }}</small></td>
                                <td>
                                    <dropdown color="success" icon="cogs">
                                        <ddi to="{{ Storage::url($check->pdf) }}" icon="file-pdf" text="Ver factura" target="_blank"></ddi>
                                        <ddi to="{{ route('paal.check.show', $check) }}" icon="eye" text="Detalles"></ddi>
                                    </dropdown>
                                </td>
                                <td>CH {{ $check->folio }}</td>
                                <td>CHEQUE</td>
                                <td>
                                    <span class="label label-success"><small>PAGADO</small></span>
                                </td>
                                <td>CAJA CHICA</td>
                                <td style="text-align: right;">
                                    @if($egress->iva_type)<span class="label label-default">{{ $egress->iva_type }}</span>@endif
                                    {{ number_format($check->iva, 2) }}
                                </td>
                                <td style="text-align: right;">{{ number_format($check->total, 2) }}</td>
                            </tr>
                        @endforeach

                        @foreach($egresses as $egress)
                            <tr>
                                {{-- <td>
                                    @foreach($egress->payments as $payment)
                                        <small>{{ strtoupper(fdate($payment->paid_at, 'd M Y', 'Y-m-d')) }} - {{ $payment->folio }}</small> 
                                        @if(!$loop->last)
                                        <br>
                                        @endif
                                    @endforeach
                                </td> --}}
                                <td><small>{{ strtoupper(fdate($egress->emission, 'd M Y', 'Y-m-d')) }}</small></td>
                                <td><small>{{ strtoupper(fdate($egress->expiration, 'd M Y', 'Y-m-d')) }}</small></td>
                                <td>
                                    @include('paal.egresses._dropdown', ['color' => 'primary'])
                                </td>
                                <td>{{ $egress->folio }}</td>
                                <td style="text-align: center;">
                                    @if($egress->type)
                                        <span class="label label-{{ $egress->type == 'no equipo' ? 'info': ($egress->type == 'publicidad' ? 'default' :'primary') }}">
                                            <small>{{ strtoupper($egress->type) }}</small>
                                        </span>
                                    @elseif($egress->coffee > 0)
                                        <span class="label label-default"><small>PARCIAL</small></span>
                                    @else
                                        <span class="label label-default"><small>MBE</small></span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <span class="label label-{{ $egress->status == 'pagado' ? 'success' : ($egress->status == 'pendiente' ? 'warning': 'danger') }}"><small>{{ strtoupper($egress->status) }}</small></span>
                                </td>
                                <td>
                                    {{ $egress->provider_name ?? $egress->provider->name }}
                                    <code>{{ $egress->provider->rfc }}</code>
                                </td>
                                <td style="text-align: right;">
                                    @if($egress->iva_type)<span class="label label-default">{{ $egress->iva_type }}</span>@endif
                                    {{ number_format($egress->iva, 2) }}
                                </td>
                                <td style="text-align: right;">
                                    @if($egress->provider->type == 'pd')
                                        {{ number_format($egress->coffee, 2) }}
                                    @else
                                        {{ number_format($egress->amount, 2) }}
                                    @endif
                                </td>
                            </tr>
                            {{-- @php
                                if($egress->provider->type == 'pd') {
                                    $paidTotal += $egress->mbe;
                                }
                                else {
                                    $paidTotal += $egress->amount;
                                }
                            @endphp --}}
                        @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="7"></th>
                                <th style="text-align: right;"><span class="label label-danger"><small>VENCIDO</small></span></th>
                                <th style="text-align: right;">{{ number_format($egresses->sum(function ($egress) { return $egress->status == 'vencido' ? $egress->amount: 0;}), 2) }}</th>
                            </tr>
                            <tr>
                                <th colspan="7"></th>
                                <th style="text-align: right;"><span class="label label-warning"><small>PENDIENTE</small></span></th>
                                <th style="text-align: right;">{{ number_format($egresses->sum(function ($egress) { return $egress->status == 'pendiente' ? $egress->amount: 0;}), 2) }}</th>
                            </tr>
                            <tr>
                                <th colspan="7"></th>
                                <th style="text-align: right;"><span class="label label-success"><small>PAGADO</small></span></th>
                                <th style="text-align: right;">{{ number_format($egresses->sum(function ($egress) { return $egress->status == 'pagado' ? $egress->amount: 0;}) + $checks->sum('total'), 2) }}</th>
                            </tr>
                            <tr>
                                <th colspan="7"></th>
                                <th style="text-align: right;"><small>TOTAL</small></th>
                                <th style="text-align: right;">{{ number_format($egresses->sum('amount') + $checks->sum('total'), 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>

                </solid-box>
        </div>
    </div>

@endsection

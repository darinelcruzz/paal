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
                    <div class="col-md-3">
                        <button type="button" class="btn btn-success btn-flat btn-block">
                            PAGADO | {{ number_format($egresses->sum(function ($egress) { return $egress->status == 'pagado' ? $egress->amount: 0;}) + $checks->sum('total'), 2) }}
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-warning btn-flat btn-block">
                            PENDIENTE | {{ number_format($egresses->sum(function ($egress) { return $egress->status == 'pendiente' ? $egress->amount: 0;}), 2) }}
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger btn-flat btn-block">
                            VENCIDO | {{ number_format($egresses->sum(function ($egress) { return $egress->status == 'vencido' ? $egress->amount: 0;}), 2) }}
                        </button>
                    </div>
                </div>

            <br>
                <solid-box title="EGRESOS" color="primary" button>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered spanish">

                            <thead>
                                <tr>
                                    <th colspan="10"></th>
                                    <th style="text-align: center;width: 20%;" colspan="2"><small>I.V.A.</small></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th style="width: 5%;"><small>ID</small></th>
                                    <th style="width: 5%;"><i class="fa fa-cogs"></i></th>
                                    <th style="width: 10%;"><small>EMISIÓN</small></th>
                                    <th style="width: 10%;"><small>VENCIMIENTO</small></th>
                                    <th style="width: 5%;"><small>FOLIO</small></th>
                                    <th><small>PROVEEDOR</small></th>
                                    <th style="width: 8%;"><small>CLASE</small></th>
                                    <th style="width: 8%;"><small>GRUPO</small></th>
                                    <th style="width: 8%;"><small>EMPRESA</small></th>
                                    <th style="width: 5%;"><small>ESTADO</small></th>
                                    <th style="text-align: right;width: 5%;"><small>%</small></th>
                                    <th style="text-align: right;width: 8%;"><small>MONTO</small></th>
                                    <th style="text-align: right;width: 10%;"><small>IMPORTE</small></th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($checks as $check)
                                <tr>
                                    <td><small>{{ $check->id }}</small></td>
                                    <td>
                                        <dropdown color="primary" icon="cogs">
                                            <ddi to="{{ Storage::url($check->pdf) }}" icon="file-pdf" text="Ver factura" target="_blank"></ddi>
                                            <ddi to="{{ route('paal.check.show', $check) }}" icon="eye" text="Detalles"></ddi>
                                        </dropdown>
                                    </td>
                                    <td><small>{{ strtoupper(fdate($check->charged_at, 'd M Y', 'Y-m-d')) }}</small></td>
                                    <td><small>{{ strtoupper(fdate($check->charged_at, 'd M Y', 'Y-m-d')) }}</small></td>
                                    <td>{{ $check->folio }}</td>
                                    <td>
                                        @foreach($check->egresses as $egress)
                                        <small>{{ strtoupper($egress->provider->name) }}</small> @if($loop->last) <br> @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="label label-danger">
                                            <small>CAJA CHICA</small>
                                        </span>
                                    </td>
                                    <td>{{ $check->egress->group->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="label label-{{ $check->company == 'coffee' ? 'warning' : 'primary' }}">
                                            {{ $check->company == 'coffee' ? 'COCINAS' : 'LOGÍSTICA' }}
                                        </span>
                                    </td>
                                    <td><span class="label label-success"><small>PAGADO</small></span></td>
                                    <td style="text-align: center;">
                                        @if($check->egress->iva_type ?? false)
                                            <span class="label label-default">{{ $egress->iva_type }}</span>
                                        @else
                                            <code>N/A</code>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">{{ number_format($check->iva, 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($check->total, 2) }}</td>
                                </tr>
                            @endforeach

                            @foreach($egresses as $egress)
                                <tr>
                                    <td><small>{{ $egress->id }}</small></td>
                                    <td>
                                        @include('paal.egresses._dropdown', ['color' => 'primary'])
                                    </td>
                                    <td><small>{{ strtoupper(fdate($egress->emission, 'd M Y', 'Y-m-d')) }}</small></td>
                                    <td><small>{{ strtoupper(fdate($egress->expiration, 'd M Y', 'Y-m-d')) }}</small></td>
                                    <td>{{ $egress->folio }}</td>
                                    <td>
                                        {{ $egress->provider_name ?? $egress->provider->name }}
                                        <code>{{ $egress->provider->rfc }}</code>
                                    </td>
                                    <td>
                                        <span class="label label-{{ $egress->categoryColor }}">
                                            <small>{{ $egress->category->name ?? '...' }}</small>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="label label-{{ $egress->groupColor }}">
                                            <small>{{ $egress->group->name ?? '...' }}</small>
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        @if($egress->type)
                                            <span class="label label-{{ $egress->type == 'varios' ? 'info': ($egress->type == 'publicidad' ? 'default' :'primary') }}">
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
                                    <td style="text-align: center;">
                                        @if($egress->iva_type)
                                            <span class="label label-default">{{ $egress->iva_type }}</span>
                                        @else
                                            <code>N/A</code>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">{{ number_format($egress->iva, 2) }}</td>
                                    <td style="text-align: right;">
                                        @if($egress->provider->type == 'pd')
                                            {{ number_format($egress->coffee, 2) }}
                                        @else
                                            {{ number_format($egress->amount, 2) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </solid-box>
        </div>
    </div>

@endsection

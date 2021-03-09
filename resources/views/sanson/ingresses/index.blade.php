@extends('sanson.root')

@push('pageTitle', 'Ventas | Historial')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['method' => 'post', 'route' => 'sanson.ingress.index']) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}

            <br>

            <solid-box title="Ventas" color="info">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered spanish-simple">
                        <thead>
                            <tr>
                                <th style="text-align: center;"><small>FOLIO</small></th>
                                <th style="text-align: center;"><i class="fa fa-cogs"></i></th>
                                <th><small>FECHA</small></th>
                                <th><small>CLIENTE</small></th>
                                <th style="text-align: center;"><small>TIPO</small></th>
                                <th style="text-align: right;"><small>IVA</small></th>
                                <th style="text-align: right;"><small>IMPORTE</small></th>
                                <th style="text-align: center;"><small>MÉTODO</small></th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td style="text-align: center;">
                                    {{ $ingress->folio }}
                                    @if($ingress->quotation_id != null)
                                        <br>
                                        <code><small>COT {{ $ingress->quotation_id }}</small></code>
                                    @endif
                                    @if($ingress->type != 'anticipo')
                                    @foreach($ingress->retainers as $retainer)
                                        @if($loop->index == 0) <code style="color: blue"><br>@endif
                                        <small>{{ $retainer->folio }}</small>
                                        @if($loop->last) </code> @endif
                                    @endforeach
                                    
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <dropdown icon="cogs" color="info">
                                        <ddi v-if="{{ $ingress->status == 'pagado' || $ingress->status == 'cancelado' ? 0: 1 }}" to="{{ route('sanson.payment.create', $ingress) }}" icon="money" text="Pagar"></ddi>
                                        @if($ingress->type != 'anticipo')
                                        <li>
                                            <a data-toggle="modal" data-target="#ingress-modal" v-on:click="upmodel({{ $ingress->toJson() }})">
                                                <i class="fa fa-eye" aria-hidden="true"></i> Detalles
                                            </a>
                                        </li>
                                        @endif
                                        <li>
                                            <a href="{{ route('sanson.ingress.ticket', $ingress) }}" target="_blank">
                                                <i class="fa fa-print" aria-hidden="true"></i> Imprimir
                                            </a>
                                        </li>
                                        @if ($ingress->status != 'cancelado')
                                            <li>
                                                <a class="deleteThisObject" idInstance="{{ $ingress->id }}" route="ingresos">
                                                    <i class="fa fa-ban" aria-hidden="true"></i> Cancelar
                                                </a>
                                            </li>
                                        @endif
                                    </dropdown>
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd/m/Y', 'Y-m-d') }}</td>
                                <td style="width: 30%">
                                    {{ $ingress->quotation_id != null ? ($ingress->quotation->client_name ?? $ingress->quotation->client->name ) : $ingress->client->name }}
                                    @if($ingress->quotation)
                                    <span class="{{ $ingress->quotation->internet_type == '' ? '': 'badge bg-aqua' }} pull-right"><em>{{ $ingress->quotation->internet_type }}</em></span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($ingress->status == 'cancelado')
                                        <label class="label label-default">CANCELADO</label>
                                    @else
                                        <label class="label label-{{$ingress->typeLabel }}">{{ strtoupper($ingress->type) }}</label>
                                    @endif
                                </td>
                                <td style="text-align: right;">{{ number_format($ingress->iva, 2) }}</td>
                                <td style="text-align: right;">
                                    {{ number_format($ingress->amount, 2) }}
                                    @if($ingress->type == 'anticipo')
                                        <br>
                                        <small><em>p.p.</em> {{ number_format($ingress->debt - $ingress->amount, 2) }}</small>
                                    @else
                                        @if($ingress->retainers->sum('amount') > 0 && $ingress->type != 'nota de crédito')
                                            <br>
                                            <small>(-{{ number_format($ingress->retainers->sum('amount'), 2) }})</small>
                                        @endif
                                    @endif
                                </td>
                                <td style="text-align: center;"><small>{{ strtoupper($ingress->pay_method) }}</small></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </solid-box>
            
            <modal title="Productos" color="info" id="ingress-modal">
                <movements :model="model"></movements>
            </modal>

        </div>
    </div>


@endsection

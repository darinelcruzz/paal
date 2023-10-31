@extends('coffee.root')

@push('pageTitle', 'Ventas | Historial')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['method' => 'post', 'route' => 'coffee.ingress.index']) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}

            <br>

            <solid-box title="Ventas" color="warning">

                <div class="table-responsive">

                <table class="table table-striped table-bordered spanish-simple">
                    <thead>
                        <tr>
                            <th style="text-align: center;"><small>FOLIO</small></th>
                            <th style="text-align: center;"><i class="fa fa-cogs"></i></th>
                            <th><small>FECHA</small></th>
                            <th><small>CLIENTE</small></th>
                            <th style="text-align: center;width: 5%;"><small>CFDI</small></th>
                            <th style="text-align: center;width: 5%;"><small>TIPO</small></th>
                            <th style="text-align: right;"><small>SUBTOTAL</small></th>
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
                                    <dropdown icon="cogs" color="warning">
                                        <ddi v-if="{{ $ingress->status == 'pagado' || $ingress->status == 'cancelado' ? 0: 1 }}" to="{{ route('coffee.payment.create', $ingress) }}" icon="money" text="Pagar"></ddi>
                                        <li>
                                            <a data-toggle="modal" data-target="#ingress-modal" v-on:click="upmodel({{ $ingress->toJson() }})">
                                                <i class="fa fa-eye" aria-hidden="true"></i> Detalles
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('coffee.ingress.ticket', $ingress) }}" target="_blank">
                                                <i class="fa fa-print" aria-hidden="true"></i> Imprimir
                                            </a>
                                        </li>
                                        @if ($ingress->client_id != 532 && $ingress->sae == null)
                                            <li>
                                                <a data-toggle="modal" data-target="#sae-modal-{{ $ingress->id }}">
                                                    <i class="fa fa-barcode" aria-hidden="true"></i> SAE
                                                </a>
                                            </li>
                                        @endif
                                        @if(auth()->user()->level < 3)
                                            <ddi to="{{ route('coffee.payment.edit', $ingress) }}" icon="edit" text="Editar"></ddi>                                        
                                        @endif
                                        @if ($ingress->status != 'cancelado')
                                            <li>
                                                <a class="deleteThisObject" idInstance="{{ $ingress->id }}" route="ingresos">
                                                    <i class="fa fa-ban" aria-hidden="true"></i> Cancelar
                                                </a>
                                            </li>
                                        @endif
                                    </dropdown>

                                    <modal title="Venta {{ $ingress->folio }}" color="warning" id="sae-modal-{{ $ingress->id }}">
                                        {!! Form::open(['method' => 'POST', 'route' => ['coffee.ingress.updateSAE', $ingress]]) !!}
                                        
                                            {!! Field::text('sae', ['label' => 'Folio', 'tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                                            <button type="submit" class="btn btn-sm btn-warning pull-right">AGREGAR</button>

                                        {!! Form::close() !!}
                                    </modal>
                                </td>
                                <td>{{ date('d/m/y', strtotime($ingress->bought_at)) }}</td>
                                <td style="width: 30%">
                                    <a href="{{ route('coffee.client.show', [$ingress->client, 'ventas']) }}" target="_blank">
                                        {{ $ingress->quotation->client_name ?? $ingress->client->name }}
                                    </a>
                                    @if($ingress->client_id == 532)
                                    <code><i class="fa fa-circle"></i></code>
                                    @elseif($ingress->sae != null)
                                    <label class="label label-success" title="{{ $ingress->sae }}">
                                        <small>SAE</small>
                                    </label>
                                    @endif
                                    @if($ingress->quotation)
                                    <span class="{{ $ingress->quotation->internet_type == '' ? '': 'badge bg-aqua' }} pull-right"><em>{{ $ingress->quotation->internet_type }}</em></span>
                                    @endif                                    
                                </td>
                                <td style="text-align: center;">
                                    <label class="label label-default">
                                        <small>{{ $ingress->invoice != 'no' ? $ingress->invoice: 'n/a' }}</small>
                                    </label>
                                </td>
                                <td style="text-align: center;">
                                    @if($ingress->status == 'cancelado')
                                        <label class="label label-default">CANCELADO</label>
                                    @else
                                        <label class="label label-{{ $ingress->type == 'varios' ? 'warning': 'danger'}}">
                                            {{ strtoupper($ingress->type) }}
                                        </label>
                                    @endif
                                </td>
                                <td style="text-align: right;">{{ number_format($ingress->amount - $ingress->iva, 2) }}</td>
                                <td style="text-align: right;">{{ $ingress->iva > 0 ? number_format($ingress->iva, 2): '...' }}</td>
                                <td style="text-align: right;">
                                    {{ number_format($ingress->amount, 2) }}
                                    @if($ingress->type == 'anticipo')
                                        <br>
                                        {{-- <small><em>p.p.</em> {{ number_format($ingress->debt - $ingress->amount, 2) }}</small> --}}
                                        <small style="color: gray"><em>p.p.</em> {{ number_format($ingress->quotation->amount - $ingress->quotation->retainers->sum('amount'), 2) }}</small>
                                    @else
                                        @if($ingress->retainers->sum('amount') > 0 && $ingress->type != 'nota de crédito')
                                            <br>
                                            <small>(-{{ number_format($ingress->retainers->sum('amount'), 2) }})</small>
                                        @endif
                                    @endif
                                </td>
                                <td style="text-align: center;"><small>{{ strtoupper($ingress->method) }}</small></td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="4"><small>TOTALES</small></th>
                            <td>V: {{ number_format($ingresses->where('type', 'varios')->sum('amount'), 2) }}</td>
                            <td>E: {{ number_format($ingresses->where('type', 'equipo')->sum('amount'), 2) }}</td>
                            <td>P: {{ number_format($ingresses->where('type', 'proyecto')->sum('amount'), 2) }}</td>
                            <td>A: {{ number_format($ingresses->where('type', 'anticipo')->sum('amount'), 2) }}</td>
                            <td>N: {{ number_format($ingresses->where('type', 'nota de crédito')->sum('amount'), 2) }}</td>
                            <td>C: {{ number_format($ingresses->where('type', 'cancelado')->sum('amount'), 2) }}</td>
                        </tr>
                    </tfoot>

                </table>
                </div>

            </solid-box>

            <modal :title="model.folio ?? ''" color="warning" id="ingress-modal">
                <movements :model="model" type="ingress"></movements>
            </modal>
        </div>
    </div>

@endsection

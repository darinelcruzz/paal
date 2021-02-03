@extends('coffee.root')

@push('pageTitle', 'Ventas | Historial')

@push('headerTitle')
    
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['method' => 'post', 'route' => 'coffee.ingress.index']) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        {{-- {!! Field::date('date', $date, ['label' => 'Seleccione fecha', 'tpl' => 'withicon'], ['icon' => 'calendar']) !!} --}}
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}

            <br>

            <solid-box title="Ventas" color="danger">

                <data-table example="1">

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>','fecha', 'cliente', 'tipo', 'IVA', 'total', 'método', 'estado') }}

                    <template slot="body">
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td style="text-align: center;">
                                    {{ $ingress->folio }}
                                    @if($ingress->areSerialNumbersMissing)
                                        <i class="fa fa-exclamation-circle" style="color: #f39c12;"></i>
                                    @endif
                                    @if($ingress->quotation_id != null)
                                        <br>
                                        <a href="{{ route('coffee.quotation.show', $ingress->quotation_id) }}">
                                            <code>
                                                <small>COT {{ $ingress->quotation_id }}</small>
                                            </code>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <dropdown icon="cogs" color="danger">
                                        <ddi v-if="{{ $ingress->status == 'pagado' || $ingress->status == 'cancelado' ? 0: 1 }}" to="{{ route('coffee.payment.create', $ingress) }}" icon="money" text="Pagar"></ddi>
                                        <ddi to="{{ route('coffee.ingress.show', $ingress) }}" icon="eye" text="Detalles"></ddi>
                                        <li>
                                            <a href="{{ route('coffee.ingress.ticket', $ingress) }}" target="_blank">
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
                                        @if ($ingress->areSerialNumbersMissing)
                                            <ddi to="{{ route('coffee.ingress.update', $ingress) }}" icon="plus" text="Agregar # de serie"></ddi>
                                        @endif

                                    </dropdown>
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd/M/y', 'Y-m-d') }}</td>
                                <td style="width: 30%">
                                    {{ $ingress->client_name ?? $ingress->client->name }}
                                    @if($ingress->quotation)
                                    <span class="{{ $ingress->quotation->internet_type == '' ? '': 'badge bg-aqua' }} pull-right"><em>{{ $ingress->quotation->internet_type }}</em></span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <label class="label label-{{$ingress->typeLabel }}">{{ strtoupper($ingress->type) }}</label>
                                </td>
                                <td style="text-align: right;">{{ number_format($ingress->iva, 2) }}</td>
                                <td style="text-align: right;">{{ number_format($ingress->amount, 2) }}</td>
                                <td style="text-align: center;"><small>{{ strtoupper($ingress->method) }}</small></td>
                                <td style="text-align: center;">
                                    @if ($ingress->status == 'cancelado')
                                        <a type="button" class="label label-danger" data-toggle="modal" data-target="#modal-cancelation-{{$ingress->id}}">
                                            {{ ucfirst($ingress->status) }}
                                        </a>

                                        <div class="modal modal-danger fade" id="modal-cancelation-{{$ingress->id}}">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Razones de la cancelación</h4>
                                              </div>
                                              <div class="modal-body">
                                                    {{ $ingress->canceled_for }}
                                              </div>
                                          </div>
                                        </div>
                                    @else
                                        <span class="label label-{{ $ingress->statusColor }}">
                                            {{ strtoupper($ingress->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </template>

                </data-table>

            </solid-box>
        </div>
    </div>

    @include('sweet::alert')

@endsection

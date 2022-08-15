@extends('paal.root')

@push('pageTitle', 'Ingresos | Historial')

@section('content')
    <div class="row">
        <div class="col-md-12">
                
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::open(['method' => 'post', 'route' => ['paal.ingress.index', $company]]) !!}
                            <div class="input-group input-group-sm">
                                <input type="month" name="date" class="form-control" value="{{ $date }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-{{ $company == 'mbe' ? 'success': 'danger'}} btn-flat">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        {!! Form::close() !!}
                    </div>
                    
                    <div class="col-md-3 pull-right">
                        <a href="{{ route('paal.ingress.index') }}" class="btn btn-sm btn-danger">COFFEE DEPOT</a>
                        <a href="{{ route('paal.ingress.index', 'mbe') }}" class="btn btn-sm btn-success">MAILBOXES</a>
                    </div>
                </div>


            <br>

            <solid-box title="Ingresos" color="{{ $company == 'mbe' ? 'success': 'danger'}}">

                @if($company == 'mbe')

                <data-table classes="spanish-simple">

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>','fecha venta', 'cliente', 'IVA', 'total', 'método', 'estado') }}

                    <template slot="body">
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td>{{ $ingress->folio }}</td>
                                <td>
                                    <dropdown icon="cogs" color="{{ $company == 'mbe' ? 'success': 'danger'}}">
                                        @if ($ingress->status != 'cancelado')
                                            <li>
                                                <a class="deleteThisObject" idInstance="{{ $ingress->id }}" route="ingresos">
                                                    <i class="fa fa-ban" aria-hidden="true"></i> Cancelar
                                                </a>
                                            </li>
                                        @endif
                                    </dropdown>
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td style="width: 30%">{{ $ingress->client->name }}</td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                                <td>{{ ucfirst($ingress->type) }}</td>
                                <td>
                                    <span class="label label-{{ $ingress->statusColor }}">
                                        {{ ucfirst($ingress->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </template>

                </data-table>

                @else

                <data-table example="1">

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>','fecha venta', 'cliente', 'tipo', 'IVA', 'total', 'método', 'estado') }}

                    <template slot="body">
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td>{{ $ingress->folio }}</td>
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

                                    </dropdown>
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td style="width: 30%">{{ $ingress->client->name }}</td>
                                <td>
                                    <label class="label label-{{$ingress->type == 'insumos' ? 'danger': 'warning'}}">{{ strtoupper($ingress->type) }}</label>
                                </td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                                <td>{{ $ingress->method_name }}</td>
                                <td>
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
                                            {{ ucfirst($ingress->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </template>

                </data-table>

                @endif

            </solid-box>
        </div>
    </div>

@endsection

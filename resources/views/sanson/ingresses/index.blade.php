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
                    <table class="table table-striped table-bordered spanish">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><i class="fa fa-cogs"></i></th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>IVA</th>
                                <th>Total</th>
                                <th>Anticipo</th>
                                <th>Método</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td>{{ $ingress->folio }}</td>
                                <td>
                                    <dropdown icon="cogs" color="info">
                                        <ddi v-if="{{ $ingress->status == 'pagado' || $ingress->status == 'cancelado' ? 0: 1 }}" to="{{ route('sanson.payment.create', $ingress) }}" icon="money" text="Pagar"></ddi>
                                        <ddi to="{{ route('sanson.ingress.show', $ingress) }}" icon="eye" text="Detalles"></ddi>
                                        <ddi to="{{ route('sanson.ingress.ticket', $ingress) }}" icon="print" text="Imprimir" target="_blank"></ddi>
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
                                <td style="width: 30%">{{ $ingress->client->name }}</td>
                                <td>
                                    <label class="label label-{{$ingress->type == 'equipo' ? 'info': 'primary'}}">
                                        {{ strtoupper($ingress->type) }}
                                    </label>
                                </td>
                                <td style="text-align: right">{{ number_format($ingress->iva, 2) }}</td>
                                <td style="text-align: right">{{ number_format($ingress->amount, 2) }}</td>
                                <td style="text-align: center">{{ number_format($ingress->retainer, 2) }}</td>
                                <td>{{ ucfirst($ingress->method) }}</td>
                                <td>
                                    @if ($ingress->status == 'cancelado')
                                        <a type="button" class="label label-danger" data-toggle="modal" data-target="#modal-cancelation-{{$ingress->id}}">
                                            {{ ucfirst($ingress->status) }}
                                        </a>

                                        <div class="modal modal-info fade" id="modal-cancelation-{{$ingress->id}}">
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
                        </tbody>
                    </table>
                </div>
            </solid-box>
        </div>
    </div>

    @include('sweet::alert')

@endsection

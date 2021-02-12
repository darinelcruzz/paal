@extends('coffee.root')

@push('pageTitle', 'Anticipos | Historial')

@push('headerTitle')

    <div class="row">
        <div class="col-md-3">
            <a href="{{ route('coffee.retainer.create') }}" class="btn btn-danger btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-3">
            {!! Form::open(['method' => 'post', 'route' => 'coffee.retainer.index']) !!}
            <div class="input-group input-group-sm pull-right">
                <input type="month" name="date" class="form-control" value="{{ $date ?? date('Y-m') }}">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Anticipos" color="danger">
                <table class="table table-striped table-bordered table-hover spanish-simple">
                    <thead>
                        <tr>
                            <th style="text-align: center;"><small>FOLIO</small></th>
                            <th><i class="fa fa-cogs"></i></th>
                            <th><small>FECHA</small></th>
                            <th><small>CLIENTE</small></th>
                            <th style="text-align: center;"><small>MÉTODO</small></th>
                            <th style="text-align: center;"><small>ESTADO</small></th>
                            <th style="text-align: right;"><small>IMPORTE</small></th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($retainers as $retainer)
                        <tr>
                            <td style="text-align: center;">{{ $retainer->folio }}</td>
                            <td>
                                <dropdown icon="cogs" color="danger">
                                    <li>
                                        <a href="{{ route('coffee.retainer.show', $retainer) }}" target="_blank">
                                            <i class="fa fa-print" aria-hidden="true"></i><small>Imprimir</small>
                                        </a>
                                    </li>
                                    <ddi icon="usd" to="{{ route('coffee.retainer.deposit', $retainer) }}" text="Sumar abono"></ddi>
                                    <ddi icon="shopping-cart" to="{{ route('coffee.retainer.transform', $retainer) }}" text="Crear venta"></ddi>
                                </dropdown>
                            </td>
                            <td>{{ fdate($retainer->retained_at, 'd/M/y', 'Y-m-d') }}</td>
                            <td style="width: 30%">{{ $retainer->client_name ?? $retainer->client->name }}</td>
                            <td style="text-align: center;">
                                <span class="label label-{{ $retainer->method == 'efectivo' ? 'success': 'primary' }}">
                                    {{ strtoupper($retainer->method) }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <span class="label label-{{ $retainer->status == 'pendiente' ? 'warning': 'success' }}">
                                    {{ strtoupper($retainer->status) }}
                                </span>
                            </td>
                            <td style="text-align: right;">{{ number_format($retainer->amount, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </solid-box>
        </div>
    </div>

@endsection

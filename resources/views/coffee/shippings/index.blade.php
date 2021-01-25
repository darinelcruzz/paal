@extends('coffee.root')

@push('pageTitle', 'Envíos | Lista')

@section('content')

    <div class="row">
        <div class="col-md-9">
            <a href="{{ route('coffee.shipping.index', 'todos') }}" class="btn btn-primary">TODOS</a>
            <a href="{{ route('coffee.shipping.index', 'pendiente') }}" class="btn btn-default">PENDIENTES</a>
            <a href="{{ route('coffee.shipping.index', 'en tránsito') }}" class="btn btn-warning">TRÁNSITO</a>
            <a href="{{ route('coffee.shipping.index', 'entregado') }}" class="btn btn-success">ENTREGADO</a>
            <a href="{{ route('coffee.shipping.index', 'cancelado') }}" class="btn btn-danger">INCIDENCIA</a>
        </div>
        <div class="col-md-3 pull-right">
            {!! Form::open(['method' => 'post', 'route' => ['coffee.shipping.index', $status]]) !!}
                <div class="input-group input-group-sm">
                    <input type="month" name="date" class="form-control" value="{{ $date }}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">

            <solid-box title="Envíos" color="danger">
                
                <table class="table table-bordered table-striped spanish">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Venta</th>
                            <th><i class="fa fa-cogs"></i></th>
                            <th>Cliente</th>
                            <th>Dirección</th>
                            <th>Envío</th>
                            <th>Entrega</th>
                            <th>Paquetería</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($shippings as $shipping)
                            <tr>
                                <td>{{ $shipping->id }}</td>
                                <td>{{ $shipping->ingress->folio }}</td>
                                <td>
                                    <dropdown color="danger" icon="cogs">
                                        @if (!$shipping->guide_number)
                                            <ddi icon="plus" to="{{ route('coffee.shipping.addInfo', $shipping) }}" text="Número de guía"></ddi>
                                        @elseif($shipping->guide_number && $shipping->status != 'entregado')
                                            <ddi icon="check" to="{{ route('coffee.shipping.edit', $shipping) }}" text="Entregado"></ddi>
                                        @endif
                                        <li>
                                            <a href="{{ route('coffee.shipping.print', $shipping) }}" target="_blank">
                                                <i class="fa fa-print"></i> Rótulo
                                            </a>
                                        </li>
                                    </dropdown>
                                </td>
                                <td style="width: 20%">
                                    {{ $shipping->ingress->client->name }}
                                    @if($shipping->address) <br> <b>{{ $shipping->address->business_name }}</b> @endif
                                </td>
                                <td>
                                    {{ $shipping->address->full_address or 'No se proporcionó' }}
                                    @if($shipping->address) <br> <code>REF: {{ $shipping->address->reference }}</code> @endif
                                </td>
                                <td>
                                    {{ fdate($shipping->shipped_at, 'd/m/Y', 'Y-m-d') }} <br>
                                </td>
                                <td>
                                    {{ fdate($shipping->delivered_at, 'd/m/Y', 'Y-m-d') }}
                                </td>
                                <td>
                                    <small>{{ strtoupper($shipping->company) }}</small>
                                    <code>{{ $shipping->guide_number }}</code>
                                </td>
                                <td>
                                    <span class="label label-{{ $shipping->color }}">
                                        <small>{{ strtoupper($shipping->status) }}</small>
                                    </span>
                                </td>
                                <td>{{ $shipping->observations }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>

            </solid-box>
        </div>
    </div>

@endsection
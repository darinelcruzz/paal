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
                        <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">

            <solid-box title="Envíos" color="warning">
                
                <table class="table table-bordered table-striped spanish">

                    <thead>
                        <tr>
                            <th><small>ID</small></th>
                            <th><i class="fa fa-cogs"></i></th>
                            <th><small>VENTA</small></th>
                            <th><small>CLIENTE</small></th>
                            <th><small>CONTACTO</small></th>
                            <th><small>DIRECCIÓN</small></th>
                            <th><small>ENVÍO</small></th>
                            <th><small>ENTREGA</small></th>
                            <th><small>PAQUETERÍA</small></th>
                            <th><small>COSTO</small></th>
                            <th><small>ESTADO</small></th>
                            <th><small>OBSERVACIONES</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($shippings as $shipping)
                            <tr>
                                <td>{{ $shipping->id }}</td>
                                <td>
                                    <dropdown color="warning" icon="cogs">
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
                                <td>{{ $shipping->ingress->folio }}</td>
                                <td style="width: 20%">
                                    {{ $shipping->ingress->client->name }}
                                    @if($shipping->address) <br> <b>{{ $shipping->address->business_name }}</b> @endif
                                </td>
                                <td>
                                    @if($shipping->address)
                                        {{ $shipping->address->contact }} <br>
                                        {{ $shipping->address->phone }}
                                    @endif
                                </td>
                                <td>
                                    {{ $shipping->address->full_address ?? 'No se proporcionó' }}
                                    @if($shipping->address) <br> <code>REF: {{ $shipping->address->reference }}</code> @endif
                                </td>
                                <td>
                                    {{ $shipping->shipped_at ? date('d/m/Y', strtotime($shipping->shipped_at)): '...' }}
                                </td>
                                <td>
                                    {{ $shipping->delivered_at ? date('d/m/Y', strtotime($shipping->delivered_at)): '...' }}
                                </td>
                                <td style="text-align: center;">
                                    @if($shipping->company == 'estafeta')
                                        <a href="#"><small>{{ strtoupper($shipping->company) }}</small></a><br>
                                    @else
                                        <small>{{ strtoupper($shipping->company) }}</small><br>
                                    @endif
                                    <code>{{ $shipping->guide_number }}</code>
                                </td>
                                <td style="text-align: right;">{{ number_format($shipping->ingress->shipping_cost, 2) }}</td>
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

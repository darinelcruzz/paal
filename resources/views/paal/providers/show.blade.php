@extends('paal.root')

@push('pageTitle', 'Proveedores | Detalle')

@push('headerTitle')
    <div class="row">
        <div class="col-md-6">
            <h4>{{ $provider->name }}</h4>
        </div>
        <div class="col-md-6">
            {!! Form::open(['method' => 'post', 'route' => ['paal.provider.show', $provider]]) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <input type="date" name="start" class="form-control" value="{{ request('start') ?? date('Y-m-d', time() - 60*60*24*31*3) }}">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat" disabled><i class="fa fa-angle-double-right"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <input type="date" name="end" class="form-control" value="{{ request('end') ?? date('Y-m-d') }}">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-9">
            <solid-box title="Compras (egresos)" color="primary">

                <div class="table-responsive">
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
                    @foreach($egresses as $egress)
                        <tr>
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
                    @endforeach
                    </tbody>
                </table>
                </div>
            </solid-box>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-green">
                <div class="inner">
                    <p>{{ $egresses->count() }} EN TOTAL</p>
                    <h3><em><small style="color: inherit;">{{ number_format($egresses->sum('amount'), 2) }}</small></em></h3>
                </div>
                <div class="icon">
                    <i class="fa fa-mug-hot"></i>
                </div>
            </div>
        </div>
    </div>

@endsection
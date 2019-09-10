@extends('mbe.root')

@push('pageTitle')
    Ingresos | Historial
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
                
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::open(['method' => 'post', 'route' => 'mbe.ingress.index']) !!}
                            <div class="input-group input-group-sm">
                                <input type="month" name="date" class="form-control" value="{{ $date }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-success btn-flat">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

            <br>

            <solid-box title="Ingresos" color="success">

                <data-table example="1">

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>','fecha venta', 'cliente', 'IVA', 'total', 'método', 'estado') }}

                    <template slot="body">
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td>{{ $ingress->folio }}</td>
                                <td>
                                    <dropdown icon="cogs" color="success">
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

            </solid-box>
        </div>
    </div>

    @include('sweet::alert')

@endsection

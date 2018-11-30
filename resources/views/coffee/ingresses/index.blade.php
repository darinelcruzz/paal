@extends('coffee.root')

@push('pageTitle')
    Ingresos
@endpush

@push('headerTitle')
    <a href="{{ route('coffee.ingress.create') }}" class="btn btn-danger btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Coffee" color="danger" button>

                <data-table example="1">

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>','fecha venta', 'cliente', 'IVA', 'total', 'método', 'estado') }}

                    <template slot="body">
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td>{{ $ingress->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="danger">
                                        <ddi v-if="{{ $ingress->status == 'pagado' ? 0: 1 }}" to="{{ route('paal.ingress.charge', $ingress) }}" icon="money" text="Pagar"></ddi>
                                        <ddi to="{{ route('paal.ingress.show', $ingress) }}" icon="eye" text="Detalles"></ddi>
                                    </dropdown>
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                                <td>{{ $ingress->status == 'pendiente' ? $ingress->retainer_method: $ingress->pay_form }} <br> {{ $ingress->operation_number }}</td>
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

@endsection
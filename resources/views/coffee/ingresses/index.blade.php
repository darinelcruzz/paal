@extends('coffee.root')

@push('pageTitle')
    Ingresos
@endpush

@push('headerTitle')
    
@endpush

@section('content')
    <div class="row">
        <div class="col-md-1">
            <a href="{{ route('coffee.ingress.create') }}" class="btn btn-danger btn-sm">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;<i class="fa fa-mug-hot fa-2x"></i>
            </a>
        </div>

        <div class="col-md-9">
            <solid-box title="Ventas" color="danger" button>

                <data-table example="1">

                    {{ drawHeader('folio', '<i class="fa fa-cogs"></i>','fecha venta', 'cliente', 'IVA', 'total', 'anticipo', 'estado') }}

                    <template slot="body">
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td>{{ $ingress->folio }}</td>
                                <td>
                                    <dropdown icon="cogs" color="danger">
                                        <ddi v-if="{{ $ingress->status == 'pagado' ? 0: 1 }}" to="{{ route('coffee.ingress.charge', $ingress) }}" icon="money" text="Pagar"></ddi>
                                        <ddi to="{{ route('coffee.ingress.show', $ingress) }}" icon="eye" text="Detalles"></ddi>
                                        <li>
                                            <a href="{{ route('coffee.ingress.ticket', $ingress) }}" target="_blank">
                                                <i class="fa fa-print" aria-hidden="true"></i> Imprimir
                                            </a>
                                        </li>
                                    </dropdown>
                                </td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                                <td>{{ $ingress->retainer > 0 ? "$ " . number_format($ingress->retainer, 2): '' }}</td>
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

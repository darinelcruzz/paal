@extends('mailboxes.root')

@push('pageTitle')
    Ingresos | Lista
@endpush

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <solid-box title="Ingresos" color="success" button>
                <a href="{{ route('mbe.ingress.create') }}" class="btn btn-success btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
                <br>
                <br>
                <data-table example="1">

                    {{ drawHeader('ID', 'cliente', 'compra', 'pago', 'I.V.A.', 'total', 'método', 'estado') }}

                    <template slot="body">
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td>{{ $ingress->id }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ fdate($ingress->paid_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                                <td>{{ $ingress->method_name }}</td>
                                <td><span class="label label-{{ $ingress->status_color }}">{{ strtoupper($ingress->status) }}</span></td>
                            </tr>
                        @endforeach
                    </template>

                </data-table>

            </solid-box>
        </div>
    </div>

@endsection

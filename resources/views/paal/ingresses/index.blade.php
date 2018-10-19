@extends('paal.root')

@push('pageTitle')
    Ingresos | Lista
@endpush

@push('headerTitle')
    <a href="{{ route('paal.ingress.create', ['company' => 'coffee']) }}" class="btn btn-danger btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR COFFEE</a>
    <a href="{{ route('paal.ingress.create', ['company' => 'mbe']) }}" class="btn btn-success btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR MBE</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Coffee" color="danger" button>

                <data-table example="1">

                    {{ drawHeader('ID', 'fecha venta', 'cliente', 'IVA', 'total', 'método', 'estado') }}

                    <template slot="body">
                        @foreach($coffee as $ingress)
                            <tr>
                                <td>{{ $ingress->id }}</td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                                <td>{{ $ingress->status == 'pendiente' ? $ingress->retainer_method: $ingress->pay_form }} <br> {{ $ingress->operation_number }}</td>
                                <td>
                                    <span class="label label-{{ $ingress->status != 'pendiente' ? 'success': 'danger'}}">
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
    <div class="row">
        <div class="col-md-12">
            <solid-box title="MBE" color="success" button>

                <data-table example="2">

                    {{ drawHeader('ID', 'fecha venta', 'cliente', 'IVA', 'total', 'método', 'estado') }}

                    <template slot="body">
                        @foreach($mbe as $ingress)
                            <tr>
                                <td>{{ $ingress->id }}</td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ $ingress->client->name }}</td>
                                <td>$ {{ number_format($ingress->iva, 2) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
                                <td>{{ $ingress->payForm }} <br> {{ $ingress->operation_number }}</td>
                                <td>
                                    <span class="label label-{{ $ingress->status != 'pendiente' ? 'success': 'danger'}}">
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

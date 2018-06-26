@extends('paal.root')

@push('pageTitle')
    Ingresos | Lista
@endpush

@push('headerTitle')
    <a href="{{ route('paal.ingress.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Ingresos" color="primary" button>
                
                <data-table example="1">

                    {{ drawHeader('ID', 'fecha', 'empresa', 'total', 'estado') }}

                    <template slot="body">
                        @foreach($ingresses as $ingress)
                            <tr>
                                <td>{{ $ingress->id }}</td>
                                <td>{{ fdate($ingress->bought_at, 'd M Y', 'Y-m-d') }}</td>
                                <td>{{ strtoupper($ingress->company) }}</td>
                                <td>$ {{ number_format($ingress->amount, 2) }}</td>
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
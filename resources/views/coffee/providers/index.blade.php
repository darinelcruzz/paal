@extends('coffee.root')

@push('pageTitle')
    PAAL | Proveedores | Lista
@endpush

@push('headerTitle')
    Proveedores <small>LISTA</small>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="" color="danger" button>
                
                <data-table example="1">

                    {{ drawHeader('id', 'proveedor', 'R.F.C', 'dirección', 'correo', 'teléfono') }}

                    <template slot="body">
                        @foreach($providers as $provider)
                            <tr>
                                <td>{{ $provider->id }}</td>
                                <td>{{ $provider->social }}</td>
                                <td>{{ $provider->rfc }}</td>
                                <td>{{ $provider->address }}</td>
                                <td>{{ $provider->email }}</td>
                                <td>{{ $provider->phone }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
@extends('paal.root')

@push('pageTitle')
    Proveedores | Lista
@endpush

@push('headerTitle')
    <a href="{{ route('paal.provider.create') }}" class="btn btn-info btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Lista de proveedores" color="primary" button>

                <data-table example="1">

                    {{ drawHeader('id','proveedor', 'R.F.C', 'dirección', 'correo', 'teléfono','') }}

                    <template slot="body">
                        @foreach($providers as $provider)
                            <tr>
                                <td>{{ $provider->id }}</td>
                                <td>{{ $provider->social }}</td>
                                <td>{{ $provider->rfc }}</td>
                                <td>{{ $provider->address }}</td>
                                <td>{{ $provider->email }}</td>
                                <td>{{ $provider->phone }}</td>
                                <td>
                                    <dropdown icon="cogs" color="primary">
                                        <ddi to="{{ route('paal.provider.edit', ['id'=>$provider->id]) }}" icon="edit" text="Editar"></ddi>
                                        <ddi to="{{ route('paal.provider.destroy', ['id'=>$provider->id]) }}" icon="times" text="Dar de baja"></ddi>
                                    </dropdown>
                                </td>
                            </tr>
                        @endforeach
                    </template>

                </data-table>

            </solid-box>
        </div>
    </div>

@endsection

@extends('paal.root')

@push('pageTitle', 'Proveedores | Lista')

@push('headerTitle')
    <a href="{{ route('paal.provider.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i>&nbsp;&nbsp;<i class="fa fa-truck"></i>&nbsp;&nbsp;&nbsp;AGREGAR
    </a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Lista de proveedores" color="primary">

                <data-table classes="spanish-simple">

                    {{ drawHeader('id', '<i class="fa fa-cogs"></i>', 'nombre', '<i class="fa fa-barcode"></i> - <i class="fa fa-envelope"></i> - <i class="fa fa-phone"></i>', 'dirección') }}

                    <template slot="body">
                        @foreach($providers as $provider)
                            <tr>
                                <td>{{ $provider->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="primary">
                                        <ddi to="{{ route('paal.provider.edit', ['id'=>$provider->id]) }}" icon="edit" text="Editar"></ddi>
                                        <ddi to="{{ route('paal.provider.destroy', ['id'=>$provider->id]) }}" icon="times" text="Dar de baja"></ddi>
                                    </dropdown>
                                </td>
                                <td><b style="color: {{ $provider->color }}">{{ $provider->social }}</b> <br> {{ $provider->name }}</td>
                                <td>
                                    <big><code>{{ $provider->rfc }}</code></big> <br>
                                    <em>{{ $provider->email }}</em> <br>
                                    <span style="color: navy">{{ $provider->phone }}</span>
                                </td>
                                <td>{{ $provider->address }}</td>
                            </tr>
                        @endforeach
                    </template>

                </data-table>

            </solid-box>
        </div>
    </div>

@endsection

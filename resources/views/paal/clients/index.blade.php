@extends('paal.root')

@push('pageTitle')
    Clientes | Lista
@endpush

@push('headerTitle')
    <a href="{{ route('paal.client.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <solid-box title="Productos" color="primary" button>
                
                <data-table example="1">

                    {{ drawHeader('ID', 'Nombre', 'Dirección', 'Teléfono', 'Ciudad') }}

                    <template slot="body">
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>
                                    {{ $client->name }} &nbsp;&nbsp;
                                    <a href="{{ route('paal.client.edit', ['client' => $client->id]) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>{{ $client->address }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->city }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
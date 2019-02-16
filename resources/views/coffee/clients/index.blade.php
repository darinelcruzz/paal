@extends('coffee.root')

@push('pageTitle')
    Clientes | Lista
@endpush

@push('headerTitle')
    <a href="{{ route('coffee.client.create') }}" class="btn btn-danger btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-7">
            <solid-box title="Clientes" color="danger" button>
                
                <data-table example="1">

                    {{ drawHeader('ID', '<i class="fa fa-edit"></i>', 'Nombre', 'R.F.C.', 'correo') }}

                    <template slot="body">
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>
                                    <a href="{{ route('coffee.client.edit', ['client' => $client->id]) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->rfc }}</td>
                                <td>{{ $client->email }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
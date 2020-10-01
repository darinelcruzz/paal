@extends('mbe.root')

@push('pageTitle', 'Clientes')

@push('headerTitle')
    <a href="{{ route('mbe.client.create') }}" class="btn btn-success btn-xs">
        <i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR
    </a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Clientes" color="success" button>
                
                <data-table example="1">

                    <template slot="header">
                        <tr>
                            <th>ID</th>
                            <th><i class="fa fa-cogs"></i></th>
                            <th>Cliente</th>
                            <th>R.F.C.</th>
                        </tr>
                    </template>

                    <template slot="body">
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="success">
                                        <ddi icon="edit" to="{{ route('mbe.client.edit', $client) }}" text="Editar"></ddi>
                                    </dropdown>
                                </td>
                                <td>
                                    {{ $client->name }} <br>
                                </td>
                                <td>
                                    {{ $client->rfc }}
                                </td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection

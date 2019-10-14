@extends('paal.root')

@push('pageTitle')
    Clientes | Lista
@endpush

@push('headerTitle')
    <a href="{{ route('paal.client.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Productos" color="primary" button>
                
                <data-table example="1">

                    {{ drawHeader('ID', 'Nombre', 'Empresa', 'Dirección', 'Teléfono', 'Ciudad') }}

                    <template slot="body">
                        @foreach($clients as $client)
                            <tr>
                                <td style="background-color: {{ $client->company == 'coffee' ? '#faa598': ($client->company == 'mbe' ? '#97f7cb': '#96d5fa') }};">
                                    {{ $client->id }}
                                </td>
                                <td style="width: 35%">
                                    {{ $client->name }} &nbsp;&nbsp;
                                    <a href="{{ route('paal.client.edit', ['client' => $client->id]) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>{{ strtoupper($client->company != 'both'? $client->company: 'mbe/cff') }}</td>
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
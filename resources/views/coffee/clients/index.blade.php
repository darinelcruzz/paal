@extends('coffee.root')

@push('pageTitle')
    Clientes | Lista
@endpush

@push('headerTitle')
    <a href="{{ route('coffee.client.create') }}" class="btn btn-danger btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-9">
            <solid-box title="Clientes" color="danger" button>
                
                <data-table example="1">

                    <template slot="header">
                        <tr>
                            <th>ID</th>
                            <th><i class="fa fa-edit"></i></th>
                            <th>Cliente</th>
                            <th>R.F.C.</th>
                            <th style="width: 30%">Dirección</th>
                        </tr>
                    </template>

                    <template slot="body">
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>
                                    <a href="{{ route('coffee.client.edit', ['client' => $client->id]) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    {{ $client->name }} <br>
                                    <code>{{ $client->email }}</code>
                                </td>
                                <td>
                                    {{ $client->rfc }}
                                </td>
                                <td>
                                    {{ $client->city }} 
                                    {{ $client->state }} <br>                                    
                                    {{ $client->postcode == null || $client->postcode == ' ' ? '' : "C.P. $client->postcode" }}
                                </td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
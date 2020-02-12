@extends('sanson.root')

@push('pageTitle', 'Clientes')

@push('headerTitle')
    <a href="{{ route('sanson.client.create') }}" class="btn btn-info btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Clientes" color="info" button>
                
                <data-table example="1">

                    <template slot="header">
                        <tr>
                            <th>ID</th>
                            <th><i class="fa fa-cogs"></i></th>
                            <th>Cliente</th>
                            <th>R.F.C.</th>
                            <th style="width: 30%">Dirección principal</th>
                            <th style="width: 30%">Dirección (es) de envío</th>
                        </tr>
                    </template>

                    <template slot="body">
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="info">
                                        <ddi icon="edit" to="{{ route('sanson.client.edit', $client) }}" text="Editar"></ddi>
                                        <ddi icon="plus" to="{{ route('sanson.address.create', $client) }}" text="Agregar dirección"></ddi>
                                    </dropdown>
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
                                    {{ $client->state }}                                   
                                    {{ $client->postcode == null || $client->postcode == ' ' ? '' : "C.P. $client->postcode" }}
                                </td>
                                <td>
                                    @foreach ($client->addresses as $address)
                                        @if ($loop->index > 0)
                                            <br>
                                        @endif
                                        {{ $address->street }} 
                                        {{ $address->street_number }} 
                                        {{ $address->city }} 
                                        {{ $address->state }}                                   
                                        {{ $address->postcode == null || $address->postcode == ' ' ? '' : "C.P. $address->postcode" }}
                                        &nbsp;
                                        <a href="{{ route('sanson.address.edit', $address) }}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
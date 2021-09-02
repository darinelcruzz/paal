@extends('coffee.root')

@push('pageTitle', 'Clientes | Lista')

@push('headerTitle')
    @if(auth()->user()->id > 1)
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('coffee.client.create') }}" class="btn btn-danger btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('coffee.client.export') }}" class="btn btn-success btn-sm pull-right">
                <i class="fa fa-file-excel"></i>&nbsp;&nbsp;EXPORTAR&nbsp;&nbsp;<i class="fa fa-file-export"></i>
            </a>
        </div>
        <div class="col-md-4">
            {!! Form::open(['method' => 'post', 'route' => 'coffee.client.import', 'enctype' =>'multipart/form-data']) !!}
            <div class="input-group input-group-sm">
                <input type="file" name="clients" class="form-control">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-file-upload"></i></button>
                </span>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-md-9">
            <a href="{{ route('coffee.client.create') }}" class="btn btn-danger btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('coffee.client.export') }}" class="btn btn-success btn-xs pull-right">
                <i class="fa fa-file-excel"></i>&nbsp;&nbsp;EXPORTAR&nbsp;&nbsp;<i class="fa fa-file-export"></i>
            </a>
        </div>
    </div>
    @endif
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Clientes" color="danger" button>
                
                <table class="table table-striped table-bordered spanish">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th colspan="2" style="text-align: center;"><small>DIRECCIONES</small></th>
                        </tr>
                        <tr>
                            <th style="width: 5%;"><small>ID</small></th>
                            <th style="width: 5%;"><small><i class="fa fa-cogs"></i></small></th>
                            <th style="width: 15%"><small>CLIENTE</small></th>
                            <th style="width: 10%"><small>R.F.C.</small></th>
                            <th style="width: 30%"><small>FACTURACIÓN</small></th>
                            <th><small>ENVÍO</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="danger">
                                        <ddi icon="edit" to="{{ route('coffee.client.edit', $client) }}" text="Editar"></ddi>
                                        <ddi icon="plus" to="{{ route('coffee.address.create', $client) }}" text="Agregar dirección"></ddi>
                                        <ddi icon="mug-hot" to="{{ route('coffee.client.show', [$client, 'ventas']) }}" text="Ventas"></ddi>
                                        <ddi icon="file-pdf" to="{{ route('coffee.client.show', [$client, 'cotizaciones']) }}" text="Cotizaciones"></ddi>
                                    </dropdown>
                                </td>
                                <td>
                                    {{ ucwords(strtolower($client->name)) }} <br>
                                    <span style="color: navy;">{{ $client->email }}</span>
                                </td>
                                <td><code>{{ $client->rfc }}</code></td>
                                <td>
                                @forelse ($client->addresses as $address)
                                @if($loop->index == 0)
                                    <a class="client-address" title="EDITAR" href="{{ route('coffee.address.edit', $address) }}" style="color: #333333;">
                                    {{ ucwords(strtolower($address->street)) }}, #{{ $address->street_number }}
                                    {{ $address->postcode ? '' : "C.P. $address->postcode" }} <br>
                                    {{ ucwords(strtolower($address->city)) . ', ' . ucwords(strtolower($address->state))}}
                                    </a>
                                @endif
                                @empty
                                    {{ ucwords(strtolower($client->address)) }}
                                    {{ "C.P. $client->postcode" }}, 
                                    {{ ucwords(strtolower($client->city)) . ', ' . ucwords(strtolower($client->state))}}
                                @endforelse
                                <td>
                                @foreach ($client->addresses as $address)
                                @if($loop->index > 0)
                                    <a class="client-address" title="EDITAR" href="{{ route('coffee.address.edit', $address) }}" style="color: #333333;">
                                    {{ ucwords(strtolower($address->street)) }}, #{{ $address->street_number }}
                                    {{ $address->postcode ? '' : "C.P. $address->postcode" }} <br>
                                    {{ ucwords(strtolower($address->city)) . ', ' . ucwords(strtolower($address->state))}}
                                    </a>
                                @endif
                                @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>

            </solid-box>
        </div>
    </div>

@endsection
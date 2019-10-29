@extends('mbe.root')

@push('pageTitle')
    Empresariales
@endpush

@section('content')
    <div class="row">
        
        <div class="col-md-12">

            {{-- {!! Form::open(['method' => 'post', 'route' => 'mbe.order.index']) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}

            <br> --}}

            <solid-box title="Empresariales" color="success">
                
                <data-table>

                    <template slot="header">
                        <tr>
                            <th>Nombre</th>
                            <th style="width: 5%"><i class="fa fa-cogs"></i></th>
                            <th style="width: 5%">OTs</th>
                            <th>I.V.A.</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </template>

                    <template slot="body">
                        @foreach($clients as $client)
                            <tr>
                                <td>
                                    {{ $client->name }}
                                </td>
                                <td>
                                    <dropdown icon="cogs" color="success">
                                        <ddi icon="eye" to="{{ route('mbe.order.show', $client) }}" text="Ver órdenes"></ddi>
                                    </dropdown>
                                </td>
                                <td style="text-align: center;">
                                    {{ count($client->ingresses) }}
                                </td>
                                <td>
                                    $ {{ number_format($client->ingresses->sum('iva'), 2) }}
                                </td>
                                <td>
                                    $ {{ number_format($client->ingresses->sum('amount'), 2) }}
                                </td>
                                <td>
                                    @if($client->ingresses->where('invoice_id', '!=', null)->count() == 0)
                                        Sin facturar
                                    @elseif($client->ingresses->where('invoice_id', null)->count() == 0)
                                        Facturado
                                    @else
                                        {{ $client->ingresses->where('invoice_id', null)->count() . ' órdenes por facturar' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </template>   
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
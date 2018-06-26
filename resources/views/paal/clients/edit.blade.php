@extends('paal.root')

@push('pageTitle')
    Clientes | Editar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="Editar cliente" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => ['paal.client.update', $client->id]]) !!}

                    {!! Field::text('name', $client->name, ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                    {!! Field::email('email', $client->email, ['tpl' => 'withicon'], ['icon' => 'at']) !!}
                    {!! Field::text('phone', $client->phone, ['tpl' => 'withicon'], ['icon' => 'phone']) !!}
                    {!! Field::text('address', $client->address, ['tpl' => 'withicon'], ['icon' => 'map-signs']) !!}
                    {!! Field::text('city', $client->city, ['tpl' => 'withicon'], ['icon' => 'globe']) !!}

                    <button type="submit" class="btn btn-primary pull-right">Editar</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
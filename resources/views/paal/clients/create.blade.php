@extends('paal.root')

@push('pageTitle')
    Clientes | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="Agregar cliente" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => 'paal.client.store']) !!}

                    {!! Field::text('name', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                    {!! Field::email('email', ['tpl' => 'withicon'], ['icon' => 'at']) !!}
                    {!! Field::text('phone', ['tpl' => 'withicon'], ['icon' => 'phone']) !!}
                    {!! Field::text('address', ['tpl' => 'withicon'], ['icon' => 'map-signs']) !!}
                    {!! Field::text('city', ['tpl' => 'withicon'], ['icon' => 'globe']) !!}

                    <button type="submit" class="btn btn-primary pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
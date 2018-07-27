@extends('paal.root')

@push('pageTitle')
    Clientes | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            <solid-box title="Agregar cliente" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => 'paal.client.store']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('name', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::email('email', ['tpl' => 'withicon'], ['icon' => 'at']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('rfc', ['tpl' => 'withicon', 'label' => 'R.F.C.'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('company', ['coffee' => 'Coffee', 'mbe' => 'Mailboxes', 'both' => 'Ambas'], null, ['tpl' => 'withicon', 'empty' => 'Seleccione una empresa'], ['icon' => 'industry']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('phone', ['tpl' => 'withicon'], ['icon' => 'phone']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('address', ['tpl' => 'withicon'], ['icon' => 'map-signs']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('postcode', ['tpl' => 'withicon'], ['icon' => 'envelope']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('city', ['tpl' => 'withicon'], ['icon' => 'location-arrow']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('state', ['tpl' => 'withicon'], ['icon' => 'globe']) !!}
                        </div>
                    </div>                    

                    <button type="submit" class="btn btn-primary pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
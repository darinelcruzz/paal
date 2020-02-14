@extends('sanson.root')

@push('pageTitle', 'Dirección | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <solid-box title="Agregar dirección de envío" color="info" button>

                {!! Form::open(['method' => 'POST', 'route' => ['sanson.address.store', $client]]) !!}

                    {!! Field::text('business_name', ['tpl' => 'withicon'], ['icon' => 'comment']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('contact', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('phone', ['tpl' => 'withicon'], ['icon' => 'phone']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('street', ['tpl' => 'withicon'], ['icon' => 'road']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::text('street_number', ['tpl' => 'withicon'], ['icon' => 'hashtag']) !!}
                        </div>

                        <div class="col-md-3">
                            {!! Field::text('street_number2', ['tpl' => 'withicon'], ['icon' => 'hashtag']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('district', ['tpl' => 'withicon'], ['icon' => 'map-marker-alt']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('postcode', ['tpl' => 'withicon'], ['icon' => 'mail-bulk']) !!}
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('city', ['tpl' => 'withicon'], ['icon' => 'city']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('state', ['tpl' => 'withicon'], ['icon' => 'flag']) !!}
                        </div>
                    </div>
                    
                    {!! Field::text('reference', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}

                    <hr>

                    <button type="submit" class="btn btn-info pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
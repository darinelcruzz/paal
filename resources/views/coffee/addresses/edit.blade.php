@extends('coffee.root')

@push('pageTitle')
    Dirección | Editar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <solid-box title="Editar dirección de envío" color="danger" button>

                {!! Form::open(['method' => 'POST', 'route' => ['coffee.address.update', $address]]) !!}

                    {!! Field::text('business_name', $address->business_name, ['tpl' => 'withicon'], ['icon' => 'comment']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('contact', $address->contact, ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('phone', $address->phone, ['tpl' => 'withicon'], ['icon' => 'phone']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('street', $address->street, ['tpl' => 'withicon'], ['icon' => 'road']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::text('street_number', $address->street_number, ['tpl' => 'withicon'], ['icon' => 'hashtag']) !!}
                        </div>

                        <div class="col-md-3">
                            {!! Field::text('street_number2', $address->street_number2, ['tpl' => 'withicon'], ['icon' => 'hashtag']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('district', $address->district, ['tpl' => 'withicon'], ['icon' => 'map-marker-alt']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('postcode', $address->postcode, ['tpl' => 'withicon'], ['icon' => 'mail-bulk']) !!}
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('city', $address->city, ['tpl' => 'withicon'], ['icon' => 'city']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('state', $address->state, ['tpl' => 'withicon'], ['icon' => 'flag']) !!}
                        </div>
                    </div>
                    
                    {!! Field::text('reference', $address->reference, ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}

                    <hr>

                    <button type="submit" class="btn btn-danger pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
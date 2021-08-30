@extends('coffee.root')

@push('pageTitle', 'Clientes | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Agregar cliente" color="danger" button>

                {!! Form::open(['method' => 'POST', 'route' => 'coffee.client.store']) !!}
                    
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('name', ['tpl' => 'withicon'], ['icon' => 'comments']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::text('rfc', ['tpl' => 'withicon', 'label' => 'R.F.C.'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::text('email', ['tpl' => 'withicon'], ['icon' => 'at']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('businessname', ['tpl' => 'withicon', 'label' => 'Razón social'], ['icon' => 'signature']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::text('contact', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::text('phone', ['tpl' => 'withicon'], ['icon' => 'phone']) !!}
                        </div>
                    </div>

                    <h4>Dirección</h4>
                    <hr>

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
                        <div class="col-md-3">
                            {!! Field::text('state', ['tpl' => 'withicon'], ['icon' => 'flag']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::text('city', ['tpl' => 'withicon'], ['icon' => 'city']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::text('district', ['tpl' => 'withicon'], ['icon' => 'map-marker-alt']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::text('postcode', ['tpl' => 'withicon'], ['icon' => 'mail-bulk']) !!}
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('reference', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::checkbox('envio', [], ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-danger pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection

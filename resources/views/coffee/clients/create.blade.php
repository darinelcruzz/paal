@extends('coffee.root')

@push('pageTitle', 'Clientes | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Agregar cliente" color="warning" button>

                {!! Form::open(['method' => 'POST', 'route' => 'coffee.client.store']) !!}
                    
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('name', ['tpl' => 'withicon'], ['icon' => 'comments']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::text('rfc', ['tpl' => 'withicon', 'label' => 'R.F.C.'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::select('tax_regime_id', $regimes, null, ['tpl' => 'withicon', 'empty' => 'Elija una opción'], ['icon' => 'comments']) !!}
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

                    <div class="row">
                        <div class="col-md-3">
                            {!! Field::text('email', ['tpl' => 'withicon'], ['icon' => 'at']) !!}
                        </div>
                    </div>

                    <h4>Dirección de facturación</h4>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('items[0][street]', ['tpl' => 'withicon', 'label' => 'Calle', 'ph' => 'Avenida/Calle...'], ['icon' => 'road']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::text('items[0][street_number]', ['tpl' => 'withicon', 'label' => 'Número interior'], ['icon' => 'hashtag']) !!}
                        </div>

                        <div class="col-md-3">
                            {!! Field::text('items[0][street_number2]', ['tpl' => 'withicon', 'label' => 'Número exterior'], ['icon' => 'hashtag']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <conditioned-select
                                name="items[0][state]" label="Estado" model="states" :loaded="true" icon="globe-americas"
                                emitting="counties" recieving="states">
                            </conditioned-select>
                        </div>
                        <div class="col-md-3">
                            <conditioned-select
                                name="items[0][county]" label="Municipio" model="counties" icon="map-marked-alt"
                                emitting="cities" recieving="states">
                            </conditioned-select>
                        </div>
                        <div class="col-md-3">
                            <conditioned-select 
                                name="items[0][city]" label="Ciudad/Localidad" model="cities" icon="city"
                                emitting="" recieving="counties">
                            </conditioned-select>
                        </div>
                        <div class="col-md-3">
                            {!! Field::text('items[0][district]', ['tpl' => 'withicon', 'label' => 'Colonia'], ['icon' => 'map-marker-alt']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {!! Field::text('items[0][postcode]', ['tpl' => 'withicon', 'label' => 'Código postal', 'ph' => '29XXX'], ['icon' => 'mail-bulk']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('items[0][reference]', ['tpl' => 'withicon', 'label' => 'Referencia', 'ph' => 'Casa color...'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::select('shipping_address', 
                                ['La misma que la de facturación', 'Diferente a la de facturación'], 0, 
                                ['tpl' => 'withicon', 'empty' => 'Elegir opción', 'v-model' => 'provider'], 
                                ['icon' => 'shipping-fast'])
                            !!}
                        </div>
                    </div>

                    <div v-if="provider == 1">
                        <h4>Dirección de envío</h4>
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::text('items[1][street]', ['tpl' => 'withicon', 'label' => 'Calle'], ['icon' => 'road']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Field::text('items[1][street_number]', ['tpl' => 'withicon', 'label' => 'Número interior'], ['icon' => 'hashtag']) !!}
                            </div>

                            <div class="col-md-3">
                                {!! Field::text('items[1][street_number2]', ['tpl' => 'withicon', 'label' => 'Número exterior'], ['icon' => 'hashtag']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                {!! Field::select('items[1][state]', $states, 'chiapas', ['tpl' => 'withicon', 'label' => 'Estado', 'empty' => 'Elija un estado'], ['icon' => 'flag']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Field::text('items[1][city]', ['tpl' => 'withicon', 'label' => 'Ciudad'], ['icon' => 'city']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Field::text('items[1][district]', ['tpl' => 'withicon', 'label' => 'Colonia'], ['icon' => 'map-marker-alt']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Field::text('items[1][postcode]', ['tpl' => 'withicon', 'label' => 'Código postal'], ['icon' => 'mail-bulk']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::text('items[1][reference]', ['tpl' => 'withicon', 'label' => 'Referencia'], ['icon' => 'barcode']) !!}
                            </div>
                        </div>
                    </div>

                    <hr>
                    <input type="hidden" name="company" value="coffee">
                    <button type="submit" class="btn btn-warning pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection

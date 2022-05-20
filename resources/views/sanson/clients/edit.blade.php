@extends('sanson.root')

@push('pageTitle', 'Clientes | Editar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar cliente" color="info" button>

                {!! Form::open(['method' => 'POST', 'route' => ['sanson.client.update', $client]]) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('name', $client->name, ['tpl' => 'withicon'], ['icon' => 'comments']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('rfc', $client->rfc, ['tpl' => 'withicon', 'label' => 'R.F.C.'], ['icon' => 'barcode']) !!}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('tax_regime_id', $regimes, $client->tax_regime_id, ['tpl' => 'withicon', 'empty' => 'Elija una opción'], ['icon' => 'comments']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('email', $client->email, ['tpl' => 'withicon'], ['icon' => 'at']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('city', $client->city, ['label' => 'Ciudad/Municipio', 'tpl' => 'withicon'], ['icon' => 'map']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('state', $client->state, ['tpl' => 'withicon'], ['icon' => 'globe']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('postcode', $client->postcode, ['tpl' => 'withicon'], ['icon' => 'envelope']) !!}
                        </div>
                    </div>

                    <hr>
                    
                    <button type="submit" class="btn btn-info pull-right">MODIFICAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
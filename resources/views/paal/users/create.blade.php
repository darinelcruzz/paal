@extends('paal.root')

@push('pageTitle', 'Usuarios | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar usuario" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => 'paal.user.store']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('name', ['tpl' => 'withicon'], ['icon' => 'comment']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::email('email', ['tpl' => 'withicon'], ['icon' => 'at']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('company_id', $companies->toArray(), null, ['tpl' => 'withicon', 'empty' => 'Seleccione una empresa', 'v-model.number' => 'provider'], ['icon' => 'industry']) !!}
                        </div>
                        <div v-if="provider == 1" class="col-md-6">
                            {!! Field::select('store_id', $stores1->toArray(), null, ['tpl' => 'withicon', 'empty' => 'Seleccione una tienda'], ['icon' => 'store']) !!}
                        </div>
                        <div v-else-if="provider == 2" class="col-md-6">
                            {!! Field::select('store_id', $stores2->toArray(), null, ['tpl' => 'withicon', 'empty' => 'Seleccione una tienda'], ['icon' => 'store']) !!}
                        </div>
                        <div v-else-if="provider == 3" class="col-md-6">
                            {!! Field::select('store_id', $stores3->toArray(), null, ['tpl' => 'withicon', 'empty' => 'Seleccione una tienda'], ['icon' => 'store']) !!}
                        </div>
                        <div v-else class="col-md-6">
                            {!! Field::select('store_id', ['a' => 'a'], null, ['tpl' => 'withicon', 'empty' => 'Seleccione una tienda', 'disabled'], ['icon' => 'store']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('level', 
                                ['Admin', 'Gerente', 'Vendedor/Auxiliar'],
                                null, ['tpl' => 'withicon', 'empty' => 'Seleccione un nivel'], ['icon' => 'layer-group']) 
                            !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('username', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::password('password', ['tpl' => 'withicon'], ['icon' => 'unlock-alt']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::password('password_confirmation', ['tpl' => 'withicon'], ['icon' => 'lock']) !!}
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-sm btn-primary pull-right">A G R E G A R</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection

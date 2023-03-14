@extends('paal.root')

@push('pageTitle', 'Usuarios | Editar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Editar usuario" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => ['paal.user.update', $user->id]]) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('name', $user->name, ['tpl' => 'withicon'], ['icon' => 'comment']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::email('email', $user->email, ['tpl' => 'withicon'], ['icon' => 'at']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('company_id', $companies->toArray(), $user->company_id, ['tpl' => 'withicon', 'empty' => 'Seleccione una empresa', 'v-model.number' => 'provider'], ['icon' => 'industry']) !!}
                        </div>
                        <div v-if="provider == 1" class="col-md-6">
                            {!! Field::select('store_id', $stores1->toArray(), $user->store_id, ['tpl' => 'withicon', 'empty' => 'Seleccione una tienda'], ['icon' => 'store']) !!}
                        </div>
                        <div v-else-if="provider == 2" class="col-md-6">
                            {!! Field::select('store_id', $stores2->toArray(), $user->store_id, ['tpl' => 'withicon', 'empty' => 'Seleccione una tienda'], ['icon' => 'store']) !!}
                        </div>
                        <div v-else-if="provider == 3" class="col-md-6">
                            {!! Field::select('store_id', $stores3->toArray(), $user->store_id, ['tpl' => 'withicon', 'empty' => 'Seleccione una tienda'], ['icon' => 'store']) !!}
                        </div>
                        <div v-else class="col-md-6">
                            {!! Field::select('store_id', ['a' => 'a'], $user->store_id, ['tpl' => 'withicon', 'empty' => 'Seleccione una tienda', 'disabled'], ['icon' => 'store']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('level', 
                                ['Admin', 'Gerente', 'Vendedor/Auxiliar'],
                                $user->level, ['tpl' => 'withicon', 'empty' => 'Seleccione un nivel'], ['icon' => 'layer-group']) 
                            !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('username', $user->username, ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::password('password', ['tpl' => 'withicon'], ['icon' => 'unlock-alt']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::password('password_confirmation', ['tpl' => 'withicon'], ['icon' => 'lock']) !!}
                        </div>
                    </div>
                    

                    <button type="submit" class="btn btn-primary pull-right">E D I T A R</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
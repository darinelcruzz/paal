@extends('paal.root')

@push('pageTitle')
    Usuarios | Editar
@endpush

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
                            {!! Field::text('username', $user->username, ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::email('email', $user->email, ['tpl' => 'withicon'], ['icon' => 'at']) !!}
                        </div>
                        @if($user->company != 'owner')
                        <div class="col-md-6">
                            {!! Field::select('company', 
                                ['coffee' => 'Coffee Depot', 'mbe' => 'MBE', 'both' => 'COFFEE/MBE', 'sanson' => 'SANSON', 'paal' => 'PAAL'], 
                                $user->company, ['tpl' => 'withicon', 'empty' => 'Seleccione una empresa'], ['icon' => 'industry']) 
                            !!}
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('level', 
                                ['Admin', 'General', 'Gerente', 'Auxiliar'], 
                                $user->level, ['tpl' => 'withicon', 'empty' => 'Seleccione un nivel'], ['icon' => 'layer-group']) 
                            !!}
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
                    

                    <button type="submit" class="btn btn-primary pull-right">Editar</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
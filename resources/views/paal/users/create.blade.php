@extends('paal.root')

@push('pageTitle')
    Usuarios | Agregar
@endpush

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
                            {!! Field::text('username', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::email('email', ['tpl' => 'withicon'], ['icon' => 'at']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('company', 
                                ['coffee' => 'Coffee Depot', 'mbe' => 'MBE', 'paal' => 'PAAL'], 
                                null, ['tpl' => 'withicon', 'empty' => 'Seleccione una empresa'], ['icon' => 'industry']) 
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
                    

                    <button type="submit" class="btn btn-primary pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
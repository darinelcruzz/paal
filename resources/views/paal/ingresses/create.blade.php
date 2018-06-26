@extends('paal.root')

@push('pageTitle')
    Ingresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-7">
            <solid-box title="Agregar ingreso" color="primary" button>
                {!! Form::open(['method' => 'POST', 'route' => 'paal.ingress.store']) !!}
                    
                    {!! Field::select('client_id', $clients, null,
                        ['tpl' => 'withicon', 'label' => 'Cliente','empty' => 'Seleccione un cliente'],
                        ['icon' => 'user'])
                    !!}

                    <dynamic-inputs></dynamic-inputs>
                    <hr>
                    <button type="submit" class="btn btn-primary pull-right" onclick="submitForm(this);">Agregar</button>

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection

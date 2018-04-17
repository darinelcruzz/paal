@extends('coffee.root')

@push('pageTitle')
    PAAL | Proveedores | Agregar
@endpush

@push('headerTitle')
    Proveedor <small>AGREGAR</small>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Una caja" color="success" button>
                {!! Form::open(['method' => 'POST', 'route' => 'provider.store']) !!}

                    {!! Field::text('social', ['label' => 'Razón social', 'tpl' => 'withicon'], ['icon' => 'truck']) !!}
                    {!! Field::text('name', ['label' => 'Nombre comercial', 'tpl' => 'withicon'], ['icon' => 'comment-o']) !!}
                    {!! Field::text('address', ['label' => 'Dirección', 'tpl' => 'withicon'], ['icon' => 'globe']) !!}
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('rfc', ['label' => 'R.F.C.', 'tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('email', ['label' => 'Correo', 'tpl' => 'withicon'], ['icon' => 'at']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('contact', ['label' => 'Contacto', 'tpl' => 'withicon'], ['icon' => 'user']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('phone', ['label' => 'Teléfono', 'tpl' => 'withicon'], ['icon' => 'phone']) !!}
                        </div>
                    </div>

                    {!! Form::submit('Agregar', ['class' => 'btn btn-success pull-right']) !!}
                    
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
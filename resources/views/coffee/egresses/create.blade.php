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
            <solid-box title="" color="danger" button>
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.egress.store', 'enctype' => 'multipart/form-data']) !!}

                    {!! Field::select('provider', $providers, null,
                        ['tpl' => 'withicon', 'empty' => 'Seleccione un proveedor'], 
                        ['icon' => 'truck']) 
                    !!}

                    {!! Field::date('buying_date', Date::now(), ['tpl' => 'withicon'], ['icon' => 'shopping-cart']) !!}
                    {!! Field::date('payment_date', Date::now(), ['tpl' => 'withicon'], ['icon' => 'dollar']) !!}

                    <label>Factura</label>

                    <div class="row">
                        <div class="col-md-6">
                            <file-upload fname="pdf_bill" ext="pdf"></file-upload>
                        </div>
                        <div class="col-md-6">
                            <file-upload fname="xml" ext="xml"></file-upload>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('amount', ['tpl' => 'withicon'], ['icon' => 'money']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('iva', ['tpl' => 'withicon'], ['icon' => 'bank']) !!}
                        </div>
                    </div>

                    <hr>

                    {!! Form::submit('Agregar', ['class' => 'btn btn-danger pull-right']) !!}
                    
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection